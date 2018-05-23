<?php

class Model {
	protected $tableName = '';

	protected $MySQLi;

	public function __construct() {
		$this->setTableName();

		$this->MySQLi = new MySQLi('localhost', 'devcuml17_1', 'CUW489sL', 'devcuml17_1');
	}

	public function setTableName() {
		$this->tableName = strtolower(get_class($this)) . 's';
	}
}