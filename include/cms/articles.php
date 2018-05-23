<?php

class articles {
    public $database;
    
    public $error;
    
    function __construct($database) {
        $this->database = $database;
    }
    
    function all($visibleonly = true) {
        $statement = $this->database->prepare('SELECT * FROM `' . db_prefix . 'articles` ' . ($visibleonly ? 'WHERE `visibility` = 1 ' : '') . 'ORDER BY `id`');
        $statement->execute();
        $statement->bind_result($result->id, $result->title, $result->created, $result->published, $result->body, $result->visibility);
        
        $articles = array();
        
        while($statement->fetch()) {
            $article = new stdClass();
            $article->id = $result->id;
            $article->title = $result->title;
            $article->created = $result->created;
            $article->published = $result->published;
            $article->body = $result->body;
            $article->visibility = $result->visibility;
            
            $articles[$article->id] = $article;
        }
        
        return $articles;
    }
    
    function get($id) {
	    $statement = $this->database->prepare('SELECT * FROM `' . db_prefix . 'articles` WHERE `id` = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        
        $statement->bind_result($result->id, $result->title, $result->created, $result->published, $result->body, $result->visibility);

        $statement->fetch();
        
        return $result;
    }
        
    function add() {
        $statement = $this->database->prepare('INSERT INTO `' . db_prefix . 'articles` (`title`, `created`, `visibility`) VALUES (\'Nieuw artikel\', UNIX_TIMESTAMP(), 0)');
        $statement->execute();
        
        return $statement->insert_id;
    }
    
    function update($id, $title, $body) {
        $statement = $this->database->prepare('UPDATE `' . db_prefix . 'articles` SET `title` = ?, `body` = ? WHERE `id` = ?');
        $statement->bind_param('ssi', $title, $body, $id);
        $statement->execute();
        
        return true;
    }
    
    function delete($id) {
        $statement = $this->database->prepare('DELETE FROM `' . db_prefix . 'articles` WHERE `id` = ?');
        $statement->bind_param('i', $id);
        $statement->execute();

        return true;
    }
    
    function publish($id, $visibility) {
    	$statement = $this->database->prepare('
        	UPDATE
        		`' . db_prefix . 'articles`
        	SET
        		`visibility` = ?,
        		`published` = UNIX_TIMESTAMP()
        	WHERE
        		`id` = ?');
        		
        $visibility = ($visibility == 'true' ? 1 : 0);
        
        $statement->bind_param('ii', $visibility, $id);
        $statement->execute();
        
        return $visibility;
    }
}