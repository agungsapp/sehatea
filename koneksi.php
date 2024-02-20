<?php

$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "lowongan";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (mysqli_connect_errno()) {
  die("Koneksi database gagal: " . mysqli_connect_error());
}
