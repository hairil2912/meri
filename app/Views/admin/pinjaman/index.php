<p>
	<a href="<?php echo base_url('admin/pinjaman/tambah') ?>" class="btn btn-success">
		<i class="fa fa-plus"></i> Tambah Pinjaman
	</a>
</p>

<table class="table table-bordered" id="example1">
	<thead>
		<tr>
			<th width="5%">No</th>
		
			<th width="20%">Nasabah</th>
			<th width="25%">Pinjaman/Bunga/Tempo</th>
			<th width="20%">Angsuran</th>
			<th width="8%">Bukti</th>

			<th></th>
		</tr>
	</thead>
	<?php
?>
	<tbody>
		<?php $no=1; foreach($pinjaman as $pinjaman) { ?>
		<tr>

			<td style="<?php echo $pinjaman['blmlunas'] == 0 ? 'background-color: green;' : ''; ?>"><?php echo $no ?></td>
			
			<td><small>
					<i class="fa fa-user"></i> <a href="<?php echo base_url('admin/berita/author/'.$pinjaman['id_user']) ?>">
						<?php echo $pinjaman['nama'] ?>
					</a>
					<br>
					<i class="fa fa-check"></i> <a href="<?php echo base_url('admin/berita/status_berita/'.$pinjaman['status_berita']) ?>">
					<?php echo $pinjaman['no_wa'] ?>
					</a>
					<br>
					<i class="fa fa-calendar-check"></i> 
					<?php echo tanggal_id($pinjaman['tgl_pinjaman']) ?>

				
					
				</small>
			</td>
			<td>
				<small>
					<i class="fa fa-eye"></i> Pinjaman: <?php echo angka($pinjaman['pinjaman']) ?>
					<br><i class="fa fa-home"></i> Bunga / Tempo: <?php echo angka($pinjaman['angsuran_bunga']) ?> / <?php echo $pinjaman['bulan'] ?> Bulan
					<br><i class="fa fa-calendar-check"></i> Angsuran Perbulan: <?php echo angka( $pinjaman['angsuran_bulanan']) ?>
					<!-- <br><i class="fa fa-calendar"></i> Lunas & Sisa Angsuran:  -->
				</small>
			</td>
			<td>
				<small>
					Lunas: <?php echo angka($pinjaman['lunas']) ?> Bulan
					<br>Sisa Bulan: <?php echo angka($pinjaman['blmlunas']) ?> Bulan
					<br>Sudah Bayar: <?php echo angka($pinjaman['sudahbayar']) ?> 
					<br>Sisa Bayar: <?php echo angka($pinjaman['sisaangsuran']) ?> 
					
					<!-- <br><i class="fa fa-calendar"></i> Lunas & Sisa Angsuran:  -->
		</small>
			</td>
			
			
			<td>
				<?php if($pinjaman['bukti1']=="") { echo '-'; }else{ ?>
					<img src="<?php echo base_url('assets/upload/image/thumbs/'.$pinjaman['bukti1']) ?>" class="img img-thumbnail">
				<?php } ?>
			</td>
			
			
			<td>
				<a href="<?php echo base_url('admin/pinjaman/detail/'.$pinjaman['id_pinjaman']) ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-eye"></i></a>
				<!-- <a href="<?php echo base_url('admin/berita/edit/'.$pinjaman['id_pinjaman']) ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
				<a href="<?php echo base_url('admin/berita/delete/'.$pinjaman['id_pinjaman']) ?>" class="btn btn-dark btn-sm" onclick="confirmation(event)"><i class="fa fa-trash"></i></a> -->
				<a href="<?php echo base_url('admin/pinjaman/kirim/'.$pinjaman['id_pinjaman']) ?>" class="btn btn-dark btn-sm" onclick="kirim(event)"><i class="fa fa-paper-plane"></i></a>
			</td>
		</tr>
		<?php $no++; } ?>
	</tbody>
</table>