<?php
$connection = new PDO('mysql:host=localhost;dbname=nirs_db_new', 'mysql', 'Converse2020');
if (!$connection) {
    die('Error connect to db!');
}