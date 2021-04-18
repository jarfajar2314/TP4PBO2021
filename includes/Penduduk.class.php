<?php 

/******************************************
id
nik
nama
tempat lahir
tanggal lahir
jenis kelamin
alamat
******************************************/

class Penduduk extends DB{
	
	// Mengambil data
	function getPenduduk(){
		$query = "SELECT * FROM penduduk";
		return $this->execute($query);
	}

	function getSPenduduk($id){
		$query = "SELECT * FROM penduduk WHERE id='$id'";
		return $this->execute($query);
	}

	function insertData($nik, $nama, $tmp_lahir, $tgl_lahir, $jk, $alamat){		
		$query = "INSERT INTO penduduk (id, nik, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat) VALUES (NULL, '$nik', '$nama', '$tmp_lahir', '$tgl_lahir', '$jk', '$alamat')";
        // print_r($query);
		return $this->execute($query);
	}
	
	function updatePenduduk($id, $nik, $nama, $tmp_lahir, $tgl_lahir, $jk, $alamat){
		// $query = "UPDATE penduduk SET status_td='Sudah' WHERE id='$id'";
        $query = "UPDATE penduduk SET nik = '$nik', nama = '$nama', tempat_lahir = '$tmp_lahir', tanggal_lahir = '$tgl_lahir', jenis_kelamin = '$jk', alamat = '$alamat' WHERE id = '$id'";
		// print_r($query);
		return $this->execute($query);
	}
	
	function deletePenduduk($id){
		$query = "DELETE FROM penduduk WHERE id=$id";
		return $this->execute($query);
	}
	

}



?>