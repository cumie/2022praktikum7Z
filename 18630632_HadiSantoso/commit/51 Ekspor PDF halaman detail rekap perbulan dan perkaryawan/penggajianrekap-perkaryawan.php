<?php include_once "partials/cssdatatables.php" ?>
   <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <?php 
        if (isset($_SESSION["hasil"])) {
          if ($_SESSION["hasil"]) {
        ?> 
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
          <h5><i class="icon fas fa-check"></i> Berhasil</h5>
          <?= $_SESSION["pesan"] ?>
        </div>
        <?php 
          } else {
        ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
          <h5><i class="icon fas fa-ban"> Gagal</i></h5>
          <?= $_SESSION["pesan"] ?>
        </div>
        <?php
          }
          unset($_SESSION['hasil']);
          unset($_SESSION['pesan']);
        }
        ?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Rekapitulasi Penggajian Sebulan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
              <li class="breadcrumb-item"><a href="?page=penggajianrekap">Rekap Gaji</a></li>
              <li class="breadcrumb-item"><a href="?page=penggajianrekap-perbulan&tahun=<?= $_GET['tahun'] ?>"><?= $_GET['tahun'] ?></a></li>
              <li class="breadcrumb-item active"><?= $_GET['bulan'] ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Rekap Gaji Tahun <?= $_GET['tahun'] ?> Bulan <?= $_GET['bulan'] ?></h3>
          <a href="export/penggajianrekap-perkaryawan-pdf.php?bulan=<?= $_GET['bulan'] ?>&tahun=<?= $_GET['tahun'] ?>" target="_blank" class="btn btn-success btn-sm float-right">
            <i class="fa fa-plus-circle"></i> Export PDF
          </a>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-hover" id="mytable">
            <thead>
              <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Gaji Pokok</th>
                <th>Tunjangan</th>
                <th>Uang Makan</th>
                <th>Total</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Gaji Pokok</th>
                <th>Tunjangan</th>
                <th>Uang Makan</th>
                <th>Total</th>
              </tr>
            </tfoot>
            <tbody>
              <?php 
              $database = new Database();
              $db = $database->getConnection();

              $bulan = $_GET['bulan'];
              $selectSql = "SELECT K.nik, K.nama_lengkap,
                            SUM(P.gapok) jumlah_gapok,
                            SUM(P.tunjangan) jumlah_tunjangan,
                            SUM(P.uang_makan) jumlah_uang_makan,
                            SUM(P.gapok) + SUM(P.tunjangan) + SUM(P.uang_makan) total
                            FROM penggajian P INNER JOIN karyawan K ON P.karyawan_id = K.id
                            WHERE P.bulan = $bulan
                            GROUP BY nik;";

              $stmt = $db->prepare($selectSql);
              $stmt->execute();

              $no = 1;
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nik'] ?></td>
                <td><?= $row['nama_lengkap'] ?></td>
                <td style="text-align: right;"><?= number_format($row['jumlah_gapok']) ?></td>
                <td style="text-align: right;"><?= number_format($row['jumlah_tunjangan']) ?></td>
                <td style="text-align: right;"><?= number_format($row['jumlah_uang_makan']) ?></td>
                <td style="text-align: right;"><?= number_format($row['total']) ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- /.content -->

<?php include "partials/scripts.php"; ?>
<?php include_once "partials/scriptdatatables.php" ?>
<script>
  $(function() {
    $('#mytable').DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#mytable_wrapper .col-md-6:eq(0)');
  });
</script>