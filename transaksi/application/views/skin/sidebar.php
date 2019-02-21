<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="<?php if ($title == 'Transaksi') echo 'active'  ?>">
          <a href="<?= base_url('transaksi_induk'); ?>">
            <i class="fa fa-dashboard"></i> <span>Transaksi</span>
          </a>
        </li>
        <li class="<?php if ($title == 'View') echo 'active' ?>">
          <a href="<?= base_url('transaksi_induk/view_laporan'); ?>">
            <i class="fa fa-dashboard"></i> <span>View Laporan</span>
          </a>
        </li>
   

    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">