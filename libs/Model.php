<?php
    class Model{
	public $db;
   
	function __construct(){
	    $this->db = New Database(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS);
            $this->db->query('SET NAMES utf8mb4');
	}
}
