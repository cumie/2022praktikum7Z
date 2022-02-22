<?php 

if(isset($_GET['id'])) {

  $database = new Database();
  $db = $database->getConnection();

  $id = $_GET['id'];
  $findSql = 
  "SELECT 
  P.id, K.nik, K.nama_lengkap, K.handphone, 
  K.email, K.tanggal_masuk, P.username,
  P.password, P.peran FROM praktikum_presensi_penggajian.pengguna P 
  INNER JOIN praktikum_presensi_penggajian.karyawan K ON P.id = K.pengguna_id WHERE K.id = ?";
  $stmt = $db->prepare($findSql);
  $stmt->bindParam(1, $_GET['id']);
  $stmt->execute();
  $row = $stmt->fetch();
  if (isset($row['id'])) {
    if (isset($_POST['button_update'])) {
      
      $database = new Database();
      $db = $database->getConnection();

      $validateSql = "SELECT * FROM praktikum_presensi_penggajian.karyawan WHERE nik = ?";
      $stmt = $db->prepare($validateSql);
      $stmt->bindParam(1, $_POST['nik']);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
?> 
        <div class="alert alert-danger alert-dismissible">
          <button class="close" type="button" data-dismiss="alert" aria-hidden="true"></button>
          <h5><i class="icon fas fa-ban"></i> Gagal</h5>
          NIK Tidak Boleh Sama
        </div>
<?php
      } else {
        $validateSql = "SELECT * FROM praktikum_presensi_penggajian.pengguna WHERE username = ?";
        $stmt = $db->prepare($validateSql);
        $stmt->bindParam(1, $_POST['username']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
?>
        <div class="alert alert-danger alert-dismissible">
          <button class="close" type="button" data-dismiss="alert" aria-hidden="true">X</button>
          <h5><i class="icon fas fa-ban"></i> Gagal</h5>
          Username Tidak Boleh Sama
        </div>
<?php
        } else {
          if ($_POST['password'] != $_POST['password2']) {
?>
          <div class="alert alert-danger alert-dismissible">
            <button class="close" type="button" data-dismiss="alert" aria-hidden="true">X</button>
            <h5><i class="icon fas fa-ban"></i> Gagal</h5>
            Password Tidak Sesuai
          </div>
<?php
          } else {
            $md5Password = md5($_POST['password']);

            $updateSql = "UPDATE praktikum_presensi_penggajian.pengguna SET 
              username = ?,
              password = ?,
              peran = ?,
              login_terakhir = NULL
              WHERE id = ?";
            $stmt = $db->prepare($updateSql);
            $stmt->bindParam(1, $_POST['username']);
            $stmt->bindParam(2, $md5Password);
            $stmt->bindParam(3, $_POST['peran']);
            $stmt->bindParam(4, $_POST['id']);

            if ($stmt->execute()) {
              $updateKaryawanSql = "UPDATE praktikum_presensi_penggajian.karyawan SET
                nik = ?,
                nama_lengkap = ?,
                handphone = ?,
                email = ?,
                tanggal_masuk = ?
                WHERE id = ?";
                $stmtKaryawan = $db->prepare($updateKaryawanSql);
                $stmtKaryawan->bindParam(1, $_POST['nik']);
                $stmtKaryawan->bindParam(2, $_POST['nama_lengkap']);
                $stmtKaryawan->bindParam(3, $_POST['handphone']);
                $stmtKaryawan->bindParam(4, $_POST['email']);
                $stmtKaryawan->bindParam(5, $_POST['tanggal_masuk']);
                $stmtKaryawan->bindParam(6, $_POST['id']);
                if ($stmtKaryawan->execute()) {
                  $_SESSION['hasil'] = true;
                  $_SESSION['pesan'] = "Ubah data SUKSES!";
                } else {
                  $_SESSION['hasil'] = false;
                  $_SESSION['pesan'] = "Ubah data GAGAL!";
                }
                echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
            }
          }
        }
      }
    }
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb2">
        <div class="col-sm-6">
          <h1>Ubah Data Karyawan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
            <li class="breadcrumb-item"><a href="?page=karyawanread">Karyawan</a></li>
            <li class="breadcrumb-item active">Ubah Data</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tambah Karyawan</h3>
      </div>
      <div class="card-body">
        <form action="" method="post">
          <input type="hidden" name="id" id="id" value="<?= $row['id']; ?>">
          <div class="form-group">
            <label for="nik">Nomor Induk Karyawan</label>
            <input type="text" class="form-control" name="nik" value="<?= $row['nik']; ?>">
          </div>
          <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_lengkap" value="<?= $row['nama_lengkap']; ?>">
          </div>
          <div class="form-group">
            <label for="handphone">Handphone</label>
            <input type="text" class="form-control" name="handphone" value="<?= $row['handphone']; ?>">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="<?= $row['email']; ?>">
          </div>
          <div class="form-group">
            <label for="tanggal_masuk">Tanggal Masuk</label>
            <input type="date" class="form-control" name="tanggal_masuk" value="<?= $row['tanggal_masuk']; ?>">
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" value="<?= $row['username']; ?>">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" value="<?= $row['password']; ?>">
          </div>
          <div class="form-group">
            <label for="password2">Password (Ulangi)</label>
            <input type="password" class="form-control" name="password2" value="<?= $row['password']; ?>">
          </div>
          <div class="form-group">
            <label for="peran">Peran</label>
            <select name="peran" class="form-control">
              <option value=""><?= $row['peran']; ?></option>
              <option value="">-- Pilih Peran --</option>
              <option value="ADMIN">ADMIN</option>
              <option value="USER">USER</option>
            </select>
          </div>
          <a href="?page=karyawanread" class="btn btn-danger btn-sm float-right">
            <i class="fa fa-times"></i> Batal
          </a>
          <button type="submit" name="button_update" class="btn btn-success btn-sm float-right">
            <i class="fa fa-save"></i> Ubah
          </button>
        </form>
      </div>
    </div>
  </section>
<?php    
  } else {
    echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
  }
} else {
  echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
}

?>