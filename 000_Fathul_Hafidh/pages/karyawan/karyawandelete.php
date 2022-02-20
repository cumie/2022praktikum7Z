<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $database = new Database();
    $db = $database->getConnection();

    $selectSql = "SELECT * FROM karyawan K WHERE id = ?";
    $stmt = $db->prepare($selectSql);
    $stmt->bindParam(1, $_GET['id']);
    $stmt->execute();

    $no = 1;
    $row = $stmt->fetch();
    $pengguna_id = $row['pengguna_id'];

    $deleteSql = "DELETE FROM karyawan WHERE id = ?";
    $stmt = $db->prepare($deleteSql);
    $stmt->bindParam(1, $_GET['id']);

    if ($stmt->execute()) {

        $deleteSqlPengguna = "DELETE FROM pengguna WHERE id = ?";
        $stmtPengguna = $db->prepare($deleteSqlPengguna);
        $stmtPengguna->bindParam(1, $pengguna_id);

        if ($stmtPengguna->execute()) {
            $_SESSION['hasil_delete'] = true;
        } else {
            $_SESSION['hasil_delete'] = false;
        }
    } else {
        $_SESSION['hasil_delete'] = false;
    }
}
echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
