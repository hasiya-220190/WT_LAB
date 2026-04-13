<?php 
require __DIR__ . '/../vendor/autoload.php'; 
$client = new MongoDB\Client("mongodb://localhost:27017"); 
// Select database and collection 
$db = $client->i_mongoDB;        
// database name 
$users = $db->users;             
?> 