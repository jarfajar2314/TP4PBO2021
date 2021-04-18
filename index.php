<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Penduduk.class.php");

// Membuat objek dari kelas task
$oPenduduk = new Penduduk($db_host, $db_user, $db_password, $db_name);
// Membaca template skin.html
$tpl = new Template("templates/skin1.html");

$oPenduduk->open();

// Add Data
if (isset($_POST['submit'])) {
	$nik = $_POST['nik'];
	$nama = $_POST['nama'];
	$tmp_lahir = $_POST['tmp_lahir'];
	$tgl_lahir = $_POST['tgl_lahir'];
	$jk = $_POST['jk'];
	$alamat = $_POST['alamat'];
	$res = $oPenduduk->insertData($nik, $nama, $tmp_lahir, $tgl_lahir, $jk, $alamat);
	if(!$res){
		$msg = " <div class='alert alert-danger' role='alert'>
					Data Gagal Ditambahkan! " . $res . "
				</div>";
	}
	else{
		$msg = " <div class='alert alert-success' role='alert'>
					Data Berhasil Ditambahkan!
				</div>";
	}
	print($msg);
}

// Update Data
if (isset($_POST['update'])) {
	$id = $_POST['id'];
	$nik = $_POST['nik'];
	$nama = $_POST['nama'];
	$tmp_lahir = $_POST['tmp_lahir'];
	$tgl_lahir = $_POST['tgl_lahir'];
	$jk = $_POST['jk'];
	$alamat = $_POST['alamat'];
	$res = $oPenduduk->updatePenduduk($id, $nik, $nama, $tmp_lahir, $tgl_lahir, $jk, $alamat);
	if(!$res){
		$msg = " <div class='alert alert-danger' role='alert'>
					Data Gagal Diperbarui! " . $res . "
				</div>";
	}
	else{
		$msg = " <div class='alert alert-success' role='alert'>
					Data Berhasil Diperbarui!
				</div>";
	}
	print($msg);
}

// Untuk input dan update data ///////////////////////
function inputTag($type, $name="", $val = ""){
	if($type == "select"){
		$res = "<select class='form-select' aria-label='Default select example' name='jk'>";
		if($val == "L"){
			$res .= "
				<option>Pilih Jenis Kelamin</option>
				<option value='L' selected>Laki-Laki</option>
				<option value='P'>Perempuan</option>
			";
		}
		else if($val == "P"){
			$res .= "
				<option>Pilih Jenis Kelamin</option>
				<option value='L'>Laki-Laki</option>
				<option value='P' selected>Perempuan</option>
			";
		}
		else{
			$res .= "
				<option selected>Pilih Jenis Kelamin</option>
				<option value='L'>Laki-Laki</option>
				<option value='P'>Perempuan</option>
			";
		}
		$res .= "</select>";
	}
	else if($type == "add_btn"){
		$res = "<button type='submit' class='btn btn-primary' name='submit'>Submit</button>";
	}
	else if($type == "edit_btn"){
		$res = "
			<input type='text' class='form-control visually-hidden' name='id' value='$val'>
			<button type='submit' class='btn btn-primary' name='update'>Update</button>
			<a class='btn btn-danger' href='/' role='button'>Cancel</a>
		";
	}
	else {
		$res = "<input type='$type' class='form-control' name='$name' value='$val'>";
	}
	return $res;
}

$textArr = [];
$keyArr = ["INPUT_NIK", "INPUT_NAMA", "INPUT_TMPLAHIR", "INPUT_TGLLAHIR", "INPUT_JK", "INPUT_ALAMAT"];
if(isset($_GET['id_edit'])){
	$title = "<h5 class='card-title'>Edit Data</h5>";
	$oPenduduk->getSPenduduk($_GET['id_edit']);
	$res = $oPenduduk->getResult();
	// print_r($res);
	array_push($textArr, inputTag("text", "nik", $res[1]));
	array_push($textArr, inputTag("text", "nama", $res[2]));
	array_push($textArr, inputTag("text", "tmp_lahir", $res[3]));
	array_push($textArr, inputTag("date", "tgl_lahir", $res[4]));
	array_push($textArr, inputTag("select", "jk", $res[5]));
	array_push($textArr, inputTag("text", "alamat", $res[6]));
	$btn = inputTag("edit_btn", "", $res[0]);
}
else{
	$title = "<h5 class='card-title'>Tambah Data</h5>";
	array_push($textArr, inputTag("text", "nik"));
	array_push($textArr, inputTag("text", "nama"));
	array_push($textArr, inputTag("text", "tmp_lahir"));
	array_push($textArr, inputTag("date", "tgl_lahir"));
	array_push($textArr, inputTag("select", "jk"));
	array_push($textArr, inputTag("text", "alamat"));
	$btn = inputTag("add_btn");
}
$tpl->replace("TITLE", $title);	
$tpl->replace("BTN_CONTROL", $btn);	
for($i = 0; $i < 6; $i++){
	$tpl->replace($keyArr[$i], $textArr[$i]);
}

// Delete Data
if(isset($_GET['id_hapus'])){
	$res = $oPenduduk->deletePenduduk($_GET['id_hapus']);
	header('Location: /');
}

// Proses mengisi tabel dengan data
$oPenduduk->getPenduduk();
$data = null;
$no = 1;
while (list($id, $nik, $nama, $tmp_lahir, $tgl_lahir, $jk, $alamat) = $oPenduduk->getResult()) {
	$data .= "<tr>
	<td>" . $no . "</td>
	<td>" . $nik . "</td>
	<td>" . $nama . "</td>
	<td>" . $tmp_lahir . "</td>
	<td>" . $tgl_lahir . "</td>
	<td>" . $jk . "</td>
	<td>" . $alamat . "</td>
	<td>	
	<a class='btn btn-primary mb-1' href='index.php?id_edit=" . $id .  "' role='button'>Edit</a>
	<a class='btn btn-danger' href='index.php?id_hapus=" . $id .  "' role='button'>Hapus</a>
	</td>
	</tr>";
	$no++;
}


// Menutup koneksi database
$oPenduduk->close();

// Mengganti kode Data_Tabel dengan data yang sudah diproses
$tpl->replace("DATA_TABEL", $data);

// Menampilkan ke layar
$tpl->write();