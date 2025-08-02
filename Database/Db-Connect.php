<?php

$sname= "localhost";
$uname= "root";
$password= "";

$db_name= "matrimony";



$conn = mysqli_connect($sname,$uname,$password,$db_name);

  if (!$conn) {
    echo "connection faild";
  }
