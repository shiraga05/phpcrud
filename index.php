<?php
$koneksi = mysqli_connect("localhost","root","","crudphp");
if (!$koneksi) {//cek koneksi
    die('Tidak bisa terkoneksi ke database');
}
$nis ="";
$nama="";
$alamat=""; 
$jurusan="";

$sukses="";
$error="";

if (isset ($_GET['op'])){//untuk read data
    $op=$_GET['op'];
}else{
    $op='';
}

if ($op=='delete') {//untuk menghapus data
    $id=$_GET['id'];
    $sql1="DELETE FROM siswa WHERE id = '$id'";
    $q1=mysqli_query($koneksi,$sql1);
     if ($q1) {
        $sukses='berhasil hapus data';
     }
     else{
        $error='gagal hapus data';
     }
}

if ($op=='edit') {//untuk mengupdate data
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM siswa WHERE id = '$id'";
    $q1=mysqli_query($koneksi, $sql1);
    $r1=mysqli_fetch_array($q1);
    $nis=$r1['nis'];
    $nama=$r1['nama'];
    $alamat=$r1['alamat'];
    $jurusan=$r1['jurusan'];

    if ($nis =='') {
        $error="Data Tidak Ditemukan ";
    }
}


if (isset ($_POST['simpan'])) {//untuk create
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jurusan = $_POST['jurusan'];

    if ($nis && $nama && $alamat && $jurusan) {
        $q1 = mysqli_query($koneksi, "INSERT INTO siswa(nis,nama,alamat,jurusan) VALUES ('$nis','$nama','$alamat','$jurusan')");
        if($q1){
            $sukses='berhasil memasukan data';
        }else{
            $error='gagal memasukan data';
        }
    }else{
        $error="silakan masukan semua data";
    }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1. 0">
    <title>Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
 <style>
    .mx-auto{
        width: 800px
    
    }
    .card{
        margin-top:10px;
    }
 </style>
<body>
    <div class="mx-auto">
        <!-- Untuk masukan data -->
        <div class="card">
            <div class="card-header">
                Creat/Edit Data
             </div>
        <div class="card-body"> 
            <?php
                if ($error) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                    <?php echo $error?>
                    </div>
                    <?php
                }
            ?>
             <?php
                if ($sukses) {
                    ?>
                    <div class="alert alert-primary" role="alert">
                    <?php echo $sukses?>
                    </div>
                    <?php
                }
            ?>
            <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nis" class="col-sm-2 col-form-label">NIS</label>
                        <div class="col-sm-10">
                        <input type="text"  class="form-control" id="nis" name="nis" value="<?php echo $nis?>">
                    </div>
                </div> 
                <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                        <input type="text"  class="form-control" id="nama" name="nama" value="<?php echo $nama?>">
                    </div>
                </div>
                <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                        <input type="text"  class="form-control" id="alamat" name="alamat" value="<?php echo $alamat?>">
                    </div>
                </div> 
                <div class="mb-3 row">
                        <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                        <div class="col-sm-10">
                    <select class="form-control" id="jurusan" name="jurusan">
                        <option value="">-Pilih Jurusan</option>
                        <option value="RPL" <?php if ($jurusan =="RPL")echo "selected"?> >RPL</option>
                        <option value="OTKP" <?php if ($jurusan =="OTKP")echo "selected"?> >OTKP </option>
                    </select>
                    </div>
                </div>
                <div class="col-12">
                    <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                </div>
            </form>
         </div>
         </div>
        <!-- Untuk mengeluarkan data-->
         <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Mahasiswa
             </div>
        <div class="card-body">  
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">NIS</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Jurusan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                    <tbody>
                        <?php
                        $q2=mysqli_query($koneksi,'SELECT*FROM siswa');
                        $urut=1;
                        while ($r2=mysqli_fetch_array($q2)) {
                            $id=$r2['id'];
                            $nis=$r2['nis'];
                            $nama=$r2['nama'];
                            $alamat=$r2['alamat'];
                            $jurusan=$r2['jurusan'];

                            ?>
                            <tr>
                                 <th scope="row"><?phpecho $urut++ ?></th>
                                 <td scope="row"><?php echo $nis ?></td>
                                 <td scope="row"><?php echo $nama ?></td>
                                 <td scope="row"><?php echo $alamat ?></td>
                                 <td scope="row"><?php echo $jurusan ?></td>
                                 <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>">                
                                    <button type="button" class="btn btn-light">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>"onclick="return confirm('yakin mau hapus data')">                
                                <button type="button" class="btn btn-dark">Delete</button> </a>
                                 </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </thead>
            </table>
         </div> 
    </div>
</body>
</html>