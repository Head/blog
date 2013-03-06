<?php

class sampleDatabase {

	protected $dsn;
	protected $mysqli;

	public function __construct($dsn) {
		$this->dsn = parse_url($dsn);
	}

	public function query($sql, $args = array()) {
		if (!$this->mysqli) {
			$this->mysqli = new MySQLi(
											$this->dsn['host'],
											isset($this->dsn['user']) ? $this->dsn['user'] : 'root',
											isset($this->dsn['pass']) ? $this->dsn['pass'] : null,
											substr($this->dsn['path'], 1)
			);
		}
		if (count($args) > 0) {
			$sane = array();
			foreach ($args as $v) {
				$sane[] = $this->mysqli->real_escape_string($v);
			}
			$sql = vsprintf($sql, $sane);
		}
		$rc = $this->mysqli->query($sql);
		if (!$rc) {
			throw new Exception($this->mysqli->error, $this->mysqli->errno);
		}
		return new sampleDatabaseResult($this, $rc, $this->mysqli->insert_id);
	}

}

class sampleDatabaseResult {

	protected $result;
	protected $db;

	public function __construct(sampleDatabase $db, $rc, $insert_id) {
		$this->db = $db;
		$this->result = $rc;
		$this->insert_id = $insert_id;
	}

	public function __call($method, $params) {
		return call_user_func_array(array($this->result, $method), $params);
	}

	public function fetch_all($resulttype = MYSQLI_NUM) {
		if (method_exists('mysqli_result', 'fetch_all')) {
			$res = parent::fetch_all($resulttype);
		} else {
			for ($res = array(); $tmp = $this->fetch_array($resulttype);)
				$res[] = $tmp;
		}
		return $res;
	}

	public function __get($var) {
		return $this->result->$var;
	}

	public function insertId() {
		return $this->insert_id;
	}

}
