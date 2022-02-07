<?php 

if(isset($_GET['id'])) {

  $database = new Database();
  $db = $database->getConnection();

  $od = $_GET['id'];
  $findSql = "SELECT * FROM lokasi WHERE id = ?";
  $stmt = $db->prepare($findSql);
  $stmt->bindParam(1, $_GET['id']);
  $stmt->execute();
  $row = $stmt->fetch();
  if (isset($row['id'])) {
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb2">
        <div class="col-sm-6">
          <h1>Tambah Data Lokasi</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
            <li class="breadcrumb-item"><a href="?page=lokasiread">Lokasi</a></li>
            <li class="breadcrumb-item active">Tambah Data</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tambah Lokasi</h3>
      </div>
      <div class="card-body">
        <form action="" method="post">
          <input type="hidden" name="id" id="id" value="<?= $row['id']; ?>">
          <div class="form-group">
            <label for="nama_lokasi">Nama Lokasi</label>
            <input type="text" class="form-control" name="nama_lokasi" value="<?= $row['nama_lokasi']; ?>">
          </div>
          <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right">
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
    echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
  }
} else {
  echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
}

?>