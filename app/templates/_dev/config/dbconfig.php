<?php

define('DB_NAME', 'slurpdev');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'ds53ds53');

class Db {

	private $host;
	private $username;
	private $password;
	private $database;
	private $result;
	public function __construct($host, $username, $password, $database) {

		$this->host     = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;

		$this->connect();
	}

	private function connect() {
		$this->link = mysqli_connect($this->host, $this->username, $this->password, $this->database);
		mysqli_set_charset($this->link, "utf8");
	}

	public function query($sql) {
		if ($this->result = mysqli_query($this->link, $sql) or die(mysqli_error($this->link))) {
			return true;
		} else {
			return false;
		}
	}

	public function fetch() {

		return @mysqli_fetch_assoc($this->result);
	}

	public function getOne() {
		list($value) = mysqli_fetch_array($this->result);
		return $value;
	}

	public function rowCount() {
		return mysqli_num_rows($this->result);
	}

	public function insert($table, $arr) {

		$fields = "";
		$values = "";

		foreach ($arr as $k => $v) {
			$fields .= $k.",";
			$values .= "'".$this->esc($v)."',";
		}

		$fields = substr($fields, 0, -1);
		$values = substr($values, 0, -1);

		$sql = "insert into ".$table." (".$fields.") values (".$values.")";
		if ($this->query($sql)) {
			return true;
		} else {
			return false;
		}
	}

	public function update($table, $arr, $field, $id) {

		$sql = "";
		$i   = 0;
		foreach ($arr as $k => $v) {
			if ($i != 0) {
				$sql .= ", ";
			}
			$v = $this->esc($v);
			$sql .= "$k='$v'";
			$i++;
		}

		$sqlx = "UPDATE ".$table." SET ".$sql." WHERE ".$field."='".$id."'";

		if ($this->query($sqlx)) {
			return true;
		} else {
			return false;
		}
	}

	public function update2($table, $arr, $field) {

		$sql = "";
		$i   = 0;
		foreach ($arr as $k => $v) {
			if ($i != 0) {
				$sql .= ", ";
			}
			$v = $this->esc($v);
			$sql .= "$k='$v'";
			$i++;
		}

		$sqlx = "UPDATE ".$table." SET ".$sql." WHERE ".$field." ";

		// var_dump($sqlx);
		if ($this->query($sqlx)) {
			return true;
		} else {
			return false;
		}
	}

	public function esc($v, $type = "string") {
		if ($type == 'integer') {
			$v = (int) $v;
		}

		//return mysql_real_escape_string($v);
		return stripslashes($v);
	}

	public function lastId() {
		return mysqli_insert_id($this->link);
	}
}

$db = new Db('localhost', DB_USER, DB_PASSWORD, DB_NAME);

?>
