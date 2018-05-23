<?php

class pages {
    public $database;
    
    public $error;
    
    public $fetch;
    
    function __construct($database) {
        $this->database = $database;
    }
    
    function fetch($id = false) {
        if(!$id) {
            $statement = $this->database->prepare('SELECT * FROM `' . db_prefix . 'pages` ORDER BY `id`');
            $statement->execute();
            $statement->bind_result($result['id'], $result['name'], $result['url'], $result['last_time']);
            
            while($statement->fetch()) {
                $this->fetch[$result['id']] = array(
                    'id' => $result['id'],
                    'name' => $result['name'],
                    'url' => $result['url'],
                    'last_time' => $result['last_time']
                );
            }
        } else {
            $statement = $this->database->prepare('SELECT * FROM `' . db_prefix . 'pages` WHERE `id` = ? ORDER BY `id`');
            $statement->bind_param('i', $id);
            $statement->execute();
            
            $statement->bind_result($result['id'], $result['name'], $result['url'], $result['last_time']);
            
            $statement->fetch();
            
            
            $this->fetch = array(
                'id' => $result['id'],
                'name' => $result['name'],
                'url' => $result['url'],
                'last_time' => $result['last_time']
            );
        }
		
        return (!$this->fetch ? array() : $this->fetch);
    }
    
    function exists($file) {
        $statement = $this->database->prepare('SELECT `id` FROM `' . db_prefix . 'pages` WHERE `file` = ?');
        $statement->bind_param('s', $file);
        $statement->execute();
        
        $statement->store_result();
        
        $statement->bind_result($result['id']);
        $statement->fetch();
        
        if($statement->num_rows != 0) {    
            $statement->fetch();
            return $result['id'];
        }
        
        return false;
    }
    
    function add($file) {
        $statement = $this->database->prepare('INSERT INTO `' . db_prefix . 'pages` (`file`) VALUES (?)');
        $statement->bind_param('s', $file);
        $statement->execute();
        
        return $statement->insert_id;
    }
    
    function delete($id) {
        $statement = $this->database->prepare('DELETE FROM `' . db_prefix . 'pages` WHERE `id` = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        
        return true;
    }
    
    function page_update($id, $name, $url) {
    
    }
}