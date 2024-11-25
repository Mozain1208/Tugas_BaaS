<?php
// Konfigurasi API Supabase
$url = "https://ygstilffqlzipymovgrt.supabase.co/rest/v1/Mata_Kuliah";
$apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inlnc3RpbGZmcWx6aXB5bW92Z3J0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3Mjg4NzA1OTEsImV4cCI6MjA0NDQ0NjU5MX0.quf1Sgz8qIuhH1cJQk6Nw6d3odkSHDAdJSADVTDoWvg";

// Ambil data dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_mk = $_POST['kode_mk'];
    $nama_mk = $_POST['nama_mk'];
    $sks = $_POST['sks'];

    // Data untuk dikirim ke API
    $data = [
        "kode_mk" => $kode_mk,
        "nama_mk" => $nama_mk,
        "sks" => $sks
    ];

    // Konversi data ke format JSON
    $jsonData = json_encode($data);

    // Konfigurasi cURL
    $headers = [
        "Content-Type: application/json",
        "apikey: $apiKey",
        "Authorization: Bearer $apiKey"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Eksekusi permintaan
    $response = curl_exec($ch);

    // Cek hasil
    if ($response === false) {
        echo "Error: " . curl_error($ch);
    } else {
        echo "Data berhasil disimpan: " . $response;
    }

    // Tutup cURL
    curl_close($ch);
} else {
    echo "Metode pengiriman tidak valid.";
}
?>
