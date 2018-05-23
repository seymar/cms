<?php

class multiples {
	public $database;
	
	public $error;
	
	public $fetch;
	
	function __construct($database) {
		$this->database = $database;
	}
	
	function fetch($content_id) {
		$statement = $this->database->prepare('SELECT * FROM `' . db_prefix . 'multiples` WHERE `content_id` = ? ORDER BY `id`');
		$statement->bind_param('i', $content_id);
		$statement->execute();
		$statement->bind_result($result['id'], $result['content_id'], $result['content']);
		while($statement->fetch()) {
			$this->fetch[$result['id']] = array(
				'id' => $result['id'],
				'content_id' => $result['content_id'],
				'content' => $result['content']
			);
		}

		return $this->fetch;
	}
	
	function exists($page_id, $name) {
		$statement = $this->database->prepare('SELECT * FROM `' . db_prefix . 'contents` WHERE `page_id` = ? && `name` = ?');
		$statement->bind_param('is', $page_id, $name);
		$statement->execute();
		
		$statement->store_result();
		
		$statement->bind_result($result['id'], $result['name'], $result['type'], $result['text'], $result['page_id'], $result['incode']);
		$statement->fetch();
		
		if($statement->num_rows != 0) {	
			$statement->fetch();
			
			return $result;
		}
		
		return false;
	}
	
	function add($content) {
		$statement = $this->database->prepare('INSERT INTO `' . db_prefix . 'multiples` (`content_id`, `content`) VALUES (?, ?)');
		$statement->bind_param('is', $_GET['id'], $content);
		$statement->execute();

		return $statement->insert_id;
	}

	function save($id, $content) {
		$statement = $this->database->prepare('UPDATE `' . db_prefix . 'multiples` SET `content` = ? WHERE `id` = ?');
		$statement->bind_param('si', $content, $id);
		$statement->execute();
		
		return true;
	}

	function delete($id) {
		$statement = $this->database->prepare('DELETE FROM `' . db_prefix . 'multiples` WHERE `id` = ?');
		$statement->bind_param('i', $id);
		$statement->execute();

		return true;
	}
	
	function disable($id) {
		$statement = $this->database->prepare('UPDATE `' . db_prefix . 'contents` SET `incode` = \'false\' WHERE `id` = ?');
		$statement->bind_param('i', $id);
		$statement->execute();
		
		return true;
	}
	
	function enable($id) {
		$statement = $this->database->prepare('UPDATE `' . db_prefix . 'contents` SET `incode` = \'true\' WHERE `id` = ?');
		$statement->bind_param('i', $id);
		$statement->execute();
		
		return true;
	}
	
	function update_text($id, $text) {
		$statement = $this->database->prepare('UPDATE `' . db_prefix . 'contents` SET `text` = ? WHERE `id` = ?');
		$statement->bind_param('si', $text, $id);
		$statement->execute();
		
		return true;
	}

	function update_type($id, $type) {
		$statement = $this->database->prepare('UPDATE `' . db_prefix . 'contents` SET `type` = ? WHERE `id` = ?');
		$statement->bind_param('si', $type, $id);
		$statement->execute();
		
		return true;
	}

	function update_settings($id, $before, $after) {
		$statement = $this->database->prepare('UPDATE `' . db_prefix . 'contents` SET `before` = ?, `after` = ? WHERE `id` = ?');
		$statement->bind_param('ssi', html_entity_decode($before), html_entity_decode($after), $id);
		$statement->execute();

		return true;
	}

}