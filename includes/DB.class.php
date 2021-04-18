<?php

class DB{
	var $db_host = ''; // host
	var $db_user = ''; // username
	var $db_password = ''; // password
	var $db_name = ''; // nama database
	var $db_link = '';
	var $result = 0;

	function __construct($db_host='', $db_user='', $db_password='', $db_name=''){
		// konstruktor
		$this->db_host = $db_host;
		$this->db_user = $db_user;
		$this->db_password = $db_password;
		$this->db_name = $db_name;
	}

	function open(){
		// membuka koneksi
		$this->db_link = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_name);

	}

	function execute($query=""){
		// mengeksekusi query
		$this->result = mysqli_query($this->db_link, $query);
		return $this->result;
	}
	
	function getResult(){
		// mengambil ekseskusi query
		// print_r(mysqli_fetch_array($this->result));
		return mysqli_fetch_array($this->result);
	}

	function close(){
		// menutup koneksi
		mysqli_close($this->db_link);
	}
}



 ?>