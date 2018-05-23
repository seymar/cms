<?php

class cms {
    private $database;
    
    private $contents;
    private $pages;
    
    private $id;
    private $page;
    
    private $page_initialized = false;
    
    private $active_content = array();
    private $active_content_names = array();
    
    public function __construct($database) {
        $this->database = $database;
        
        include_once SR . 'include/cms/pages.php';        
        $this->pages = new pages($this->database);
    
        include_once SR . 'include/cms/contents.php';
        $this->contents = new contents($this->database);

        $this->page = $_SERVER['SCRIPT_NAME'];
    }
    
    private function initialize_page() {
        if(!$id = $this->pages->exists($this->page)) {
            $id = $this->pages->add($this->page);
        }
        
        $this->id = $id;
  		
  		$this->page_initialized = true;
  		
        return true;
    }
    
    public function page($page) {
    	if($this->page_initialized) {
    		exit('Fout in gebruik CMS, pagina moet gedefinieerd zijn vóórdat er content wordt aangeroepen');
    	
    		return false;
    	}
    	
    	$this->page = $page;
    	
    	return $this;
    }

    public function content($name) {
    	if(!$this->page_initialized) {
    		$this->initialize_page();
    	}
    	
    	if(in_array($name, $this->active_content_names)) {
    		exit('Fout in gebruik CMS, content naam moet uniek zijn per pagina.');
    	}
    
        if(!$this->contents->exists($this->id, $name)) {
            $this->contents->add($this->id, $name);
        }

        $this->contents->fetchByName($this->id, $name);
        
        $this->active_content[] = $this->contents->fetch['id'];
        $this->active_content_names[] = $this->contents->fetch['name'];
        
        include_once SR . 'library/ubb.function.php';
		
        if($this->contents->fetch['type'] == 'single') {
            echo ubb(nl2br($this->contents->fetch['text']));
        } else if($this->contents->fetch['type'] == 'multiple') {
            include_once 'multiples.php';
            
            $multiples = new multiples($this->database);
            
            $multiples->fetch($this->contents->fetch['id']);
            
            foreach($multiples->fetch as $key => $value) {
                echo $this->contents->fetch['before'] . ubb($value['content']) . $this->contents->fetch['after'];
            }
        }
        
        return $this;
    }
    
    public function blog() {
        include_once 'articles.php';
        
        include_once SR . 'library/ubb.function.php';
        
		$articles = new articles($this->database);
    	
    	if(isset($_GET['id'])) {
    		if(!$article = $articles->get($_GET['id'])) {
    			echo 'Article not found';
    			
    			return false;
    		}
    		
    		if($article->visibility == 0) {
    			echo 'Article not found';
    			
    			return false;
    		}
    		
    		echo '<article>
    			<h1>' . $article->title . '</h1>
    			<span class="date"> ' . date('d-m-Y', $article->published) . '</span>
    			<br />
    			' . ubb($article->body) . '
    		</article>';
    		
    		return true;
        }
		
		$articlesAll = $articles->all();
		
		if(sizeof($articlesAll) < 1) {
			echo 'No articles yet';
		}
		
        foreach($articlesAll as $article) {
	        echo '<article>
    			<h1><a href="' . $article->id . '/' . preg_replace('/[^a-z0-9-"\']/', '', str_replace(' ', '-', strtolower($article->title))) . '/">' . $article->title . '</a></h1>
    			<span class="date">' . date('d-m-Y', $article->published) . '</span>
    			<br />
    			' . substr(ubb($article->body), 0, 250) . '
    			<br />
    			<a href="' . $article->id . '/' . preg_replace('/[^a-z0-9-"\']/', '', str_replace(' ', '-', strtolower($article->title))) . '/" class="button">Read more</a>
    		</article>';
        }
        
	    return true;
    }
    
    public function __destruct() {
    	if(!$this->page_initialized) {
    		$this->initialize_page();
    	}
    
        $this->contents->fetch($this->id);
        
        foreach(@$this->contents->fetch as $key => $value) {
            if(!in_array($key, $this->active_content)) {
                $this->contents->disable($key);
            } else {
                $this->contents->enable($key);
            }
        }
    }
}