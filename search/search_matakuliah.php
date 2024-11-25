<?php
$query = $_GET['query'] ?? '';
$url = "https://ygstilffqlzipymovgrt.supabase.co/rest/v1/Mata_Kuliah?or=(kode_mk.ilike.*$query*,nama_mk.ilike.*$query*)";
$apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inlnc3RpbGZmcWx6aXB5bW92Z3J0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3Mjg4NzA1OTEsImV4cCI6MjA0NDQ0NjU5MX0.quf1Sgz8qIuhH1cJQk6Nw6d3odkSHDAdJSADVTDoWvg";

$headers = [
    "apikey: $apiKey",
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($statusCode == 200) {
    $data = json_decode($response, true);

    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Kode Mata Kuliah</th><th>Nama Mata Kuliah</th><th>SKS</th></tr>";

    foreach ($data as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['kode_mk']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nama_mk']) . "</td>";
        echo "<td>" . htmlspecialchars($row['sks']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Error: Gagal mencari data. Status Code: $statusCode";
}

curl_close($ch);
?>
