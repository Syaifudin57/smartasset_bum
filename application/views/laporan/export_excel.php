<?php
$laporan = $result;

if (count($laporan) > 0):
    $headers = array_keys((array) $laporan[0]);
?>
    <table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th>No</th>
                <?php foreach ($headers as $h): ?>
                    <th><?= ucwords(str_replace('_', ' ', $h)) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($laporan as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <?php foreach ($headers as $h): ?>
                        <td><?= isset($row->$h) ? htmlspecialchars($row->$h) : '' ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p><strong>Tidak ada data ditampilkan.</strong></p>
<?php endif; ?>