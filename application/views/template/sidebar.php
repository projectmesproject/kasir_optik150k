    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">

        </div>
        <?php
        $data1 = $this->db->query("select * from tbl_setting where id=2")->row_array();
        ?>
        <div class="sidebar-brand-text mx-3"><?= $data1['fitur']; ?></div>
      </a>

      <?php if ($this->session->userdata('level') == 'admin') { ?>
        <!-- DATA UTAMA -->
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Data Utama
        </div>

        <!-- Nav Item - Users -->
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('customer'); ?>">
            <i class="fas fa-user"></i>
            <span>Data Customer</span></a>
        </li>

        <!-- Nav Item - Users -->
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('user'); ?>">
            <i class="fas fa-user"></i>
            <span>Data Users</span></a>
        </li>


        <!-- AHKHIR DATA UTAMA -->
      <?php } ?>
      <?php if ($this->session->userdata('level') == 'admin') { ?>
        <!-- DATA UTAMA -->
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Data Toko
        </div>

        <!-- Nav Item - Data Toko -->
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('pengeluaran'); ?>">
            <i class="fas fa-briefcase"></i>
            <span>Pengeluaran Toko</span></a>
        </li>

        <!-- AHKHIR DATA UTAMA -->
      <?php } ?>



      <!-- DATA TOKO -->

      <?php if ($this->session->userdata('level') == 'admin' || $this->session->userdata('level') == 'kasir') { ?>
        <!------------------------- DATA BARANG --------------------------------->
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Data Barang
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-briefcase"></i>
            <span>Data Barang</span>
          </a>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Data Barang</h6>
              <a class="collapse-item" href="<?php echo site_url('Barang'); ?>">Data Barang</a>
              <?php if ($this->session->userdata('level') == 'admin') { ?>
                <a class="collapse-item" href="<?php echo site_url('Kategori'); ?>">Data Kategori Barang</a>
                <a class="collapse-item" href="<?php echo site_url('Barang_rusak'); ?>">Data Barang Rusak</a>
                <a class="collapse-item" href="<?php echo site_url('peminjaman_barang'); ?>">Data Peminjaman Barang

                </a>
              <?php } ?>
            </div>
          </div>
        </li>
        <!-- AKHIR DATA BARANG -->
      <?php } ?>

      <!-- DATA PENJUALAN -->
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Data Penjualan
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-cart-plus"></i>
          <span>Data Penjualan</span>
        </a>
        <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Data Penjualan</h6>
            <?php if ($this->session->userdata('level') == 'kasir') { ?>
              <a class="collapse-item" href="<?php echo site_url('Penjualan'); ?>">Penjualan</a>
              <a class="collapse-item" href="<?php echo site_url('jual_dp'); ?>">Pembayaran DP</a>
            <?php } ?>
            <a class="collapse-item" href="<?php echo site_url('history_penjualan'); ?>">History Penjualan</a>
          </div>
        </div>
      </li>
      <!-- AKHIR DATA PENJUALAN -->

      <!-- DATA PEMBELIAN -->
      <?php if ($this->session->userdata('level') == 'admin') { ?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Data Pembelian
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-cubes"></i>
            <span>Data Pembelian</span>
          </a>
          <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Data Pembelian</h6>
              <a class="collapse-item" href="<?php echo site_url('Suplier'); ?>">Data Suplier</a>
              <a class="collapse-item" href="<?php echo site_url('Pembelian'); ?>">Pembelian Barang</a>
              <a class="collapse-item" href="<?php echo site_url('history_pembelian'); ?>">History Pembelian Barang</a>
            </div>
          </div>
        </li>
        <!-- AKHIR DATA PEMBELIAN -->
      <?php } ?>

      <?php if ($this->session->userdata('level') == 'admin') { ?>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Laporan
        </div>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('laporan'); ?>">
            <i class="fas fa-print"></i>
            <span>Laporan</span></a>
        </li>


        <!-- Divider -->
        <hr class="sidebar-divider">

        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('setting'); ?>">
            <i class="fas fa-upload"></i>
            <span>Setting Display</span></a>
        </li>
      <?php } ?>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->