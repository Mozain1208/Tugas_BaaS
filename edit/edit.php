<?php
// Konfigurasi API Supabase
$url = "https://ygstilffqlzipymovgrt.supabase.co/rest/v1/mahasiswa";
$apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inlnc3RpbGZmcWx6aXB5bW92Z3J0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3Mjg4NzA1OTEsImV4cCI6MjA0NDQ0NjU5MX0.quf1Sgz8qIuhH1cJQk6Nw6d3odkSHDAdJSADVTDoWvg";

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
$data = null;

if ($id) {
    // Ambil data mahasiswa berdasarkan ID
    $ch = curl_init("$url?id=eq.$id");
    $headers = [
        "apikey: $apiKey",
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($statusCode == 200 && $response) {
        $data = json_decode($response, true)[0] ?? null;
    } else {
        echo "Error: Gagal mengambil data. Status Code: $statusCode";
    }

    curl_close($ch);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa</title>
</head>
<body>
    <h1>Edit Mahasiswa</h1>
    <?php if ($data): ?>
        <form action="../update/update.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id']); ?>">
            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required><br><br>
            <label for="nim">NIM:</label><br>
            <input type="text" id="nim" name="nim" value="<?php echo htmlspecialchars($data['nim']); ?>" required><br><br>
            <label for="prodi">Prodi:</label><br>
            <input type="text" id="prodi" name="prodi" value="<?php echo htmlspecialchars($data['prodi']); ?>" required><br><br>
            <button type="submit">Update</button>
        </form>
    <?php else: ?>
        <p>Data tidak ditemukan.</p>
    <?php endif; ?>
</body>
</html>
