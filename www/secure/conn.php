<?php
$conn = new mysqli("db","user","pass","petReg");

if($conn->connect_error){
    die('connection failed: '.$conn->connect_error);

}