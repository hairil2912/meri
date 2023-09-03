<?php 
$session = \Config\Services::session();
use App\Models\Dasbor_model;
$m_dasbor = new Dasbor_model();

	
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
	
}
?>


 
 <!-- Info boxes -->
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-newspaper"></i></span>
      <a href="<?php echo base_url('admin/pinjaman/') ?>" >

      <div class="info-box-content">
        <span class="info-box-text">Total Pinjaman</span>
        <span class="info-box-number">
          <?php echo angka($m_dasbor->pinjaman()) ?>
          <small>Pinjaman</small>
        </span>
      </div>
      </a>
    </div>
   
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Nasabah</span>
        <span class="info-box-number"><?php echo angka($m_dasbor->nasabah()) ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix hidden-md-up"></div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Dana Pinjaman</span>
        <span class="info-box-number"><?php echo "Rp. ". angka($m_dasbor->totalpinjaman()['pinjaman']) ?></span>


      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-lock"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Cicilan Masuk</span>
        <span class="info-box-number"><?php echo "Rp. ". angka($m_dasbor->totalbayar()['nil_bayar']) ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

<div class="row">
<!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-download"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Bunga Masuk</span>
        <span class="info-box-number"><?php echo "Rp. ". angka($m_dasbor->cicilanlunas()['bunga']) ?></span>
 </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-images"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Bunga Keuntungan</span>
        <span class="info-box-number">
        <span class="info-box-number"><?php echo "Rp. ". angka($m_dasbor->totalpinjaman()['totalbunga']) ?></span>  
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1"><i class="fab fa-youtube"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Cicilan Berjalan</span>
        <span class="info-box-number"><?php echo "Rp. ". angka($m_dasbor->cicilanberjalan()['angsuranbulat']) ?></span>  
    
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix hidden-md-up"></div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tags"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Perputaran Pokok</span>
        <span class="info-box-number"><?php echo "Rp. ". angka($m_dasbor->cicilanberjalan()['nil_pokok']) ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  
</div>

<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header alert alert-danger">
                <h5 class="card-title">Daftar Transaksi 5 Hari Lagi Jatuh Tempo</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="#" class="dropdown-item">Action</a>
                      <a href="#" class="dropdown-item">Another action</a>
                      <a href="#" class="dropdown-item">Something else here</a>
                      <a class="dropdown-divider"></a>
                      <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
               
          


<table class="table table-bordered" id="example2">

	<thead>
		<tr>
			<th width="5%">No</th>
			<th width="20%">Nasabah</th>
			<th width="25%">Pokok</th>
			<th width="20%">Angsuran</th>
			<th width="10%">Tgl</th>
			<th width="8%">Wa</th>

		</tr>
	</thead>
	<?php
?>
	<tbody>
		<?php $no=1; foreach($tempo as $data) { ?>
		<tr>
      <td><?php echo $no ?></td>
      <td><?= $data['nama']; ?></td>
      <td><?= angka($data['nil_pokok']); ?></td>
      <td><?= angka($data['angsuran_perbulan']); ?></td>
      <td><?= $data['j_tempo']; ?></td>
			<td>
			<a href="<?php echo base_url('admin/pinjaman/kirim/') ?>" class="btn btn-dark btn-sm" onclick="kirim(event)"><i class="fa fa-paper-plane"></i></a>
			</td>
      
		</tr>
		<?php $no++; } ?>
	</tbody>
</table>
              
              </div>
              <!-- ./card-body -->
        
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
<script src="../../pin/assets/admin/plugins/chart.js/Chart.min.js"></script>

<script src="../../pin/assets/admin/dist/js/adminlte.min.js"></script>

<script src="../../pin/assets/admin/dist/js/demo.js"></script>

<script src="../../pin/assets/admin/dist/js/pages/dashboard2.js"></script>
