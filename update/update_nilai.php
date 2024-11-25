<?php
// Konfigurasi API Supabase
$url = "https://ygstilffqlzipymovgrt.supabase.co/rest/v1/Nilai";
$apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inlnc3RpbGZmcWx6aXB5bW92Z3J0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3Mjg4NzA1OTEsImV4cCI6MjA0NDQ0NjU5MX0.quf1Sgz8qIuhH1cJQk6Nw6d3odkSHDAdJSADVTDoWvg";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    
    if ($id) {
        // Data yang akan diupdate
        $updateData = [
            'nim' => $_POST['nim'],
            'kode_mk' => $_POST['kode_mk'],
            'nilai' => $_POST['nilai']
        ];

        // Inisialisasi cURL
        $ch = curl_init("$url?id=eq.$id");
        
        // Set header
        $headers = [
            "apikey: $apiKey",
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json",
            "Prefer: return=minimal"
        ];

        // Set opsi cURL
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($updateData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Eksekusi cURL
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($statusCode === 204) {
            // Redirect jika berhasil
            header("Location: ../display/display_nilai.php?status=updated");
        } else {
            // Tampilkan pesan error
            echo "Error: Gagal mengupdate data. Status Code: $statusCode";
            echo "<br>Response: " . htmlspecialchars($response);
        }

        curl_close($ch);
    } else {
        echo "Error: ID tidak valid.";
    }
}

exit;
?>
