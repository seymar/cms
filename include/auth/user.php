<?php

# Content Management System by Stijn Martens, Devcube Development
# © All rights reserved

class user {
    protected $database;
    
    public $error;

    public $signed_in = false;
    
    # User data
    public $id;
    public $email;
    public $firstname;
    public $lastname;
    public $type;
    
    public function __construct($database) {
        $this->database = $database;
        $this->validate_session();
    }
    
    private function validate_session() {
        if(@$_SESSION['signed_in'] != true) {
            $this->signed_in = false;
            
            return false;
        }
        
        $statement = $this->database->prepare('SELECT `email`, `firstname`, `lastname`, `type` FROM `' . db_prefix . 'users` WHERE `id` = ? AND `password` = ? AND `activated` = \'yes\'');
        $statement->bind_param('ss', $_SESSION['id'], $_SESSION['password']);
        $statement->execute();
        
        $statement->store_result();
        if($statement->num_rows != 1) {
            $this->signed_in = false;
            $this->sign_out();
            
            return false;
        }
        
        $this->signed_in = true;
        
        $statement->bind_result($result['email'], $result['firstname'], $result['lastname'], $result['type']);
        $statement->fetch();
        
        $this->id = $_SESSION['id'];
        $this->email = $result['email'];
        $this->firstname = $result['firstname'];
        $this->lastname = $result['lastname'];
        $this->type = $result['type'];
        
        $statement->store_result();
        if($statement->num_rows != 1) {
            $this->signed_in = false;
            $this->sign_out();
            
            return false;
        }
        
        $statement = $this->database->prepare('UPDATE `' . db_prefix . 'users` SET `last_time` = ?, `last_ip` = ? WHERE `id` = ?');
        $statement->bind_param('isi', date('U'), $_SERVER['REMOTE_ADDR'], $_SESSION['id']);
        $statement->execute();
        
        return true;
    }
    
    private function create_session($id, $password) {
        $_SESSION['signed_in'] = true;
        
        $_SESSION['id'] = $id;
        $_SESSION['password'] = $password;
    }
    
    public function sign_in($email, $password) {
        # Save submitted email for use in forms on other pages
        $_SESSION['email'] = $email;
        
        if(empty($email) OR $password == md5('')) {
            $this->error = 'Vul alle velden in!';
            return false;
        }
             
        $statement = $this->database->prepare('SELECT `id`, `password`, `enabled` FROM `' . db_prefix . 'users` WHERE `email` = ? AND `password` = ?');
        $statement->bind_param('ss', $email, sha1($password . $password));
        $statement->execute();
        
        $statement->store_result();
        if($statement->num_rows() != 1) {
            $this->error = 'Ongeldige combinatie!';
            return false;
        }
        
        $statement->bind_result($result['id'], $result['password'], $result['enabled']);
        $statement->fetch();
        
        if($result['enabled'] != 'yes') {
            $this->error = 'Account geblokkeerd!';
            return false;
        }
                
        $this->create_session($result['id'], $result['password']);
        
        return true;
    }
    
    public function sign_out() {
        session_destroy();
        unset($_SESSION);
        
        return true;
    }
    
    # Signup by invite
    public function signup($firstname, $lastname, $password_new, $password_confirm) {
        if($password_new == md5('') OR $password_confirm == md5('')) {
            $this->error = 'Vul alle velden in!';
            return false;
        }
        
        if($password_new != $password_confirm) {
            $this->error = 'Wachtwoorden zijn niet hetzelfde!';
            return false;
        }
    
        $statement = $this->database->prepare('SELECT `id` FROM `' . db_prefix . 'users` WHERE `activation_id` = ?');
        $statement->bind_param('s', $_GET['id']);
        $statement->execute();
        
        $statement->store_result();
        if($statement->num_rows != 1) {
            $this->error = 'Ongeldige link!';
            return false;
        }
        
        $statement->bind_result($result['id']);
        $statement->fetch();
        
        $statement = $this->database->prepare('UPDATE `' . db_prefix . 'users` SET `firstname` = ?, `lastname` = ?, `password` = ?, `activation_id` = \'\', `activated` = \'yes\' WHERE `id` = ?');
        $statement->bind_param('sssi', $firstname, $lastname, sha1($password_new . $password_new), $result['id']);
        $statement->execute();
        
        return true;

    }
    
    /*
    ** Public sign up
    
    public function sign_up($firstname, $lastname, $email, $password, $password_confirm) {
        if(empty($firstname) OR empty($lastname) OR empty($email) OR $password == md5('') OR $password_confirm == md5('')) {
            $this->error = 'Vul alle velden in!';
            return false;
        }
        
        include_once '../library/function/email_valid.php';
        if(!email_valid($email)) {
            $this->error = 'Ongeldig email-adres!';
            return false;
        }
        
        if($password != $password_confirm) {
            $this->error = 'Wachtwoorden zijn niet hetzelfde!';
            return false;
        }
        
        $statement = $this->database->prepare('SELECT `id` FROM `' . db_prefix . 'users` WHERE `email` = ?');
        $statement->bind_param('s', $email);
        $statement->execute();
        
        $statement->store_result();
        if($statement->num_rows == 1) {
            $this->error = 'Email-adres al geregistreerd!';
            return false;
        }
        
        include_once 'activation.php';
        $activation = new activation();
        
        $statement = $this->database->prepare('INSERT INTO `' . db_prefix . 'users` (`firstname`, `lastname`, `email`, `password`, `signup_ip`, `signup_time`, `activation_id`) VALUES (?, ?, ?, ?, ?, unix_timestamp(), ?)');
        $statement->bind_param('ssssss', $firstname, $lastname, $email, sha1($password . $password), $_SERVER['REMOTE_ADDR'], $activation->id);
        $statement->execute();
        
        $activation->send($email);
        
        return true;
    }
    */
    
    
    public function invitation_verify($id) {
        $statement = $this->database->prepare('SELECT `id` FROM `' . db_prefix . 'users` WHERE `activation_id` = ?');
        $statement->bind_param('s', $id);
        $statement->execute();
        
        $statement->store_result();
        if($statement->num_rows != 1) {
            $this->error = 'Ongeldige link!';
            return false;
        }

        return true;
    }

    public function activate($activation_id) {
        $statement = $this->database->prepare('UPDATE `' . db_prefix . 'users` SET `activated` = \'yes\', `activation_id` = \'\' WHERE `activation_id` = ?');
        $statement->bind_param('s', $activation_id);
        $statement->execute();
        
        if($statement->error) {
            $this->error = 'Ongeldige link! <a href="../../resend/">Nieuwe ontvangen?</a>';
            return false;
        }
        
        return true;
    }
    
    public function resend($email) {
    	$_SESSION['email'] = $email;
    	
        $statement = $this->database->prepare('SELECT `id` FROM `' . db_prefix . 'users` WHERE `email` = ?');
        $statement->bind_param('s', $email);
        $statement->execute();
        
        $statement->store_result();
        if($statement->num_rows != 1) {
            $this->error = 'Ongeldig email-adres!';
            return false;
        }
        
        $statement = $this->database->prepare('SELECT `activated` FROM `' . db_prefix . 'users` WHERE `email` = ?');
        $statement->bind_param('s', $email);
        $statement->execute();
        
        $statement->bind_result($result['activated']);
        $statement->fetch();
        
        if($result['activated'] != 'no') {
            $this->error = 'Account is al geactiveerd!';
            return false;
        }
        
        $statement->close();
        
        include_once 'activation.php';
        $activation = new activation();
        
        $statement = $this->database->prepare('UPDATE `' . db_prefix . 'users` SET `activation_id` = ? WHERE `email` = ?');
        $statement->bind_param('ss', $activation->id, $email);
        $statement->execute();
        
        $activation->send($email);
        
        return true;
    }
    
    public function lost($email) {
        $statement = $this->database->prepare('SELECT `id` FROM `' . db_prefix . 'users` WHERE `email` = ?');
        $statement->bind_param('s', $email);
        $statement->execute();
        
        $statement->store_result();
        if($statement->num_rows != 1) {
            $this->error = 'Ongeldig email-adres!';
            return false;
        }
        
        include_once 'recovery.php';
        $recovery = new recovery($this->database);
        
        $statement = $this->database->prepare('UPDATE `' . db_prefix . 'users` SET `recovery_id` = ? WHERE `email` = ?');
        $statement->bind_param('ss', $recovery->recovery_id, $email);
        $statement->execute();
        
        $recovery->send($email);
        
        return true;
    }
    
    public function recover($password_new, $password_confirm, $recovery_id) {
        if($password_new == md5('') OR $password_confirm == md5('')) {
            $this->error = 'Vul alle velden in!';
            return false;
        }
        
        if($password_new != $password_confirm) {
            $this->error = 'Wachtwoorden zijn niet hetzelfde!';
            return false;
        }
    
        $statement = $this->database->prepare('SELECT `id` FROM `' . db_prefix . 'users` WHERE `recovery_id` = ?');
        $statement->bind_param('s', $recovery_id);
        $statement->execute();
        
        $statement->store_result();
        if($statement->num_rows != 1) {
            $this->error = 'Ongeldige link! <a href="../lost/">Nieuwe ontvangen?</a>';
            return false;
        }
        
        $statement->bind_result($result['id']);
        $statement->fetch();
        
        $statement = $this->database->prepare('UPDATE `' . db_prefix . 'users` SET `password` = ?, `recovery_id` = \'\' WHERE `id` = ?');
        $statement->bind_param('si', sha1($password_new . $password_new), $result['id']);
        $statement->execute();
        
        return true;
    }

    public function invite($email, $type) {
        if(empty($email)) {
            $this->error = 'Vul alle velden in!';
            return false;
        }


        include_once SR . 'library/email_valid.function.php';

        if(!email_valid($email)) {
            $this->error = 'Ongeldig email-adres!';
            return false;
        }
        
        if(!in_array($type, array('admin', 'editor'))) {
	        $this->error = 'Ongeldig type!';
	        return false;
        }

        $statement = $this->database->prepare('SELECT `id` FROM `' . db_prefix . 'users` WHERE `email` = ?');
        $statement->bind_param('s', $email);
        $statement->execute();
        
        $statement->store_result();
        if($statement->num_rows == 1) {
            $this->error = 'Email-adres al geregistreerd!';
            return false;
        }
        
        include_once 'invitation.php';
        $invitation = new invitation($this);
        
        $statement = $this->database->prepare('INSERT INTO `' . db_prefix . 'users` (`email`, `activation_id`, `type`) VALUES (?, ?, ?)');
        $statement->bind_param('sss', $email, $invitation->id, $type);
        $statement->execute();
        
        $invitation->send($email);
        
        return true;
    }
    
    public function update_password($password, $password_new, $password_confirm) {
        if($password == md5('') OR $password_new == md5('') OR $password_confirm == md5('')) {
            $this->error = 'Vul alle velden in!';
            return false;
        }
        
        if($password_new != $password_confirm) {
            $this->error = 'Wachtwoorden zijn niet hetzelfde!';
            return false;
        }
        $statement = $this->database->prepare('SELECT `id` FROM `' . db_prefix . 'users` WHERE `id` = ? AND `password` = ?');
        $statement->bind_param('is', $_SESSION['id'], sha1($password . $password));
        $statement->execute();
        
        $statement->store_result();
        if($statement->num_rows != 1) {
            $this->error = 'Verkeerd wachtwoord!';
            return false;
        }
        $statement->close();

        $statement = $this->database->prepare('UPDATE `' . db_prefix . 'users` SET `password` = ? WHERE `id` = ?');
        $statement->bind_param('si', sha1($password_new . $password_new), $_SESSION['id']);
        $statement->execute();
        
        $_SESSION['password'] = sha1($password_new . $password_new);
        
        return true;
    }
    
    public function getAll() {
        $statement = $this->database->prepare('SELECT `id`, `email`, `firstname`, `lastname`, `last_time`, `type`, `activated`, `enabled` FROM `' . db_prefix . 'users` ORDER BY `id`');
        $statement->execute();
        $statement->bind_result($result['id'], $result['email'], $result['firstname'], $result['lastname'], $result['last_time'], $result['type'], $result['activated'], $result['enabled']);
        
        $users = array();
        
        while($statement->fetch()) {
            $users[$result['id']] = unserialize(serialize($result));
        }
        
        return $users;
    }
    
    public function getByField($field, $value) {
	    $statement = $this->database->prepare('SELECT * FROM `' . db_prefix . 'users` WHERE `' . $field . '` = ?');
	    $statement->bind_param((is_string($value) ? 's' : 'i'), $value);
        $statement->execute();
        $statement->bind_result($result['id'], $result['email'], $result['password'], $result['firstname'], $result['lastname'], $result['type'], $result['signup_ip'], $result['signup_time'], $result['last_ip'], $result['last_time'], $result['activation_id'], $result['recovery_id'], $result['activated'], $result['enabled']);
        
        $users = array();
        
        while($statement->fetch()) {
            $users[$result['id']] = unserialize(serialize($result));
        }
        
        return $users;
    }
    
    public function delete($id) {
    	$user = $this->getByField('id', $id);
    	$admins = sizeof($this->getByField('type', 'admin'));
    	
    	if($user[$id]['type'] == 'admin' && $admins <= 1) {
	    	$this->error = 'De gebruiker die je wilt verwijderen is de enige admin, omdat er geen toegang meer zal zijn tot het systeem is de gebruiker niet verwijderd.';
	    	
	    	return false;
    	}
    	
        $statement = $this->database->prepare('DELETE FROM `'. db_prefix .'users` WHERE `id` = ?');
        $statement->bind_param('i', $id);
        //$statement->execute();
        
        return true;
    }
}