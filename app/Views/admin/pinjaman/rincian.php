<h1>Daftar Transaksi</h1>
<table class="table table-bordered" id="example1">
<thead>
            <tr>
                <th>ID Pinjaman</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Nasabah</th>
                <!-- <th>Jenis Transaksi</th> -->
				<th>Debit</th>
                <th>Kredit</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $totalMasuk = 0;
            $totalKeluar = 0;
            
            foreach ($transaksiData as $transaksi) {
                if ($transaksi->masuk > 0 || $transaksi->keluar > 0) {
                    echo "<tr>";
                    echo "<td>{$transaksi->id_pinjaman}</td>";
                    echo "<td>{$transaksi->tgl_transaksi}</td>";
                    echo "<td>{$transaksi->nama}</td>";
              
                    
                  
                    
                    if ($transaksi->keluar > 0) {
                        echo "<td>Rp. " . angka($transaksi->keluar) . "</td>";
                        $totalKeluar += $transaksi->keluar;
                    } else {
                        echo "<td></td>";
                    }

					if ($transaksi->masuk > 0) {
                        echo "<td>Rp. " . angka($transaksi->masuk) . "</td>";
                        $totalMasuk += $transaksi->masuk;
                    } else {
                        echo "<td></td>";
                    }
                    
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Masuk:</th>
				<th>Rp. <?= angka($totalKeluar) ?></th>
                <th>Rp. <?= angka($totalMasuk) ?></th>

            </tr>
        </tfoot>
    </table>
	