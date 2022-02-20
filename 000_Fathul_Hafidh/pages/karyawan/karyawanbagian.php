<?php
if (isset($_GET['id'])) {
    $database = new Database();
    $db = $database->getConnection();

    $id = $_GET['id'];
    $findSql = "SELECT * FROM karyawan WHERE id = ? ";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1, $id);
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
                            <li class="breadcrumb-item active">Riwayat Bagian</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Bagian</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nik">Nomor Induk Karyawan</label>
                                <input type="text" class="form-control" name="nik" value="<?php echo $row['nik'] ?>" disabled />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="handphone">Handphone</label>
                                <input type="text" class="form-control" name="handphone" value="<?php echo $row['handphone'] ?>" disabled />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Pegawai</label>
                        <input type="text" class="form-control" name="nama_lengkap" value="<?php echo $row['nama_lengkap'] ?>" disabled />
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="bagian">Bagian</label>
                                <select name="bagian_id" id="bagian_id" class="form-control">
                                    <option value="">-- Pilih Bagian --</option>
                                    <?php
                                    $selectSQL = "SELECT * FROM bagian";
                                    $stmt_bagian = $db->prepare($selectSQL);
                                    $stmt_bagian->execute();

                                    while ($row_bagian = $stmt_bagian->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <option value="<?php echo $row_bagian['id']; ?>"><?php echo $row_bagian['nama_bagian']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tanggal_mulai" value="<?php echo date('Y-m-d') ?>">
                            </div>
                        </div>
                    </div>
                    <a href="?page=lokasiread" class="btn btn-danger btn-sm float-right"><i class="fa fa-times"></i> Batal</a>
                    <button type="submit" name="button_update" class="btn btn-success btn-sm float-right"><i class="fa fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </section>

    <?php
    } else {
    ?>
        <meta http-equiv="refresh" content="0;url=?page=karyawanread">
    <?php
    }
} else {
    ?>
    <meta http-equiv="refresh" content="0;url=?page=karyawanread">
<?php
}
?>