<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nilai</title>
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
        #print-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        #print-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Data Nilai</h1>
    <form action="../search/search_nilai.php" method="get" style="text-align: center;">
        <input type="text" name="query" placeholder="Cari Nilai Mahasiswa" required>
        <button type="submit">Search</button>
    </form>

    <button id="print-button" onclick="printTable()">Cetak</button>

    <table id="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NIM</th>
                <th>Kode Mata Kuliah</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Konfigurasi API Supabase
            $url = "https://ygstilffqlzipymovgrt.supabase.co/rest/v1/Nilai";
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
                echo "<tr><td colspan='5'>Error: " . curl_error($ch) . "</td></tr>";
            } else {
                // Konversi JSON ke array
                $data = json_decode($response, true);

                // Periksa apakah data ada
                if (!empty($data)) {
                    foreach ($data as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['kode_mk']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nilai']) . "</td>";
                        echo "<td>
                                <a href='../edit/edit_nilai.php?id=" . htmlspecialchars($row['id']) . "'>Edit</a> |
                                <a href='../delete/delete_nilai.php?id=" . htmlspecialchars($row['id']) . "' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Data tidak ditemukan.</td></tr>";
                }
            }

            // Tutup cURL
            curl_close($ch);
            ?>
        </tbody>
    </table>

    <script>
        function printTable() {
            const printContents = document.getElementById("data-table").outerHTML;
            const printWindow = window.open("", "_blank");
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Cetak Data Nilai</title>
                        <style>
                            table {
                                width: 100%;
                                border-collapse: collapse;
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
                        <h1 style="text-align: center;">Data Nilai</h1>
                        ${printContents}
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</body>
</html>
