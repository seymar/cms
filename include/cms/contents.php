<?php

class contents {
    public $database;
    
    public $error;
    
    public $fetch;
    
    function __construct($database) {
        $this->database = $database;
    }
    
    function fetch($page_id, $by = false, $identifier = false) {
        $fetch = array();
        
        if(!$by && !$identifier) {
            $statement = $this->database->prepare('SELECT * FROM `' . db_prefix . 'contents` WHERE `page_id` = ? ORDER BY `id`');
            $statement->bind_param('i', $page_id);
            $statement->execute();
            $statement->bind_result($result['id'], $result['name'], $result['type'], $result['text'], $result['page_id'], $result['incode'], $result['before'], $result['after']);
            
            while($statement->fetch()) {
                $fetch[$result['id']] = array(
                    'id' => $result['id'],
                    'name' => $result['name'],
                    'type' => $result['type'],
                    'text' => htmlentities($result['text']),
                    'page_id' => $result['page_id'],
                    'incode' => $result['incode'],
                    'before' => $result['before'],
                    'after' => $result['after']
                );
            }
        } else {
            $statement = $this->database->prepare('SELECT * FROM `' . db_prefix . 'contents` WHERE `' . ($by == 'id' ? 'id' : 'name') . '` = ?');
            $statement->bind_param('i', $identifier);
            $statement->execute();
            
            $statement->bind_result($result['id'], $result['name'], $result['type'], $result['text'], $result['page_id'], $result['incode'], $result['before'], $result['after']);

            $statement->fetch();
            
            $fetch = array(
                'id' => $result['id'],
                'name' => $result['name'],
                'type' => $result['type'],
                'text' => $result['text'],
                'page_id' => $result['page_id'],
                'incode' => $result['incode'],
                'before' => $result['before'],
                'after' => $result['after']
            );
        }
        
        $this->fetch = $fetch;
		
        return $fetch;
    }
    
    function fetchById($id) {
	    $statement = $this->database->prepare('SELECT * FROM `' . db_prefix . 'contents` WHERE `id` = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        
        $statement->bind_result($result['id'], $result['name'], $result['type'], $result['text'], $result['page_id'], $result['incode'], $result['before'], $result['after']);

        $statement->fetch();
        
        $this->fetch = $result;
        
        return $result;
    }
    
    function fetchByName($page_id, $name) {
	    $statement = $this->database->prepare('SELECT * FROM `' . db_prefix . 'contents` WHERE `page_id` = ? AND `name` = ?');
        $statement->bind_param('is', $page_id, $name);
        $statement->execute();
        
        $statement->bind_result($result['id'], $result['name'], $result['type'], $result['text'], $result['page_id'], $result['incode'], $result['before'], $result['after']);

        $statement->fetch();
        
        $this->fetch = $result;
        
        return $result;
    }
    
    function exists($page_id, $name) {
        $statement = $this->database->prepare('SELECT * FROM `' . db_prefix . 'contents` WHERE `page_id` = ? && `name` = ?');
        
        $statement->bind_param('is', $page_id, $name);
        $statement->execute();
        
        $statement->store_result();
        
        $statement->bind_result($result['id'], $result['name'], $result['type'], $result['text'], $result['page_id'], $result['incode'], $result['before'], $result['after']);
        $statement->fetch();
        
        if($statement->num_rows != 0) {    
            $statement->fetch();
            
            return array(
                'id' => $result['id'],
                'name' => $result['name'],
                'type' => $result['type'],
                'text' => $result['text'],
                'page_id' => $result['page_id'],
                'incode' => $result['incode']
            );
        }
        
        return false;
    }
    
    function add($page_id, $name) {
        $statement = $this->database->prepare('INSERT INTO `' . db_prefix . 'contents` (`page_id`, `name`) VALUES (?, ?)');
        $statement->bind_param('is', $page_id, $name);
        $statement->execute();
        
        return $statement->insert_id;
    }
    
    function delete($id) {
        $statement = $this->database->prepare('DELETE FROM `' . db_prefix . 'contents` WHERE `id` = ?');
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