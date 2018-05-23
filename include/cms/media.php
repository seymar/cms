<?php

class media {
	public $database;
	
	public $error;

	public $fetch;
	
	function __construct($database) {
		$this->database = $database;
	}
	
	function upload($file) {
		if($file['size'] == 0) {
			$this->error = 'Geen bestand gekozen!';
			return false;
		}

		if(stripos($file['type'], 'image') === false) {
			$this->error = 'Bestand was geen afbeelding!';
			return false;
		}

		$ext = explode('.', $file['name']);
		$ext = $ext[sizeof($ext) - 1];
		
		$statement = $this->database->prepare('INSERT INTO `' . db_prefix . 'uploads` (`name`, `ext`) VALUES (?, ?)');
		$statement->bind_param('ss', $file['name'], $ext);
		$statement->execute();

		if(!move_uploaded_file($file['tmp_name'], 'uploads/' . $this->database->insert_id . '.' . $ext)) {
			$this->error = 'Kon bestand niet uploaden!';
			return false;
		}

		return true;
	}

	function fetch() {
		$statement = $this->database->prepare('SELECT * FROM `' . db_prefix . 'uploads` ORDER BY `id`');
		$statement->execute();

		$statement->bind_result($result['id'], $result['name'], $result['ext']);
		
		$fetch;
		
		while($statement->fetch()) {
			$fetch[$result['id']] = array(
				'id' => $result['id'],
				'name' => $result['name'],
				'ext' => $result['ext']
			);
		}
		@$this->fetch = $fetch;
	}

	function delete($id) {
		$statement = $this->database->prepare('DELETE FROM `' . db_prefix . 'uploads` WHERE `id` = ?');
		$statement->bind_param('i', $id);
		$statement->execute();

		return true;
	}
}