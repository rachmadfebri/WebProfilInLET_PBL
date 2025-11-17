<?php
require_once __DIR__ . '/database.php';

$db = new Database();
return $db->connect();
