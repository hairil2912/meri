<p>
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
		<i class="fa fa-plus"></i> Tambah Baru
	</button>
</p>
<form action="<?php echo base_url('admin/nasabah') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<?php 
echo csrf_field(); 
?>

<div class="modal fade" id="modal-default">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Tambah Baru</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="form-group row">
					<label class="col-3">Nama Nasabah</label>
					<div class="col-9">
						<input type="text" name="nama" class="form-control" placeholder="Nama Nasabah" value="<?php echo set_value('nama') ?>" required>
					</div>
				</div>

				
				<div class="form-group row">
					<label class="col-3">Telepon</label>
					<div class="col-4">
						<input type="text" name="telepon" class="form-control" placeholder="Telepon" value="<?php echo set_value('telepon') ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-3">Upload Foto</label>
					<div class="col-5">
						<input type="file" name="gambar" class="form-control" placeholder="gambar" value="<?php echo set_value('gambar') ?>">
					</div>
					
				</div>

				<div class="form-group row">
					<label class="col-3">Alamat</label>
					<div class="col-9">
						<textarea name="alamat" placeholder="Alamat" class="form-control"><?php echo set_value('alamat') ?></textarea>
					</div>
				</div>


			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
				<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php echo form_close(); ?>