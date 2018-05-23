<?php

# Create connection with constants defined in './config.php'
$database = new MySQLi(db_host, db_username, db_password);
$database->select_db(db_database);