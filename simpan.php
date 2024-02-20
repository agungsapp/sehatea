<?php

require_once "koneksi.php";

// Pastikan ada data yang dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Pastikan data yang diterima tidak kosong
  if (!empty($_POST['nama']) && !empty($_POST['usia']) && !empty($_POST['nomor']) && !empty($_POST['jk']) && !empty($_POST['alamat']) && isset($_POST['pengalaman']) && isset($_POST['pengalaman_detail'])) {
    // Siapkan data untuk disimpan
    $nama = $_POST['nama'];
    $usia = $_POST['usia'];
    $nomor = $_POST['nomor'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $pengalaman = $_POST['pengalaman'];
    $pengalaman_detail = $_POST['pengalaman_detail'];

    // Query untuk menyimpan data
    $sql = "INSERT INTO pelamar (nama, usia, jk, pengalaman, alamat, nomor) VALUES ('$nama', '$usia', '$jk', '$pengalaman_detail', '$alamat', '$nomor')";

    // Jalankan query
    if ($koneksi->query($sql) === TRUE) {
      // Jika penyimpanan berhasil, kirim respons berhasil
      $response = array("status" => "success", "message" => "Data berhasil disimpan!");
      echo json_encode($response);
    } else {
      // Jika terjadi kesalahan, kirim respons gagal
      $response = array("status" => "error", "message" => "Terjadi kesalahan saat menyimpan data: " . $koneksi->error);
      echo json_encode($response);
    }
  } else {
    // Jika data tidak lengkap, kirim respons gagal
    $response = array("status" => "error", "message" => "Data tidak lengkap!");
    echo json_encode($response);
  }
} else {
  // Jika metode request bukan POST, kirim respons gagal
  $response = array("status" => "error", "message" => "Metode request tidak valid!");
  echo json_encode($response);
}
