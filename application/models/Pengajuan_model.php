<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // Muat library session jika Anda berencana menggunakan session data (misal: id_cabang)
        $this->load->library('session');
    }

    /**
     * Fungsi utama untuk mendapatkan semua pengajuan (termasuk filter keyword)
     */
    public function get_all($keyword = null)
    {
        $this->db->select('
            ip.id,
            ip.nomor_form,
            ip.tanggal_form,
            ip.nama_aset,
            ip.quantity_aset,
            ip.estimasi_harga,
            ip.keterangan,
            c.nama_cabang AS cabang,
            dp.status AS overall_status,
            dp.status_kacab,
            dp.status_am,
            dp.status_ho,
            dp.tanggal_dibuat AS submitted_date
        ');
        $this->db->from('input_pengajuan ip');
        $this->db->join('cabang c', 'c.id = ip.id_cabang', 'left');
        $this->db->join('daftar_pengajuan dp', 'dp.id_pengajuan = ip.id', 'left');

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('ip.nama_aset', $keyword);
            $this->db->or_like('ip.kode_aset', $keyword);
            $this->db->or_like('ip.nomor_form', $keyword);
            $this->db->or_like('c.nama_cabang', $keyword);
            $this->db->group_end();
        }
        $this->db->order_by('ip.tanggal_form', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Mendapatkan detail pengajuan berdasarkan ID
     */
    public function get_by_id($id)
    {
        $this->db->select('
            ip.*,
            c.nama_cabang AS cabang,
            dp.status AS overall_status,
            dp.status_kacab,
            dp.status_am,
            dp.status_ho,
            dp.tanggal_dibuat AS submitted_date
        ');
        $this->db->from('input_pengajuan ip');
        $this->db->join('cabang c', 'c.id = ip.id_cabang', 'left');
        $this->db->join('daftar_pengajuan dp', 'dp.id_pengajuan = ip.id', 'left');
        $this->db->where('ip.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Memasukkan data pengajuan baru
     */
    public function insert($data)
    {
        return $this->db->insert('input_pengajuan', $data);
    }

    /**
     * Memperbarui data pengajuan berdasarkan ID
     */
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('input_pengajuan', $data);
    }

    /**
     * Menghapus pengajuan berdasarkan ID
     */
    public function delete($id)
    {
        // Hapus entri terkait di daftar_pengajuan terlebih dahulu
        $this->db->where('id_pengajuan', $id)->delete('daftar_pengajuan');
        // Kemudian hapus dari input_pengajuan
        return $this->db->delete('input_pengajuan', ['id' => $id]);
    }

    /**
     * Mendapatkan pengajuan yang difilter berdasarkan rentang tanggal dan keyword
     */
    public function get_filtered_by_date($mulai, $sampai, $keyword = null)
    {
        $this->db->select('
            ip.id,
            ip.nomor_form,
            ip.tanggal_form,
            ip.nama_aset,
            ip.quantity_aset,
            ip.estimasi_harga,
            ip.keterangan,
            c.nama_cabang AS cabang,
            dp.status AS overall_status,
            dp.status_kacab,
            dp.status_am,
            dp.status_ho,
            dp.tanggal_dibuat AS submitted_date
        ');
        $this->db->from('input_pengajuan ip');
        $this->db->join('cabang c', 'c.id = ip.id_cabang', 'left');
        $this->db->join('daftar_pengajuan dp', 'dp.id_pengajuan = ip.id', 'left');

        $this->db->where('ip.tanggal_form >=', $mulai);
        $this->db->where('ip.tanggal_form <=', $sampai);

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('ip.nama_aset', $keyword);
            $this->db->or_like('ip.kode_aset', $keyword);
            $this->db->or_like('ip.nomor_form', $keyword);
            $this->db->or_like('c.nama_cabang', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('ip.tanggal_form', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Mendapatkan semua pengajuan yang statusnya sudah disubmit/approved/rejected
     */
    public function get_all_submitted()
    {
        $this->db->select('
            ip.id,
            ip.nomor_form,
            ip.tanggal_form,
            ip.nama_aset,
            ip.quantity_aset,
            ip.estimasi_harga,
            ip.keterangan,
            c.nama_cabang AS nama_cabang,
            dp.status AS overall_status,
            dp.status_kacab,
            dp.status_am,
            dp.status_ho
        ');
        $this->db->from('input_pengajuan ip');
        $this->db->join('cabang c', 'c.id = ip.id_cabang', 'left');
        $this->db->join('daftar_pengajuan dp', 'dp.id_pengajuan = ip.id', 'inner');
        $this->db->where_in('dp.status', ['Submitted', 'Approved', 'Rejected']);
        $this->db->order_by('ip.tanggal_form', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Memperbarui status approval berdasarkan role
     */
    public function update_approval($id_pengajuan, $role, $status)
    {
        $column = 'status_' . $role;
        $this->db->where('id_pengajuan', $id_pengajuan)->update('daftar_pengajuan', [$column => $status]);
    }

    /**
     * Mendapatkan pengajuan yang sudah disetujui semua pihak (Kacab, AM, HO)
     */
    public function get_approved_pengajuan()
    {
        $this->db->select('
            ip.*,
            c.nama_cabang AS cabang,
            dp.status AS overall_status,
            dp.status_kacab,
            dp.status_am,
            dp.status_ho,
            dp.tanggal_dibuat AS submitted_date
        ');
        $this->db->from('input_pengajuan ip');
        $this->db->join('cabang c', 'c.id = ip.id_cabang', 'left');
        $this->db->join('daftar_pengajuan dp', 'dp.id_pengajuan = ip.id', 'inner');
        $this->db->where('dp.status_kacab', 'approved');
        $this->db->where('dp.status_am', 'approved');
        $this->db->where('dp.status_ho', 'approved');
        $this->db->where('dp.status', 'Submitted'); // Hanya pengajuan yang masih dalam proses "Submitted" hingga selesai
        return $this->db->get()->result();
    }

    /**
     * Mendapatkan laporan pengajuan yang difilter
     */
    public function get_filtered_laporan($mulai = null, $sampai = null, $status = null, $cabang = null)
    {
        $this->db->select('
            ip.*,
            c.nama_cabang AS cabang,
            dp.status AS overall_status,
            dp.status_kacab,
            dp.status_am,
            dp.status_ho
        ');
        $this->db->from('input_pengajuan ip');
        $this->db->join('cabang c', 'c.id = ip.id_cabang', 'left');
        $this->db->join('daftar_pengajuan dp', 'dp.id_pengajuan = ip.id', 'left');

        if ($mulai && $sampai) {
            $this->db->where('ip.tanggal_form >=', $mulai);
            $this->db->where('ip.tanggal_form <=', $sampai);
        }

        if ($status) {
            $this->db->where('dp.status', $status);
        }

        if ($cabang) {
            $this->db->where('ip.id_cabang', $cabang);
        }

        $this->db->order_by('ip.tanggal_form', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Memperbarui status field di tabel daftar_pengajuan
     */
    public function update_status($id_pengajuan, $field, $value)
    {
        $this->db->where('id_pengajuan', $id_pengajuan);
        return $this->db->update('daftar_pengajuan', [$field => $value]);
    }

    /**
     * Mendapatkan draft pengajuan (untuk pengajuan/index.php)
     */
    public function get_draft_pengajuan()
    {
        $this->db->select('
            ip.id,
            ip.nomor_form,
            ip.tanggal_form,
            ip.nama_aset,
            ip.quantity_aset,
            ip.estimasi_harga,
            ip.keterangan,
            ip.status,
            ip.id_cabang, 
            ip.kode_aset
        ');
        $this->db->from('input_pengajuan ip');
        $this->db->where('ip.status', 'Draft');
        $this->db->order_by('ip.tanggal_form', 'DESC');
        return $this->db->get()->result();
    }

    // --- FUNGSI UNTUK NOTIFIKASI APPROVAL ---

    /**
     * Mendapatkan jumlah pengajuan pending untuk Kacab
     * @param int|null $id_cabang ID cabang jika Kacab hanya melihat pengajuan dari cabangnya.
     */
    public function count_pending_kacab_approvals($id_cabang = null)
    {
        $this->db->from('daftar_pengajuan dp');
        $this->db->join('input_pengajuan ip', 'ip.id = dp.id_pengajuan', 'inner'); // Penting untuk join jika filter id_cabang digunakan
        $this->db->where('dp.status_kacab', 'pending');
        $this->db->where('dp.status', 'Submitted'); // Hanya yang sudah disubmit ke sistem approval

        // Uncomment baris ini jika Kacab hanya melihat pengajuan dari cabangnya
        // if ($id_cabang) {
        //     $this->db->where('ip.id_cabang', $id_cabang);
        // }
        return $this->db->count_all_results();
    }

    /**
     * Mendapatkan daftar pengajuan pending untuk Kacab
     * @param int|null $id_cabang ID cabang jika Kacab hanya melihat pengajuan dari cabangnya.
     */
    public function get_pending_kacab_approvals($id_cabang = null)
    {
        $this->db->select('dp.id_pengajuan, ip.nomor_form, ip.nama_aset, ip.tanggal_form');
        $this->db->from('daftar_pengajuan dp');
        $this->db->join('input_pengajuan ip', 'ip.id = dp.id_pengajuan', 'inner'); // Ambil detail dari input_pengajuan
        $this->db->where('dp.status_kacab', 'pending');
        $this->db->where('dp.status', 'Submitted');

        // Uncomment baris ini jika Kacab hanya melihat pengajuan dari cabangnya
        // if ($id_cabang) {
        //     $this->db->where('ip.id_cabang', $id_cabang);
        // }
        $this->db->order_by('ip.tanggal_form', 'ASC');
        $this->db->limit(5); // Batasi untuk dropdown notifikasi
        return $this->db->get()->result();
    }

    /**
     * Mendapatkan jumlah pengajuan pending untuk Area Manager (AM)
     * Hanya pengajuan yang status_kacabnya 'approved' dan status_amnya 'pending'.
     */
    public function count_pending_am_approvals()
    {
        $this->db->from('daftar_pengajuan dp'); // Tambahkan alias dp
        $this->db->join('input_pengajuan ip', 'ip.id = dp.id_pengajuan', 'inner'); // Tambahkan join
        $this->db->where('dp.status_kacab', 'approved'); // Gunakan alias dp
        $this->db->where('dp.status_am', 'pending');     // Gunakan alias dp
        $this->db->where('dp.status', 'Submitted');
        return $this->db->count_all_results();
    }

    /**
     * Mendapatkan daftar pengajuan pending untuk AM
     */
    public function get_pending_am_approvals()
    {
        $this->db->select('dp.id_pengajuan, ip.nomor_form, ip.nama_aset, ip.tanggal_form');
        $this->db->from('daftar_pengajuan dp');
        $this->db->join('input_pengajuan ip', 'ip.id = dp.id_pengajuan', 'inner');
        $this->db->where('dp.status_kacab', 'approved');
        $this->db->where('dp.status_am', 'pending');
        $this->db->where('dp.status', 'Submitted');
        $this->db->order_by('ip.tanggal_form', 'ASC');
        $this->db->limit(5);
        return $this->db->get()->result();
    }

    /**
     * Mendapatkan jumlah pengajuan pending untuk Head Office (HO)
     * Hanya pengajuan yang status_kacabnya 'approved', status_amnya 'approved', dan status_honya 'pending'.
     */
    public function count_pending_ho_approvals()
    {
        $this->db->from('daftar_pengajuan dp'); // Tambahkan alias dp
        $this->db->join('input_pengajuan ip', 'ip.id = dp.id_pengajuan', 'inner'); // Tambahkan join
        $this->db->where('dp.status_kacab', 'approved'); // Gunakan alias dp
        $this->db->where('dp.status_am', 'approved');
        $this->db->where('dp.status_ho', 'pending'); // Menunggu approval HO
        $this->db->where('dp.status', 'Submitted');
        return $this->db->count_all_results();
    }

    /**
     * Mendapatkan daftar pengajuan pending untuk HO
     */
    public function get_pending_ho_approvals()
    {
        $this->db->select('dp.id_pengajuan, ip.nomor_form, ip.nama_aset, ip.tanggal_form');
        $this->db->from('daftar_pengajuan dp');
        $this->db->join('input_pengajuan ip', 'ip.id = dp.id_pengajuan', 'inner');
        $this->db->where('dp.status_kacab', 'approved');
        $this->db->where('dp.status_am', 'approved');
        $this->db->where('dp.status_ho', 'pending');
        $this->db->where('dp.status', 'Submitted');
        $this->db->order_by('ip.tanggal_form', 'ASC');
        $this->db->limit(5);
        return $this->db->get()->result();
    }

    /**
     * Fungsi umum untuk menghitung semua pengajuan pending berdasarkan role
     * Ini bisa menggantikan count_pending_kacab/am/ho_approvals jika digunakan
     * secara konsisten di controller.
     */
    public function count_all_pending_for_current_role($role, $id_cabang = null)
    {
        $this->db->from('daftar_pengajuan dp');
        $this->db->join('input_pengajuan ip', 'ip.id = dp.id_pengajuan', 'inner');
        $this->db->where('dp.status', 'Submitted'); // Hanya pengajuan yang sudah disubmit

        if ($role === 'kacab') {
            $this->db->where('dp.status_kacab', 'pending');
            // Jika Kacab hanya melihat pengajuan dari cabangnya:
            // if ($id_cabang) {
            //     $this->db->where('ip.id_cabang', $id_cabang);
            // }
        } elseif ($role === 'am') {
            $this->db->where('dp.status_kacab', 'approved'); // Harus sudah disetujui Kacab
            $this->db->where('dp.status_am', 'pending');
        } elseif ($role === 'ho') {
            $this->db->where('dp.status_kacab', 'approved'); // Harus sudah disetujui Kacab
            $this->db->where('dp->status_am', 'approved');     // Harus sudah disetujui AM
            $this->db->where('dp.status_ho', 'pending');
        } else {
            return 0; // Role lain mungkin tidak memiliki notifikasi verifikasi
        }
        return $this->db->count_all_results();
    }

    /**
     * Fungsi untuk detail pengajuan yang akan di-approve
     */
    public function get_pengajuan_detail_for_approval($id_pengajuan)
    {
        $this->db->select('dp.*, ip.nomor_form, ip.nama_aset, ip.quantity_aset, ip.estimasi_harga, ip.keterangan, ip.tanggal_form, c.nama_cabang');
        $this->db->from('daftar_pengajuan dp');
        $this->db->join('input_pengajuan ip', 'ip.id = dp.id_pengajuan', 'inner');
        $this->db->join('cabang c', 'c.id = ip.id_cabang', 'left'); // Tambahkan join ke tabel cabang
        $this->db->where('dp.id_pengajuan', $id_pengajuan);
        return $this->db->get()->row();
    }

    /**
     * Fungsi untuk memproses approval
     */
    public function process_pengajuan_approval($id_pengajuan, $role, $action, $catatan = null)
    {
        $data = [];
        $status_field = '';
        $catatan_field = ''; // Inisialisasi

        if ($role === 'kacab') {
            $status_field = 'status_kacab';
            $catatan_field = 'catatan_kacab';
        } elseif ($role === 'am') {
            $status_field = 'status_am';
            $catatan_field = 'catatan_am';
        } elseif ($role === 'ho') {
            $status_field = 'status_ho';
            $catatan_field = 'catatan_ho';
        } else {
            return false; // Role tidak valid
        }

        // Cek status saat ini sebelum update untuk mencegah double approve atau salah urutan
        $current_status = $this->db->select($status_field)->get_where('daftar_pengajuan', ['id_pengajuan' => $id_pengajuan])->row();

        // Memastikan status saat ini adalah 'pending' untuk role yang bersangkutan
        if ($current_status && $current_status->$status_field === 'pending') {
            $data[$status_field] = $action; // 'approved' atau 'rejected'

            if ($catatan) {
                $data[$catatan_field] = $catatan;
            }

            // Update tanggal_approval_kacab/am/ho
            if ($action === 'approved') {
                $data['tanggal_approval_' . $role] = date('Y-m-d H:i:s');
            }

            $this->db->where('id_pengajuan', $id_pengajuan);
            $success = $this->db->update('daftar_pengajuan', $data);

            // Jika semua sudah approved, update status keseluruhan menjadi 'Approved'
            if ($success && $action === 'approved') {
                $pengajuan = $this->db->get_where('daftar_pengajuan', ['id_pengajuan' => $id_pengajuan])->row();
                if ($pengajuan->status_kacab === 'approved' && $pengajuan->status_am === 'approved' && $pengajuan->status_ho === 'approved') {
                    $this->db->where('id_pengajuan', $id_pengajuan)->update('daftar_pengajuan', ['status' => 'Approved']);
                } elseif ($action === 'rejected') {
                    $this->db->where('id_pengajuan', $id_pengajuan)->update('daftar_pengajuan', ['status' => 'Rejected']);
                }
            }
            return $success;
        }
        return false; // Gagal update karena status tidak 'pending' atau tidak ditemukan
    }

    /**
     * Fungsi untuk mendapatkan semua pengajuan berdasarkan role (untuk halaman daftar)
     * PERHATIAN: Fungsi-fungsi ini bersifat placeholder. 
     * Anda perlu menyesuaikan logika join dan where clause agar sesuai 
     * dengan kebutuhan tampilan daftar pengajuan untuk setiap role.
     */
    public function get_all_pengajuan_for_kacab($id_cabang = null)
    {
        $this->db->select('ip.*, c.nama_cabang, dp.status AS overall_status, dp.status_kacab, dp.status_am, dp.status_ho');
        $this->db->from('input_pengajuan ip');
        $this->db->join('cabang c', 'c.id = ip.id_cabang', 'left');
        $this->db->join('daftar_pengajuan dp', 'dp.id_pengajuan = ip.id', 'left');
        // Contoh: Kacab hanya melihat pengajuan dari cabangnya
        // if ($id_cabang) {
        //     $this->db->where('ip.id_cabang', $id_cabang);
        // }
        // Atau Kacab melihat semua pengajuan yang sudah disubmit atau menunggu persetujuan dia
        // $this->db->where_in('dp.status', ['Submitted', 'Approved', 'Rejected']);
        // $this->db->or_where('dp.status_kacab', 'pending');
        $this->db->order_by('ip.tanggal_form', 'DESC');
        return $this->db->get()->result();
    }

    public function get_all_pengajuan_for_am()
    {
        $this->db->select('ip.*, c.nama_cabang, dp.status AS overall_status, dp.status_kacab, dp.status_am, dp.status_ho');
        $this->db->from('input_pengajuan ip');
        $this->db->join('cabang c', 'c.id = ip.id_cabang', 'left');
        $this->db->join('daftar_pengajuan dp', 'dp.id_pengajuan = ip.id', 'left');
        // Contoh: AM melihat semua pengajuan yang status kacabnya sudah approved atau menunggu persetujuan dia
        // $this->db->where('dp.status_kacab', 'approved');
        // $this->db->or_where('dp.status_am', 'pending');
        $this->db->order_by('ip.tanggal_form', 'DESC');
        return $this->db->get()->result();
    }

    public function get_all_pengajuan_for_ho()
    {
        $this->db->select('ip.*, c.nama_cabang, dp.status AS overall_status, dp.status_kacab, dp.status_am, dp.status_ho');
        $this->db->from('input_pengajuan ip');
        $this->db->join('cabang c', 'c.id = ip.id_cabang', 'left');
        $this->db->join('daftar_pengajuan dp', 'dp.id_pengajuan = ip.id', 'left');
        // Contoh: HO melihat semua pengajuan yang status AMnya sudah approved atau menunggu persetujuan dia
        // $this->db->where('dp.status_am', 'approved');
        // $this->db->or_where('dp.status_ho', 'pending');
        $this->db->order_by('ip.tanggal_form', 'DESC');
        return $this->db->get()->result();
    }

    public function get_all_submitted_pengajuan_for_user()
    {
        // Logika untuk user biasa melihat semua pengajuan yang sudah disubmit
        // Jika tabel user memiliki id_user di input_pengajuan, Anda bisa memfilter berdasarkan itu
        // $this->db->where('ip.id_user', $this->session->userdata('user_id')); 
        $this->db->select('ip.*, c.nama_cabang, dp.status AS overall_status, dp.status_kacab, dp.status_am, dp.status_ho');
        $this->db->from('input_pengajuan ip');
        $this->db->join('cabang c', 'c.id = ip.id_cabang', 'left');
        $this->db->join('daftar_pengajuan dp', 'dp.id_pengajuan = ip.id', 'left');
        $this->db->where('dp.status', 'Submitted'); // Hanya yang sudah disubmit atau dalam proses
        $this->db->order_by('ip.tanggal_form', 'DESC');
        return $this->db->get()->result();
    }
}
