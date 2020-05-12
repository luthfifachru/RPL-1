<?php 
require 'fungsi.php';
global $conn;
session_start();
$uname = $_SESSION["username"];
$query = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$uname'");
$pengguna = mysqli_fetch_array($query);

if ( !isset($_SESSION["username"]) ) {
  header("Location: masuk.php");
  exit;
}

if( isset($_POST["simpan"])) {
    if(edit($_POST) > 0 ) {
        $_SESSION["username"] = $_POST["username"];
        echo"<script>
                alert('Perubahan berhasil disimpan');
            </script>";

    }
    else {
        echo mysqli_error($conn);
    }
}

if ( isset($_POST["Upload"]) ) {

  $file = $_FILES['image']['tmp_name'];
  if (!isset($file) ){
      echo "Pilih file gambar";
  }

  else {
      $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
      $image_name = addslashes($_FILES['image']['name']);
      $image_size = getimagesize($_FILES['image']['tmp_name']);
      $id_pengguna = $pengguna["id_pengguna"];

      if ($image_size == false) {
          echo "File yang dipilih bukan gambar";
      } else {
          if (!$insert = mysqli_query($conn, "UPDATE pengguna SET
                  nama_gambar = '$image_name',
                  gambar = '$image'
                  WHERE id_pengguna = $id_pengguna")) {
                      echo "Gagal upload gambar";
                  } else {
                      echo "gambar berhasil di upload";
                  }
      }
  }
}

?>

<!DOCTYPE HTML>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../style/style.css" />
  <link rel="stylesheet" type="text/css" href="../style/sidebar nav.css" />
</head>

<body>

  <div class="red-top"></div>
  
  <?php include 'sidebar.php'; ?>

    <div class="wrapper">
      <div class="container giant">
        <div class="container first">
          <header >
            <h1>Akun Magons</h1>
          </header>
          <div class="container second bg">
            <div class="container fotoAkun">
                <form action="" method="post" enctype="multipart/form-data">
                  <?php echo '<img class="foto" src="data:image/jpeg;base64,'.base64_encode( $pengguna['gambar'] ).'"/>'; ?>
                  <input type="hidden" name="id_pengguna" value="<?= $pengguna["id_pengguna"]; ?>">
                  <input type="file" name="image">
                  <button type="submit" name="Upload">
                    Ubah Foto Akun
                  </button>
                </form>
            </div>
        <div class="container form">
              <div class="text">
                <h2><strong>Halo Magons!</strong> Selamat datang di Dramagon.<br>
                    Isi data akun Magons kamu dibawah ya!</h1>
              </div>
            <form action ="" method="post">
                <input type="hidden" name="id_pengguna" value="<?= $pengguna["id_pengguna"]; ?>">

                <label for="username">Username Magons</label><br>
                <input type="text" id="username" name="username" value="<?= $pengguna["username"]; ?>">
                
                <label for="nama">Nama</label><br>
                <input type="text" id="nama" name="nama" value="<?= $pengguna["nama"]; ?>">

                <label for="email">Email</label><br>
                <input type="text" id="email" name="email" value="<?= $pengguna["email"]; ?>">

                <label for="notelp">Nomor Telpon</label><br>
                <input type="text" id="notelp" name="notelp" value="<?= $pengguna["telpon"]; ?>">
                
                <h1>Jenis Kelamin</h1>
                <input type="radio" id="laki" name="jk" value="laki" <?php 
                if ( $pengguna["jenkel"]=="" ) {
                  echo "checked";
                }
                else if($pengguna["jenkel"]=='laki') {echo "checked"; }?> >
                <label for="male">Laki-laki</label>
                <input type="radio" id="perempuan" name="jk" value="perempuan" <?php if($pengguna["jenkel"]=='perempuan') {echo "checked"; }?> >
                <label for="perempuan">Perempuan</label><br>

                <label for="tl">Tanggal Lahir:</label>
                <input type="date" id="tl" name="tl" value="<?= $pengguna["tanggalLahir"]; ?>">
   
                <button type="submit" class="registerbtn" name="simpan">Simpan</button>
    

            </form>
            <br>
            <h1>Ingin ubah password? <a href="gantipass.php">Klik Disini!</a></h1> 
             
            </div>

          </div>
        </div>
        <!--container1-->
        
        

      </div>
      <!--container-->
            <div class="container-right">
            ini ada container nganggur rencananya mau dikasih gambar apa gitu biar menarik
            </div>
          <!--container-right end-->

    </div>
    <!--wrapper end-->
       
        </div>
        <!--main end-->
     
      </div>
      <!--body end-->

  
  </div>

  <div class="red-bot"></div>

</body>
</html>