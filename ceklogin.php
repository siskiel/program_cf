<title>ceklogin</title>
<?php
include 'koneksi.php';
if (isset($_POST['log'])){
	$user = mysqli_real_escape_string($link, $_POST['username']);
	$pass = mysqli_real_escape_string($link, $_POST['password']);
	$pass = md5($pass);

	$query = mysqli_query($link, "SELECT*FROM user WHERE username='$user' AND password= '$pass'");
	$data = mysqli_fetch_array($query);
	$username = $data['username'];
	$password = $data['password'];
	$nama = $data['nama'];
	$level = $data['level'];

	if ($user==$username && $pass==$password && $nama==$nama ) {
		session_start();
		$_SESSION['user'] = $username;
		$_SESSION['nama'] = $nama;
		$_SESSION['level'] = $level;

		if ($level ==='admin') {
			echo "<script> alert('Haiii $username Anda Berhasil Login Sebagai : $level'); </script>";
			echo "<meta http-equiv= 'refresh' content='0; url=admin/home.php'>";
		}else{
			echo "<script> alert('Haiii $username Anda Berhasil Login Sebagai : $level'); </script>";
			echo "<meta http-equiv= 'refresh' content='0; url=/index3.php'>";
		}
		
	}else{
		echo "<script> alert('Username dan Password Salah. Silahkan ulangi dengan benar'); </script>";
		echo "<meta http-equiv= 'refresh' content='0; url=login.php'>";
	}
}
?>