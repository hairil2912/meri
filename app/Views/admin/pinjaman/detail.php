<?php
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

$countStatus0 = 0;
$countStatus1 = 0;

foreach ($pinjaman as $p) {
    if ($p['status'] == 0) {
        $countStatus0++;
    } elseif ($p['status'] == 1) {
        $countStatus1++;
    }
}
?>



<div class="alert alert-info">
    <p>Jumlah Pinjaman sebesar <strong><?php echo formatRupiah($detail['pinjaman']) ?></strong> Sudah Terbayar <?=$countStatus1 . " Bulan, dan belum Terbayar " . $countStatus0 . " Bulan"?></p>
</div>

<table class="table table-bordered" id="detail">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="10%">Jatuh Tempo</th>
            <th width="15%">Angsuran</th>
            <th width="10%">Bunga</th>
            <th width="15%">Pokok</th>
            <th width="15%">Sudah</th>
            <th width="8%">Bukti</th>
            <th width="15%">Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($pinjaman as $cicilan) { ?>
            <tr>
                <td><?php echo $no ?></td>
                <td><?php echo tanggal_id($cicilan['j_tempo']) ?></td>
                <td><?php echo formatRupiah($cicilan['bunga'] + $cicilan['nil_pokok'] + $cicilan['pembulatan_angsuran']) ?></td>
                <td><?php echo formatRupiah($cicilan['bunga']) ?></td>
                <td><?php echo formatRupiah($cicilan['nil_pokok']) ?></td>
                <td><?php echo formatRupiah($cicilan['nil_bayar']) ?></td>
				<td>
    <?php if ($cicilan['bukti'] == "") { 
        echo '-';
    } else { ?>
        <a href="#" data-toggle="modal" data-target="#gambar-modal" data-gambar="<?php echo base_url('assets/upload/image/' . $cicilan['bukti']) ?>">
            <img src="<?php echo base_url('assets/upload/image/thumbs/' . $cicilan['bukti']) ?>" class="img img-thumbnail">
        </a>
    <?php } ?>
</td>
                <td>
                    <?php if ($cicilan['status'] == 0): ?>
                        <button type="button" class="btn-small btn-danger edit-button" data-toggle="modal" data-target="#modal-edit" data-idpinjaman="<?php echo $cicilan['id_pinjaman'] ?>" data-idcicilan="<?php echo $cicilan['id_pinjaman_detail'] ?>" data-status="<?php echo $cicilan['status'] ?>" data-bayar="<?php echo $cicilan['bunga'] + $cicilan['nil_pokok'] + $cicilan['pembulatan_angsuran'] ?>">
                            <i class="fa fa-edit"></i> Belum Lunas
                        </button>
                    <?php elseif ($cicilan['status'] == 1): ?>
                        <button type="button" class="btn-small btn-success edit-button" data-toggle="modal" data-target="#modal-edit" data-idpinjaman="<?php echo $cicilan['id_pinjaman'] ?>" data-idcicilan="<?php echo $cicilan['id_pinjaman_detail'] ?>" data-status="<?php echo $cicilan['status'] ?>" data-bayar="<?php echo $cicilan['bunga'] + $cicilan['nil_pokok'] + $cicilan['pembulatan_angsuran'] ?>">
                            <i class="fa fa-edit"></i> Lunas
                        </button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php $no++; } ?>
    </tbody>
</table>

<script>
$(document).ready(function() {
    $('#detail').DataTable({
        "paging": true,         // Menampilkan paging
        "lengthChange": false,  // Menyembunyikan pilihan perubahan jumlah entri per halaman
        "searching": true,     // Menyembunyikan fitur pencarian
        "ordering": true,       // Mengizinkan pengurutan kolom
        "info": true,           // Menampilkan informasi jumlah entri
        "autoWidth": true ,
		"scrollX": true 
		// "responsive": true    // Menonaktifkan otomatis penyesuaian lebar kolom
    });
});
</script>


<div class="modal fade" id="gambar-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tampilan Gambar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modal-gambar" src="" class="img img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function () {
    $("#gambar-modal").on("show.bs.modal", function (event) {
        var triggerLink = $(event.relatedTarget); // Link yang memicu modal
        var gambarURL = triggerLink.data("gambar"); // Ambil URL gambar dari atribut data-gambar
        var modalGambar = $(this).find("#modal-gambar"); // Elemen img dalam modal
        modalGambar.attr("src", gambarURL); // Setel atribut src dengan URL gambar
    });
});
</script>

<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Cicilan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-form" method="post" enctype="multipart/form-data"> 
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="id_pinjaman_detail" id="id-pinjaman-detail" readonly>
                    <input type="hidden" class="form-control" id="id-pinjaman" name="id_pinjaman" readonly>

                    <div class="form-group">
                        <label for="tgl-bayar">Tanggal Bayar</label>
                        <input type="date" class="form-control" id="tgl-bayar" name="tgl_bayar">
                    </div>

                    <div class="form-group">
                        <label for="nil_bayar">Nilai Bayar</label>
                        <input type="number" class="form-control" id="nil-bayar" name="nil_bayar">
                    </div>

					<div class="form-group">
                        <label for="gambar">Bukti</label>
                        <input type="file" name="gambar" id="gambar" class="form-control" value="<?php echo set_value('gambar') ?>">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" value="" required>
                            <option value="0">Belum Lunas</option>
                            <option value="1">Lunas</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
$(document).ready(function () {
    $(".edit-button").on("click", function () {
        var idPinjamanDetail = $(this).data("idcicilan");
        var idPinjaman = $(this).data("idpinjaman");
        var nilBayar = $(this).data("bayar");
        var status = $(this).data("status");
        var tglBayar = $(this).data("tgl-bayar");

        // Tambahkan console.log untuk memeriksa nilai variabel
        console.log("idPinjamanDetail:", idPinjamanDetail);
        console.log("idPinjaman:", idPinjaman);
        console.log("nilBayar:", nilBayar);
        console.log("status:", status);

        $("#id-pinjaman").val(idPinjaman);
        $("#id-pinjaman-detail").val(idPinjamanDetail);
        $("#nil-bayar").val(nilBayar);
        $("#status").val(status);
        $("#tgl-bayar").val(tglBayar);
		var updateUrl = "<?= base_url('admin/pinjaman/update_cicilan') ?>";
		$("#edit-form").attr("action", updateUrl);

    });
});
</script>
