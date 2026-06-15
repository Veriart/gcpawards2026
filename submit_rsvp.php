<?php
// Mengatur header respons sebagai JSON untuk komunikasi dengan JavaScript
header('Content-Type: application/json');

// --- KONFIGURASI DATABASE ---
// Sesuaikan nilai-nilai ini dengan pengaturan server lokal Anda (misalnya dari XAMPP).
$servername = "localhost";      // Alamat server database, biasanya "localhost"
$username = "root";           // Nama pengguna database, defaultnya "root"
$password = "";               // Kata sandi database, defaultnya kosong
$dbname = "yuva_metland"; // Nama database yang Anda buat sebelumnya

// --- MEMBUAT KONEKSI ---
$conn = new mysqli($servername, $username, $password, $dbname);

// --- MEMERIKSA KONEKSI ---
if ($conn->connect_error) {
    // Jika koneksi gagal, kirim pesan error dan hentikan skrip
    echo json_encode(['status' => 'error', 'message' => 'Koneksi database gagal: ' . $conn->connect_error]);
    exit();
}

// --- MENGAMBIL DATA DARI FORMULIR ---
// Mengambil data yang dikirim melalui metode POST dari HTML
$nama_lengkap = $_POST['name'];
$siswa = $_POST['student'];
$kelas = $_POST['class'];
$nomor_wa = $_POST['nomor_wa'];
// $jumlah_kehadiran = $_POST['attendees'];
$status_kehadiran = $_POST['status'];

// --- MENYIAPKAN DAN MENJALANKAN QUERY SQL ---
// Menyiapkan perintah SQL dengan prepared statement untuk keamanan (mencegah SQL Injection)
$stmt = $conn->prepare("INSERT INTO rsvp (nama_lengkap, siswa, kelas, nomor_wa, status_kehadiran) VALUES (?, ?, ?, ?, ?)");

// Mengikat variabel PHP ke placeholder (?) dalam perintah SQL
// "ssis" berarti: string, string, integer, string
$stmt->bind_param("sssss", $nama_lengkap, $siswa, $kelas, $nomor_wa, $status_kehadiran);

// Menjalankan perintah
if ($stmt->execute()) {
    // Jika berhasil, kirim pesan sukses
    echo json_encode(['status' => 'success', 'message' => 'Konfirmasi berhasil disimpan.']);
} else {
    // Jika gagal, kirim pesan error
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan konfirmasi: ' . $stmt->error]);
}

// --- MENUTUP KONEKSI ---
$stmt->close();
$conn->close();
?>
