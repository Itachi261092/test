<?php
session_start();
require $_SERVER['DOCUMENT_ROOT']."/core/Model.php";

$prize = pickRandomPrize($_SESSION['user_hash']);
echo json_encode($prize);