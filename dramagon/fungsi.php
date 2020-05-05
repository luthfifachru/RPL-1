<?php 

// koneksi ke database
$conn = mysqli_connect("localhost","root","","dramagon");

function daftar($data) {
    global $conn;

    $username = stripslashes($data["uname"]);
    $password = $data["password"];
    $k_password = $data["k_password"];
    $email = $data["email"];

    // cek username yg sudah dipakai
    $result = mysqli_query($conn, "SELECT username FROM pengguna WHERE username = '$username'");

    if( mysqli_fetch_assoc($result) ) {
        echo "<script>
                alert('username sudah dipakai!')
            </script>";
        return false;
    }

    // cek konfirmasi password
    if ($password !== $k_password) {
        echo "<script>
                alert('konfirmasi password tidak sesuai!');
              </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan userbaru ke database
    mysqli_query($conn, "INSERT INTO pengguna VALUES('','$username','$password', '$username','$email','','','')");
    
    return mysqli_affected_rows($conn);
}

function masuk($data) {
    global $conn;

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$username'");

    // cek username
    if ( mysqli_num_rows($result) === 1 ) {
        // cek password
        $row = mysqli_fetch_assoc($result);
        if ( password_verify($password, $row["password"]) ) {
            return 1;
        }
    }
}

function edit($data) {
    global $conn;

    $id_pengguna = $data["id_pengguna"];
    $username = stripslashes($data["username"]);
    $nama = $data["nama"];
    $email = $data["email"];
    $telpon = $data["notelp"];
    $jenkel = $data["jk"];
    $tanggalLahir = $data["tl"]; 

    // cek username yg sudah dipakai
    $result = mysqli_query($conn, "SELECT username FROM pengguna WHERE username = '$username'");
    $query = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$username'");
    $pengguna = mysqli_fetch_array($query);

    if ( $username == $pengguna["username"] ) {
        $cek = 1;
    }

    if( !mysqli_fetch_assoc($result) && $cek!=1) {
        echo "<script>
                alert('username sudah dipakai!')
            </script>";
        return false;
    }


    // update pengguna ke database
    mysqli_query($conn, "UPDATE pengguna SET
            username = '$username',
            nama = '$nama',
            email = '$email',
            telpon = '$telpon',
            jenkel = '$jenkel',
            tanggalLahir = '$tanggalLahir'
        WHERE id_pengguna = $id_pengguna");
    
    return 1;
}

function buatForum($data) {
    global $conn;

    //create and issue the first query
    $judul_forum = $data["judul_forum"];
    $isi_forum = $data["isi_forum"];
    $tanggal_forum = date('Y-m-d H:i:s');
    $id_pengguna = $data["id_pengguna"];
    $nama = $data["nama"];
    $tambah_forum = "INSERT INTO forum VALUES(
                    '',
                    '$judul_forum',
                    '$isi_forum',
                    '$tanggal_forum',
                    '$id_pengguna',
                    '$nama',
                    '0'
                    )";
    mysqli_query($conn, $tambah_forum) or die(mysqli_error());

    return mysqli_affected_rows($conn);
}

function tambahKomentar($data) {
    global $conn;

    $id_forum = $data["id_forum"];
    $id_pengguna = $data["id_pengguna"];
    $tanggal_komentar = date('Y-m-d H:i:s');
    $nama = $data["nama"];
    $isi_komentar = $data["isi_komentar"];

    $tambah_komentar = "INSERT INTO komentar VALUES(
                        '',
                        '$id_forum',
                        '$id_pengguna',
                        '$isi_komentar',
                        '$tanggal_komentar',
                        '$nama')";
    mysqli_query($conn, $tambah_komentar) or die(mysqli_error());
    return mysqli_affected_rows($conn);
}

?>