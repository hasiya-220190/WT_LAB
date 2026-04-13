<?php 
require __DIR__ . '/vendor/autoload.php'; 
$client = new MongoDB\Client("mongodb://localhost:27017"); 
echo "MongoDB connected successfully!"; 
?>