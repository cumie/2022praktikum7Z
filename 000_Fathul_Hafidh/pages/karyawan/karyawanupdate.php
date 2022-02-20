<?php
if (isset($_GET['id'])) {

    include_once "database/database.php";
    $database = new Database();
    $db = $database->getConnection();
    if (isset($_POST['button_update'])) {

        $updateSql = "UPDATE karyawan SET nik = ?, nama_lengkap = ?, handphone = ?, email = ?, tanggal_masuk = ? WHERE id = ?";
        $stmt = $db->prepare($updateSql);
        $stmt->bindParam(1, $_POST['nik']);
        $stmt->bindParam(2, $_POST['nama_lengkap']);
        $stmt->bindParam(3, $_POST['handphone']);
        $stmt->bindParam(4, $_POST['email']);
        $stmt->bindParam(5, $_POST['tanggal_masuk']);
        $stmt->bindParam(6, $_POST['id']);
        if ($stmt->execute()) {

            $updateSql = "UPDATE pengguna SET username = ?, peran = ? WHERE id = ?";
            $stmtPengguna = $db->prepare($updateSql);
            $stmtPengguna->bindParam(1, $_POST['username']);
            $stmtPengguna->bindParam(2, $_POST['peran']);
            $stmtPengguna->bindParam(3, $_POST['pengguna_id']);

            if ($stmtPengguna->execute()) {
                $_SESSION['hasil_update'] = true;
            } else {
                $_SESSION['hasil_update'] = false;
            }
        } else {
            $_SESSION['hasil_update'] = false;
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
    }

    $id = $_GET['id'];
    $findSql = "SELECT K.*, P.username, P.password, P.peran 
                FROM karyawan K 
                LEFT JOIN Pengguna P ON K.pengguna_id = P.id
                WHERE K.id = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1, $_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch();
    if (isset($row['id'])) {
?>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Karyawan</h1>
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
                    <h3 class="card-title">Ubah Karyawan</h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="nik">Nomor Induk Karyawan</label>
                            <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>">
                            <input type="hidden" class="form-control" name="pengguna_id" value="<?php echo $row['pengguna_id'] ?>">
                            <input type="text" class="form-control" name="nik" value="<?php echo $row['nik'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="<?php echo $row['nama_lengkap'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="handphone">Handphone</label>
                            <input type="text" class="form-control" name="handphone" value="<?php echo $row['handphone'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $row['email'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                            <input type="date" class="form-control" name="tanggal_masuk" value="<?php echo $row['tanggal_masuk'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo $row['username'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="peran">Peran</label>
                            <select class="form-control" name="peran">
                                <option value="">-- Pilih Peran --</option>
                                <option value="ADMIN" <?php echo $row['peran'] == 'ADMIN' ? " selected" : "" ?>>ADMIN</option>
                                <option value="USER" <?php echo $row['peran'] == 'USER' ? " selected" : "" ?>>USER</option>
                            </select>
                        </div>
                        <a href="?page=karyawanread" class="btn btn-danger btn-sm float-right"><i class="fa fa-times"></i> Batal</a>
                        <button type="submit" name="button_update" class="btn btn-success btn-sm float-right"><i class="fa fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </section>
<?php
    } else {
        $_SESSION['hasil_update'] = false;
        echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
    }
} else {
    $_SESSION['hasil_update'] = false;
    echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
}
include_once "partials/scripts.php"
?>