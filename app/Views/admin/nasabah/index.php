<?php include('tambah.php'); ?>
<table class="table table-bordered" id="example1">
	<thead>
		<tr>
			<th width="5%">No</th>
			<th width="10%">Foto</th>
			<th width="30%">Nama</th>
			<th width="30%">Kontak</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $no=1; foreach($staff as $staff) { ?>
		<tr>
			<td><?php echo $no ?></td>
			<td><?php if($staff['gambar']=="") { echo '-'; }else{ ?>
				<img src="<?php echo base_url('assets/upload/nasabah/thumbs/'.$staff['gambar']) ?>" class="img img-thumbnail">
			<?php } ?>
			</td>
			<td><?php echo $staff['nama'] ?>
				<small>
					
					<br><i class="fa fa-home"></i> Urut: <?php echo $staff['nama'] ?>
				</small>
			</td>
			<td><small><i class="fa fa-phone"></i> <?php echo $staff['no_wa'] ?>
				<br><i class="fa fa-map"></i> <?php echo $staff['alamat'] ?>
				</small>
			</td>
			<td>
				<a href="<?php echo base_url('admin/nasabah/edit/'.$staff['id_nasabah']) ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
				<a href="<?php echo base_url('admin/nasabah/delete/'.$staff['id_nasabah']) ?>" class="btn btn-dark btn-sm" onclick="confirmation(event)"><i class="fa fa-trash"></i></a>
			</td>
		</tr>
		<?php $no++; } ?>
	</tbody>
</table>