<?php 

/*$host = "ec2-54-246-121-32.eu-west-1.compute.amazonaws.com";
$dbname = "d7ku1stf7uhdtp";
$user = "ptexiwpnwsmvel";
$pass = "690f242d5547f6b8be4180a1c84bfb14bee840ee8e6df15bfb98f724d34ba440";
$connect = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);*/

$parts = (parse_url(getenv('DATABASE_URL') ?: 'postgres://ptexiwpnwsmvel:690f242d5547f6b8be4180a1c84bfb14bee840ee8e6df15bfb98f724d34ba440@ec2-54-246-121-32.eu-west-1.compute.amazonaws.com:5432/d7ku1stf7uhdtp'));
extract($parts);
$path = ltrim($path, "/");
$connect = new PDO("pgsql:host={$host};port={$port};dbname={$path}", $user, $pass);
        
return $connect;  

?>
