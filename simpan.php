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

    // Periksa apakah ada file yang diunggah
    if (isset($_FILES['foto'])) {
      $file_name = $_FILES['foto']['name'];
      $file_size = $_FILES['foto']['size'];
      $file_tmp = $_FILES['foto']['tmp_name'];
      $file_type = $_FILES['foto']['type'];

      // Lokasi folder untuk menyimpan file
      $upload_dir = "upload/";

      // Tentukan jenis file yang diizinkan untuk diunggah
      $allowed_extensions = array("jpg", "jpeg", "png", "gif");

      $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

      // Periksa apakah jenis file diizinkan
      if (in_array($file_extension, $allowed_extensions)) {
        // Pindahkan file yang diunggah ke folder upload
        $upload_path = $upload_dir . $file_name;
        move_uploaded_file($file_tmp, $upload_path);

        // Tambahkan kolom foto ke dalam query SQL
        $sql = "INSERT INTO pelamar (nama, usia, jk, pengalaman, alamat, nomor, foto) VALUES ('$nama', '$usia', '$jk', '$pengalaman_detail', '$alamat', '$nomor', '$file_name')";

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
        // Jika jenis file tidak diizinkan, kirim respons gagal
        $response = array("status" => "error", "message" => "Jenis file tidak diizinkan!");
        echo json_encode($response);
      }
    } else {
      // Jika file foto tidak ada, kirim respons gagal
      $response = array("status" => "error", "message" => "File foto tidak ditemukan!");
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
