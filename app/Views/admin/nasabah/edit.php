<form action="<?php echo base_url('admin/staff/edit/'.$staff['id_staff']) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<?php 
echo csrf_field(); 
?>
<div class="form-group row">
	<label class="col-3">Nama Staff</label>
	<div class="col-9">
		<input type="text" name="nama" class="form-control" placeholder="Nama staff" value="<?php echo $staff['nama'] ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-3">Jabatan &amp; No Urut Tampil</label>
	<div class="col-6">
		<input type="text" name="jabatan" class="form-control" placeholder="Jabatan" value="<?php echo $staff['jabatan'] ?>">
	</div>

</div>

<div class="form-group row">
	<label class="col-3">Tempat, tanggal lahir</label>
	<div class="col-3">
		<input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat lahir" value="<?php echo $staff['tempat_lahir'] ?>">
	</div>
	<div class="col-3">
		<input type="text" name="tanggal_lahir" class="form-control" placeholder="dd-mm-yyyy" value="<?php echo tanggal_id($staff['tanggal_lahir']) ?>">
	</div>
</div>


<div class="form-group row">
	<label class="col-3">Upload Foto dan Website</label>
	<div class="col-4">
		<input type="text" name="telepon" class="form-control" placeholder="Telepon" value="<?php echo $staff['telepon'] ?>">
	</div>
	<div class="col-5">
		<input type="text" name="email" class="form-control" placeholder="Email staff" value="<?php echo $staff['email'] ?>">
	</div>
	
</div>

<div class="form-group row">
	<label class="col-3">Website dan logo</label>
	<div class="col-4">
		<input type="text" name="website" class="form-control" placeholder="Website" value="<?php echo $staff['website'] ?>">
	</div>
	<div class="col-5">
		<input type="file" name="gambar" class="form-control" placeholder="gambar" value="<?php echo $staff['gambar'] ?>">
	</div>
</div>

<div class="form-group row">
	<label class="col-3">Alamat</label>
	<div class="col-9">
		<textarea name="alamat" placeholder="Alamat" class="form-control"><?php echo $staff['alamat'] ?></textarea>
	</div>
</div>

<div class="form-group row">
	<label class="col-3">Keahlian</label>
	<div class="col-9">
		<textarea name="keahlian" placeholder="Keahlian" class="form-control"><?php echo $staff['keahlian'] ?></textarea>
	</div>
</div>

<div class="form-group row">
	<label class="col-3"></label>
	<div class="col-9">
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
	</div>
</div>


<?php echo form_close(); ?>