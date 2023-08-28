<form action="<?php echo base_url('admin/pinjaman/tambah') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<?php 
echo csrf_field(); 
?>
<div class="form-group row">
<label class="col-md-2">Tanggal Pinjaman</label>
	<div class="col-md-6">
    <input type="date" name="tgl_pinjaman" value="<?php if(isset($_POST['tanggal_publis'])) { echo set_value('tanggal_publish'); }else{ echo date('d-m-Y'); } ?>" required>
	</div>
	</div>

<div class="form-group row">
<input type="hidden" name="tanggal_publish" value="<?php if(isset($_POST['tanggal_publis'])) { echo set_value('tanggal_publish'); }else{ echo date('d-m-Y'); } ?>">
<input type="hidden" name="jam" value="<?php if(isset($_POST['jam'])) { echo set_value('jam'); }else{ echo date('H:i:s'); } ?>">


	<label class="col-md-2">Label Pinjaman</label>
	<div class="col-md-6">
		<input type="text" name="judul_berita" class="form-control" value="<?php echo set_value('judul_berita') ?>" required>
	</div>
</div> 
<div class="form-group row">
	<label class="col-md-2">Nasabah</label>
	<div class="col-md-2">
		<select name="id_nasabah" class="form-control" required>
			<option value="" disabled selected>Pilih Nasabah</option> <!-- Opsi default kosong -->
			<?php foreach($nasabah as $nasabah) { ?>
			<option value="<?php echo $nasabah['id_nasabah'] ?>">
				<?php echo $nasabah['nama'] ?>
			</option>
			<?php } ?>
		</select>
	</div>
</div>


<div class="form-group row">
	<label class="col-md-2">Upload Bukti</label>
	<div class="col-md-6">
		<input type="file" name="gambar" class="form-control" value="<?php echo set_value('gambar') ?>">
	</div>
</div>




<div class="form-group row">
        <label class="col-md-2">Persen, Tempo &amp; Status</label>
        <div class="col-md-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input type="number" name="pinjaman" id="pinjaman" class="form-control" required >
            </div>
            <small class="text-secondary">Jumlah Pinjaman</small>
        </div>

        <div class="col-md-2">
            <div class="input-group">
                <input type="number" name="persen" value="36" id="persen" class="form-control" required>
                <div class="input-group-prepend">
                    <span class="input-group-text">%/thn</span>
                </div>
            </div>
            <div id="pers"></div>
        </div>

        <div class="col-md-2">
            <div class="input-group">
                <input type="number" name="bulan"  value="5" id="bulan" class="form-control" required>
                <div class="input-group-prepend">
                    <span class="input-group-text">Bulan</span>
                </div>
            </div>
            <small class="text-secondary">Jumlah Bulan</small>
        </div>
   

		<div class="col-md-2">
			<div class="input-group">
			<div class="input-group-prepend">
					<span class="input-group-text">Tanggal</span>
				</div>
				<input type="number" name="tanggal" id="tanggal" value="12" class="form-control" required>

			</div>
			<small class="text-secondary">Tanggal J. Tempo</small>
		</div>
	</div>

	<input type="hidden" id="pokok" name="pokok" value="">
	<input type="hidden" id="bunga" name="bunga" value="">
    <input type="hidden" id="totalpinjam" name="totalpinjam" value="">
    <input type="hidden" id="totalbunga" name="totalbunga" value="">
    <input type="hidden" id="pembulatan" name="pembulatan" value="">
    <input type="hidden" id="angsuran_bulanan" name="angsuran_bulanan" value="">
    <input type="hidden" id="angsuran_tanpabulat" name="angsuran_tanpabulat" value="">



<div class="form-group row">
	<label class="col-md-2">Ringkasan</label>
	<div class="col-md-6">
		<textarea name="ringkasan" id="hasilTextarea" rows="10" cols="50" class="form-control"><?php echo set_value('ringkasan') ?></textarea>
	</div>
</div>


<div class="form-group row">
	<label class="col-md-2"></label>
	<div class="col-md-10">
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
	</div>
</div>

<script>
    function formatUang() {
      const inputValue = parseFloat(document.getElementById('inputUang').value);
      if (!isNaN(inputValue)) {
        const formattedValue = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(inputValue);
        document.getElementById('inputUang').value = formattedValue;
      }
    }
  </script>


<script>
        document.getElementById('pinjaman').addEventListener('input', calculate);
        document.getElementById('persen').addEventListener('input', calculate);
        document.getElementById('bulan').addEventListener('input', calculate);
        function roundUpToNearest5000(value) {
    return Math.ceil(value / 5000) * 5000;
}
        function calculate() {
            const pinjaman = parseFloat(document.getElementById('pinjaman').value);
            const persen = parseFloat(document.getElementById('persen').value);
            const bulan = parseInt(document.getElementById('bulan').value);

            const bungaFlat = (pinjaman * persen / 100) * (bulan / 12);
            const bungaBulanan = (pinjaman * (persen / 100) / 12);
            const bungabhgiBulanan = (persen / 12);
            const pokokBulanan = (pinjaman / bulan);
            const sumangsuranBulanan = (pokokBulanan + bungaBulanan);
            const angsuranBulanan = roundUpToNearest5000(sumangsuranBulanan);
            const pembulatan = (angsuranBulanan-sumangsuranBulanan)
            const total = (angsuranBulanan * bulan);
            

			const hasilTextarea = document.getElementById('hasilTextarea');
            hasilTextarea.textContent = `
                Bunga Bulanan: Rp ${bungaBulanan.toLocaleString('id-ID')}
                Pokok Bulanan: Rp ${pokokBulanan.toLocaleString('id-ID')}
                Angsuran Bulanan: Rp ${sumangsuranBulanan.toLocaleString('id-ID')}
                Pembulatan Angsuran Bulanan: Rp ${angsuranBulanan.toLocaleString('id-ID')}
                Nilai Pembulatan : Rp ${pembulatan.toLocaleString('id-ID')}
				Total dan Bunga: Rp ${total.toLocaleString('id-ID')}
            `;

			const pokokInput = document.getElementById('pokok');
            pokokInput.value = pokokBulanan;

			const bungaInput = document.getElementById('bunga');
            bungaInput.value = bungaBulanan;

            const totalPinjam = document.getElementById('totalpinjam');
            totalPinjam.value = total;

            const totalBunga = document.getElementById('totalbunga');
            totalBunga.value = bungaFlat;            
            
            const totalPembulatan = document.getElementById('pembulatan');
            totalPembulatan.value = pembulatan;

            const bulanandenganBulat = document.getElementById('angsuran_bulanan');
            bulanandenganBulat.value = angsuranBulanan;

            const bulanantanpaBulat = document.getElementById('angsuran_tanpabulat');
            bulanantanpaBulat.value = sumangsuranBulanan;


            


            const bungaElement = document.getElementById('pers');
            bungaElement.innerHTML = `
			<small class="text-secondary">${bungabhgiBulanan.toLocaleString('id-ID')}% / Bulan atau Rp ${bungaBulanan.toLocaleString('id-ID')} </small>
            
            `;
        }
    </script>

<?php echo form_close(); ?>
