<?php 
use App\Models\Konfigurasi_model;
$session = \Config\Services::session();
$konfigurasi  = new Konfigurasi_model;
$site         = $konfigurasi->listing();
?>
<style type="text/css" media="screen">
  .nav-item a:hover {
    color: yellow !important;
  }
</style>
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="<?php echo base_url('assets/upload/image/'.$site['icon']) ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo $site['namaweb'] ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url() ?>/assets/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?php echo base_url('admin/akun') ?>" class="d-block"><?php echo $session->get('nama') ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Dahboard -->
          <li class="nav-item">
            <a href="<?php echo base_url('admin/dasbor') ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('admin/nasabah') ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>Master Nasabah</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-wrench"></i>
              <p>Transaksi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="<?php echo base_url('admin/pinjaman') ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>Data Piutang</p>
            </a>
              </li>
              <li class="nav-item">
              <a href="<?php echo base_url('admin/pinjaman') ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>Transaksi</p>
            </a>
              </li>
            </ul>
          </li>
        
      
          <!-- Staff -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-image"></i>
              <p>Laporan Keuangan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url('admin/staff') ?>" class="nav-link">
                  <i class="fas fa-table nav-icon"></i>
                  <p>Laporan Piutang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/staff/tambah') ?>" class="nav-link">
                  <i class="fas fa-plus nav-icon"></i>
                  <p>Laporan Laba Kotor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/kategori_staff') ?>" class="nav-link">
                  <i class="fas fa-tags nav-icon"></i>
                  <p>Laporan Buku Besar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/kategori_staff') ?>" class="nav-link">
                  <i class="fas fa-tags nav-icon"></i>
                  <p>Laporan Debit Kredit</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- pengguna -->
          <li class="nav-item">
            <a href="<?php echo base_url('admin/user') ?>" class="nav-link">
              <i class="nav-icon fas fa-lock"></i>
              <p>Pengguna Website</p>
            </a>
          </li>
          <!-- Konfigurasi -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-wrench"></i>
              <p>Setting Website
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url('admin/konfigurasi') ?>" class="nav-link">
                  <i class="fas fa-tasks nav-icon"></i>
                  <p>Konfigurasi Umum</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/konfigurasi/logo') ?>" class="nav-link">
                  <i class="fas fa-image nav-icon"></i>
                  <p>Update Logo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/konfigurasi/icon') ?>" class="nav-link">
                  <i class="fas fa-leaf nav-icon"></i>
                  <p>Update Icon</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/konfigurasi/seo') ?>" class="nav-link">
                  <i class="fab fa-google nav-icon"></i>
                  <p>Setting SEO &amp; Metatext</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- panduan -->
          <li class="nav-item">
            <a href="<?php echo base_url('admin/panduan') ?>" class="nav-link">
              <i class="nav-icon fas fa-file-pdf"></i>
              <p>Panduan &amp; Manual Book</p>
            </a>
          </li>
          <!-- logout -->
          <li class="nav-item">
            <a href="<?php echo base_url('login/logout') ?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
            <div class="alert alert-success">
    <h5><em class="text-general"><?php echo $title ?></em></h5>
  </div>
              <!-- /.card-header -->
              <div class="card-body" style="min-height: 500px;">


<?php 
$validation = \Config\Services::validation();
    $errors = $validation->getErrors();
    if(!empty($errors))
    {
        echo '<span class="text-danger">'.$validation->listErrors().'</span>';
    }
?>

<?php if (session('msg')) : ?>
     <div class="alert alert-info alert-dismissible">
         <?= session('msg') ?>
         <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
     </div>
 <?php endif ?>