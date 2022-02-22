<?php 

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $database = new Database();
  $db = $database->getConnection();

  $deleteSql = "DELETE FROM praktikum_presensi_penggajian.pengguna WHERE id = ?";
  $stmt = $db->prepare($deleteSql);
  $stmt->bindParam(1, $_GET['id']);
  if ($stmt->execute()) {

    $deleteKaryawanSql = "DELETE FROM praktikum_presensi_penggajian.karyawan WHERE id = ?";
    $stmtKaryawan = $db->prepare($deleteKaryawanSql);
    $stmtKaryawan->bindParam(1, $_GET['id']);

    if ($stmtKaryawan->execute()) {
      $_SESSION['hasil'] = true;
      $_SESSION['pesan'] = "Hapus data SUKSES!";
    } else {
      $_SESSION['hasil'] = false;
      $_SESSION['pesan'] = "Hapus data GAGAL!";
    }
  } else {
    $_SESSION['hasil'] = false;
    $_SESSION['pesan'] = "Hapus data GAGAL!";
  }
}
echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";

?>