<?php
    $conn = mysqli_connect("localhost", "root", "", "yuva_metland");

    $attendees = mysqli_query($conn, "SELECT * FROM rsvp");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Yuva Abhipraya Nawasena</title>

    <!-- Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Inter & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <style>
        /* Mengimpor font menggunakan @import untuk stabilitas yang lebih baik */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@700&display=swap');

        /* Custom styles for fonts and animations */
        body {
            font-family: 'Inter', sans-serif;
            /* New background image with responsive properties */
            /* background-image: url('img/undangan_bg2.jpeg'); */
            background-image: url('img/undangan_bg2.jpeg');
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
        }

        .font-serif-display {
            font-family: 'Playfair Display', serif;
        }

        /* Simple fade-in animation for elements
        .fade-in-section {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        } */

        .fade-in-section.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Carousel styles */
        .carousel-container {
            width: 100%;
            overflow: hidden;
            position: relative;
            /* Add a fade effect to the edges */
            -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
            mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
        }

        .carousel-track {
            display: flex;
            /* 11 original images + 11 duplicates * 250px width each */
            width: calc(250px * 22);
            animation: scroll 60s linear infinite;
        }

        .carousel-item {
            width: 250px;
            height: 200px;
            object-fit: cover;
            padding: 0 8px;
            flex-shrink: 0;
            border-radius: 0.5rem;
            /* 8px */
        }

        /* Pause animation on hover */
        .carousel-container:hover .carousel-track {
            animation-play-state: paused;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                /* Scroll by the width of the original 11 images */
                transform: translateX(calc(-250px * 11));
            }
        }

    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    <!-- Main Container -->
    <!-- Padding diatur responsif: p-4 untuk mobile, sm:p-8 untuk layar lebih besar -->
    <div class="container mx-auto max-w-3xl p-4 sm:p-8">

        <!-- Header Section -->
        <header class="text-center my-8 fade-in-section">
            <!-- Ukuran font responsif: text-3xl (default), sm:text-4xl, md:text-5xl -->
            <br>
            <br>
            <h1 class="font-serif-display text-3xl sm:text-4xl md:text-5xl font-bold text-sky-800 ">Penghargaan</h1>
            <h2 class="text-2xl sm:text-3xl font-semibold text-slate-600 mt-2">Yuva Abhipraya Nawasena</h2>
            <p class="mt-4 text-slate-500 italic">"Orang muda yang pantang menyerah dan bercita-cita tinggi."</p>
        </header>

        <section id="rsvp-section"
            class="my-12 text-center bg-sky-800/80 backdrop-blur-sm text-white p-6 sm:p-8 rounded-lg shadow-lg fade-in-section">
            <div id="rsvp-form-container">
                <h3 class="font-serif-display text-2xl font-bold mb-4">Daftar Konfirmasi Kehadiran</h3>
                <!-- Badge Summary -->
                <div class="flex justify-center gap-3 mb-4 text-xs">
                    <?php
                        $hadir = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM rsvp WHERE status_kehadiran='hadir'"))['t'];
                        $tidak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM rsvp WHERE status_kehadiran='tidak hadir'"))['t'];
                    ?>
                    <span class="px-2 py-1 rounded-full bg-green-100 text-green-700">Hadir: <?= $hadir ?></span>
                    <span class="px-2 py-1 rounded-full bg-red-100 text-red-700">Tidak: <?= $tidak ?></span>
                </div>
                <!-- Wrapper agar tabel bisa digulir horizontal di layar kecil -->
                <div class="overflow-x-auto">
                    <!-- Tombol Export & Sortir -->
                    <div class="flex flex-wrap items-center justify-between mb-3 gap-2">
                        <button id="export-excel" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded text-xs">Export Excel</button>
                        <div class="flex items-center gap-2 text-xs">
                            <label for="sort-select" class="text-white/90">Urutkan:</label>
                            <select id="sort-select" class="px-2 py-1 rounded text-slate-800">
                                <option value="nama_asc">Nama Ibu A-Z</option>
                                <option value="nama_desc">Nama Ibu Z-A</option>
                                <option value="siswa_desc">Nama Siswa ↓</option>
                                <option value="siswa_asc">Nama Siswa ↑</option>
                                <option value="status_asc">Status A-Z</option>
                                <option value="status_desc">Status Z-A</option>
                            </select>
                        </div>
                    </div>

                    <table id="attendee-table" class="w-full text-left text-sm min-w-[500px]">
                        <thead>
                            <tr class="border-b border-white/30">
                                <th class="py-2 px-3">#</th>
                                <th class="py-2 px-3 cursor-pointer" data-sort="nama">Nama Ibu ▼</th>
                                <th class="py-2 px-3 cursor-pointer" data-sort="siswa">Siswa ▼</th>
                                <th class="py-2 px-3">Whatsapp</th>
                                <th class="py-2 px-3 text-center cursor-pointer" data-sort="status">Status ▼</th>
                            </tr>
                        </thead>
                        <tbody id="attendee-list">
                            <?php
                                $no = 1;
                                while($row = mysqli_fetch_assoc($attendees)){
                            ?>
                            <tr class="border-b border-white/30" data-nama="<?= strtolower($row['nama_lengkap']) ?>" data-jumlah="<?= $row['jumlah_kehadiran'] ?>" data-status="<?= strtolower($row['status_kehadiran']) ?>">
                                <td class="py-2 px-3"><?php echo $no++; ?></td>
                                <td class="py-2 px-3"><?php echo $row['nama_lengkap']; ?></td>
                                <td class="py-2 px-3"><?php echo $row['siswa']; ?></td>
                                <td class="py-2 px-3"><?php echo $row['nomor_wa']; ?></td>
                                <td class="py-2 px-3 text-center"><?php echo $row['status_kehadiran']; ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>

                    <script>
                    // Fungsi Export ke Excel
                    document.getElementById('export-excel').addEventListener('click', function () {
                        const table = document.getElementById('attendee-table');
                        let html = table.outerHTML;

                        // Buat file HTML dengan tabel yang bisa dibuka Excel
                        const uri = 'data:application/vnd.ms-excel;base64,';
                        const template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"><head><meta charset="utf-8"/><style>table{border-collapse:collapse;}th,td{border:1px solid #000;padding:4px;}</style></head><body>' + html + '</body></html>';
                        const base64 = (s) => window.btoa(unescape(encodeURIComponent(s)));
                        const link = document.createElement('a');
                        link.href = uri + base64(template);
                        link.download = 'daftar-kehadiran-yuva.xls';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    });

                    // Fungsi Sortir
                    function sortTable(type, dir) {
                        const tbody = document.getElementById('attendee-list');
                        const rows = Array.from(tbody.querySelectorAll('tr'));

                        rows.sort((a, b) => {
                            let valA, valB;
                            switch(type) {
                                case 'nama':
                                    valA = a.dataset.nama;
                                    valB = b.dataset.nama;
                                    break;
                                case 'siswa':
                                    valA = parseInt(a.dataset.siswa, 10);
                                    valB = parseInt(b.dataset.siswa, 10);
                                    break;
                                case 'status':
                                    valA = a.dataset.status;
                                    valB = b.dataset.status;
                                    break;
                                default:
                                    return 0;
                            }

                            if (valA < valB) return dir === 'asc' ? -1 : 1;
                            if (valA > valB) return dir === 'asc' ? 1 : -1;
                            return 0;
                        });

                        // Re-render urutan
                        rows.forEach(row => tbody.appendChild(row));
                    }

                    // Event listener dropdown sortir
                    document.getElementById('sort-select').addEventListener('change', function () {
                        const [type, dir] = this.value.split('_');
                        sortTable(type, dir);
                    });

                    // Event listener klik header kolom
                    document.querySelectorAll('th[data-sort]').forEach(th => {
                        th.addEventListener('click', function () {
                            const type = this.dataset.sort;
                            const currentDir = this.dataset.dir || 'asc';
                            const newDir = currentDir === 'asc' ? 'desc' : 'asc';
                            this.dataset.dir = newDir;
                            sortTable(type, newDir);
                            // Update indicator
                            document.querySelectorAll('th[data-sort]').forEach(el => el.innerHTML = el.innerHTML.replace(/[▼▲]/g, ''));
                            this.innerHTML = this.innerHTML + (newDir === 'asc' ? '▲' : '▼');
                        });
                    });
                    </script>
                </div>
            </div>
        </section>
        
        <!-- Footer -->
        <footer
            class="text-center mt-12 mb-6 text-slate-700 text-sm fade-in-section bg-white/50 backdrop-blur-sm p-4 rounded-lg">
            <!-- <p>Tuhan memberkati. 🙏</p> -->
            <p class="mt-1">&copy; 2025 SMK Pariwisata Metland School</p>
        </footer>

    </div>

</body>

</html>