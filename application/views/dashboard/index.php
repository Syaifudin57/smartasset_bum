<div class="content-wrapper">
    <section class="content-header">
        <h4>Selamat datang, jangan lupa cek histori pengadaan sebelum pengajuan ya..!</h4>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $total_pengajuan ?></h3>
                        <p>Jumlah Pengajuan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-upload"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $total_verifikasi ?></h3>
                        <p>Proses Verifikasi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $total_selesai ?></h3>
                        <p>Selesai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="grafikBulanan"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="grafikTahunan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const bulanLabels = <?= json_encode(array_map(fn($b) => $b->bulan, $bulanan)) ?>;
    const bulanData = <?= json_encode(array_map(fn($b) => $b->jumlah, $bulanan)) ?>;

    const ctx1 = document.getElementById('grafikBulanan').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Jumlah Pengajuan',
                data: bulanData,
                borderColor: 'orange',
                backgroundColor: 'rgba(255,165,0,0.3)',
                fill: true
            }]
        }
    });

    const tahunLabels = <?= json_encode(array_map(fn($t) => $t->tahun, $tahunan)) ?>;
    const dataMagelang = <?= json_encode(array_map(fn($t) => $t->magelang, $tahunan)) ?>;
    const dataJogja = <?= json_encode(array_map(fn($t) => $t->jogja, $tahunan)) ?>;
    const dataSemarang = <?= json_encode(array_map(fn($t) => $t->semarang, $tahunan)) ?>;

    const ctx2 = document.getElementById('grafikTahunan').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: tahunLabels,
            datasets: [{
                    label: 'Magelang',
                    data: dataMagelang,
                    backgroundColor: '#f57c00'
                },
                {
                    label: 'Yogyakarta',
                    data: dataJogja,
                    backgroundColor: '#ffb74d'
                },
                {
                    label: 'Semarang',
                    data: dataSemarang,
                    backgroundColor: '#ffe0b2'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>