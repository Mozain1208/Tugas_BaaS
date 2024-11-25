<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Kuliah</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Data Mata Kuliah</h1>
    <form action="../search/search_matakuliah.php" method="get" style="text-align: center;">
        <input type="text" name="query" placeholder="Cari Matakuliah" required>
        <button type="submit">Search</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Mata Kuliah</th>
                <th>Nama Mata Kuliah</th>
                <th>Jumlah SKS</th>
                <th>Aksi<th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Konfigurasi API Supabase
            $url = "https://ygstilffqlzipymovgrt.supabase.co/rest/v1/Mata_Kuliah";
            $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inlnc3RpbGZmcWx6aXB5bW92Z3J0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3Mjg4NzA1OTEsImV4cCI6MjA0NDQ0NjU5MX0.quf1Sgz8qIuhH1cJQk6Nw6d3odkSHDAdJSADVTDoWvg";

            // Header permintaan
            $headers = [
                "apikey: $apiKey",
                "Authorization: Bearer $apiKey"
            ];

            // Inisialisasi cURL
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // Eksekusi cURL
            $response = curl_exec($ch);

            // Cek apakah ada error
            if ($response === false) {
                echo "<tr><td colspan='4'>Error: " . curl_error($ch) . "</td></tr>";
            } else {
                // Konversi JSON ke array
                $data = json_decode($response, true);

                // Periksa apakah data ada
                if (!empty($data)) {
                    foreach ($data as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['kode_mk']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama_mk']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['sks']) . "</td>";
                        echo "<td>
                                <a href='../edit/edit_matakuliah.php?id=" . htmlspecialchars($row['id']) . "'>Edit</a> |
                                <a href='../delete/delete_matakuliah.php?id=" . htmlspecialchars($row['id']) . "' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Data tidak ditemukan.</td></tr>";
                }
            }

            // Tutup cURL
            curl_close($ch);
            ?>
        </tbody>
    </table>
</body>
</html>
