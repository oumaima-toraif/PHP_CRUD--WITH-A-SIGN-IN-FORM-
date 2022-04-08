<?php
$host="localhost";
$username="root";
$pwd="";
$dbname="mydb";
//cnx
$con=mysqli_connect($host,$username,$pwd,$dbname);

if(mysqli_connect_errno()){
    die("cannot connect to DB".mysqli_connect_errno());
}
define("UPLOAD_SRC",$_SERVER['DOCUMENT_ROOT']."/project/img/");
define("FETCH_SRC", "http://127.0.0.1/project/img/");

?>