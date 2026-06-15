<?php
// index.php
// Dynamic Invitation Webpage - Black & Gold Theme with QR entry

require_once 'config.php';

$code = $_GET['code'] ?? '';
$to = $_GET['to'] ?? '';

$student = null;
$guestName = 'Bapak/Ibu/Saudara/i';
$classroom = '';
$isStudent = false;
$hasRsvp = false;
$rsvpStatus = 'Pending';
$companionType = 'none';
$whatsapp = '';

if (!empty($code)) {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE code = ?");
    $stmt->execute([$code]);
    $student = $stmt->fetch();
    if ($student) {
        $guestName = $student['name'];
        $classroom = $student['classroom'];
        $isStudent = true;
        $rsvpStatus = $student['rsvp_status'];
        $companionType = $student['companion_type'];
        $whatsapp = $student['whatsapp'];
        if ($rsvpStatus !== 'Pending') {
            $hasRsvp = true;
        }
    }
} elseif (!empty($to)) {
    $guestName = htmlspecialchars(urldecode($to));
}
?>
<!doctype html>
<html class="scroll-smooth" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>GCP Award | SMK Pariwisata Metland School</title>
    <meta content="An appreciation night for the finest students of SMK Pariwisata Metland School who have brought pride to our school on the national and international stage." name="description" />
    <link href="img/metschoo/Metschoo.png" rel="icon" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              secondary: "#D4AF37", // Gold
              primary: "#050505",   // Rich Black
              cardBg: "#141414",    // Dark Card
            },
            fontFamily: {
              display: ["Playfair Display", "serif"],
              body: ["Poppins", "sans-serif"],
            },
          },
        },
      };
    </script>
    <style>
      * { box-sizing: border-box; }
      .material-symbols-outlined {
        font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
        vertical-align: middle;
      }
      #hero { position: relative; overflow: hidden; }
      #hero::before {
        content: "";
        position: absolute; inset: 0;
        background-image: url("img/gcp/drone-metland.png");
        background-size: cover; background-position: center;
        filter: blur(10px); transform: scale(1.1); z-index: 0;
      }
      #hero::after {
        content: "";
        position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(5,5,5,0.7) 0%, rgba(5,5,5,0.96) 100%);
        z-index: 1;
      }
      #hero > * { position: relative; z-index: 2; }
      
      .glass-card {
        background: rgba(255,255,255,0.04);
        backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.08);
      }
      .glass-card-gold {
        background: rgba(212, 175, 55, 0.05);
        backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(212, 175, 55, 0.18);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
      }
      .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.7s ease-out, transform 0.7s ease-out; }
      .reveal.active { opacity: 1; transform: translateY(0); }
      #loading-screen { z-index: 9999; transition: opacity 1s ease-in-out; }
      #main-nav { transition: all 0.4s ease; }
      #main-nav.scrolled {
        background: rgba(5,5,5,0.95);
        backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
        box-shadow: 0 4px 30px rgba(0,0,0,0.5);
        border-bottom: 1px solid rgba(212,175,55,0.15);
        padding-top: 1rem; padding-bottom: 1rem;
      }
      #mobile-menu { transition: all 0.35s cubic-bezier(0.4,0,0.2,1); max-height: 0; overflow: hidden; }
      #mobile-menu.open { max-height: 400px; }
      .timeline-line { position: absolute; left: 50%; top: 0; bottom: 0; width: 2px; background: rgba(212,175,55,0.25); transform: translateX(-50%); }
      @media (max-width: 767px) { .timeline-line { left: 20px; transform: none; } }
      .cat-card { transition: all 0.4s ease; }
      .cat-card:hover { background: #1f1f1f; transform: translateY(-4px); }
      .cat-card:hover p { color: #D4AF37; }
      .cat-card:hover .cat-icon { transform: scale(1.15); }
      .cat-icon { transition: transform 0.3s ease; }
      #progress-bar { transition: width 0.2s linear; }
      @keyframes bounce-gentle {
        0%, 100% { transform: translateY(0) translateX(-50%); }
        50% { transform: translateY(8px) translateX(-50%); }
      }
      .scroll-indicator { animation: bounce-gentle 2s infinite; }
      html { scroll-padding-top: 80px; }
      .form-input:focus { outline: none; border-color: #D4AF37; box-shadow: 0 0 0 3px rgba(212,175,55,0.2); }
      .stat-divider { border-right: 1px solid rgba(212,175,55,0.15); }
      @media (max-width: 767px) { .stat-divider { border-right: none; border-bottom: 1px solid rgba(212,175,55,0.15); } }
      
      /* Gold text selection */
      ::selection { background: #D4AF37; color: #000; }
    </style>
    <!-- html2canvas and qrcode.js CDNs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  </head>
  <body class="bg-[#050505] text-gray-100 font-body overflow-x-hidden overflow-hidden selection:bg-secondary selection:text-black">

    <!-- Ambient Audio -->
    <audio id="bg-music" loop>
      <source src="mars-metschoo.mp3" type="audio/mp3">
    </audio>

    <!-- Cover Overlay Screen -->
    <div id="cover-overlay" class="fixed inset-0 z-[150] flex flex-col items-center justify-center bg-black text-center px-5 overflow-hidden">
      <!-- Background Drone blur overlay -->
      <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('img/gcp/drone-metland.png'); filter: blur(5px);"></div>
      <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/95 to-black"></div>
      
      <!-- Elegant gold thin border frame -->
      <div class="absolute inset-4 sm:inset-6 border border-secondary/20 rounded-3xl pointer-events-none"></div>
      <div class="absolute inset-6 sm:inset-8 border border-secondary/5 rounded-3xl pointer-events-none"></div>

      <!-- Cover Content -->
      <div class="relative z-10 max-w-xl mx-auto flex flex-col items-center">
        <!-- Logo -->
        <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-5 py-2 mb-6 backdrop-blur-md">
          <img src="img/metschoo/Metschoo.png" alt="Logo" class="w-10 h-10 object-contain" />
          <span class="text-white text-xs font-bold uppercase tracking-wider">SMK Metland School</span>
        </div>
        
        <h2 class="font-display text-secondary text-base sm:text-lg tracking-[0.25em] uppercase mb-1">GCP Award 2026</h2>
        <p class="text-white/40 text-[10px] tracking-widest uppercase mb-10">Generasi Cinta Prestasi</p>
        
        <div class="w-20 h-px bg-gradient-to-r from-transparent via-secondary to-transparent mb-10"></div>
        
        <p class="text-gray-400 text-xs uppercase tracking-[0.2em] mb-3">Dear Honorable Guest,</p>
        <h1 class="font-display text-white mb-2 leading-tight uppercase px-4" style="font-size: clamp(1.8rem, 5vw, 3rem); font-weight: 700; letter-spacing: 0.05em;">
            <?= htmlspecialchars($guestName) ?>
        </h1>
        
        <?php if ($isStudent): ?>
            <p class="text-secondary text-sm font-semibold tracking-widest mb-10 uppercase border-y border-secondary/20 py-1 px-4"><?= htmlspecialchars($classroom) ?></p>
        <?php else: ?>
            <p class="text-white/50 text-xs tracking-wider mb-10 italic">Tamu Undangan</p>
        <?php endif; ?>

        <button id="btn-open-invitation" class="inline-flex items-center gap-2 bg-secondary text-primary font-bold px-8 py-4 rounded-full text-xs tracking-widest uppercase hover:scale-105 active:scale-95 transition-all shadow-[0_0_25px_rgba(212,175,55,0.3)] duration-300">
            <span class="material-symbols-outlined text-lg">mail</span>
            Open Invitation
        </button>
      </div>
    </div>

    <!-- Loading Screen -->
    <div class="fixed inset-0 bg-primary flex flex-col items-center justify-center" id="loading-screen">
      <div class="relative w-20 h-20 mb-6">
        <div class="absolute inset-0 border-4 border-secondary/20 rounded-full"></div>
        <div class="absolute inset-0 border-4 border-t-secondary rounded-full animate-spin"></div>
      </div>
      <p class="text-white font-display text-2xl tracking-[0.3em] uppercase mb-1">GCP Award 2026</p>
      <p class="text-white/40 text-xs tracking-widest uppercase">SMK Pariwisata Metland School</p>
    </div>

    <!-- Scroll Progress Bar -->
    <div class="fixed top-0 left-0 h-0.5 bg-secondary z-[60]" id="progress-bar" style="width:0%"></div>

    <!-- Floating Controls -->
    <div class="fixed bottom-6 right-4 sm:right-8 flex flex-col gap-3 z-[55]">
      <button class="w-11 h-11 rounded-full glass-card-gold flex items-center justify-center shadow-lg hover:scale-110 transition-transform bg-black/60 border border-secondary/30" id="music-toggle" title="Toggle music">
        <span class="material-symbols-outlined text-secondary text-xl">volume_up</span>
      </button>
      <a class="w-11 h-11 rounded-full bg-[#25D366] flex items-center justify-center shadow-lg hover:scale-110 transition-transform" href="https://wa.me/628123456789" title="WhatsApp Contact Support">
        <span class="material-symbols-outlined text-white text-xl">chat</span>
      </a>
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 px-4 sm:px-8 lg:px-16 py-5" id="main-nav">
      <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center gap-2">
          <img src="img/metschoo/Metschoo.png" alt="Metland School Logo" class="w-10 h-10 object-contain" />
          <span class="font-display text-white text-xl font-bold tracking-wide">Metschoo</span>
        </div>

        <!-- Desktop Nav -->
        <div class="hidden md:flex gap-8 items-center text-sm font-semibold tracking-wider uppercase">
          <a class="text-secondary border-b-2 border-secondary pb-0.5" href="#hero">Event</a>
          <a class="text-white/70 hover:text-secondary transition-colors" href="#schedule">Schedule</a>
          <a class="text-white/70 hover:text-secondary transition-colors" href="#about">Award</a>
          <a class="text-white/70 hover:text-secondary transition-colors" href="#gallery">Gallery</a>
        </div>

        <!-- Desktop CTA -->
        <a href="#rsvp" class="hidden md:inline-flex items-center gap-2 bg-secondary text-primary px-6 py-2.5 rounded-full font-bold text-sm hover:scale-105 transition-transform shadow-lg">
          RSVP Now
          <span class="material-symbols-outlined text-base">arrow_forward</span>
        </a>

        <!-- Mobile hamburger -->
        <button class="md:hidden w-10 h-10 flex flex-col items-center justify-center gap-1.5 rounded-lg" id="hamburger" aria-label="Menu">
          <span class="w-6 h-0.5 bg-white transition-all"></span>
          <span class="w-6 h-0.5 bg-white transition-all"></span>
          <span class="w-4 h-0.5 bg-white transition-all"></span>
        </button>
      </div>

      <!-- Mobile Menu -->
      <div id="mobile-menu" class="md:hidden bg-[#0A0A0A]/95 backdrop-blur-xl border border-secondary/10 rounded-2xl mt-3">
        <div class="px-6 py-4 flex flex-col gap-1">
          <a class="text-secondary font-semibold py-3 border-b border-white/5 text-sm tracking-wider uppercase" href="#hero" onclick="closeMobileMenu()">Event</a>
          <a class="text-white/80 hover:text-secondary py-3 border-b border-white/5 text-sm tracking-wider uppercase transition-colors" href="#schedule" onclick="closeMobileMenu()">Schedule</a>
          <a class="text-white/80 hover:text-secondary py-3 border-b border-white/5 text-sm tracking-wider uppercase transition-colors" href="#about" onclick="closeMobileMenu()">Award</a>
          <a class="text-white/80 hover:text-secondary py-3 border-b border-white/5 text-sm tracking-wider uppercase transition-colors" href="#gallery" onclick="closeMobileMenu()">Gallery</a>
          <a href="#rsvp" onclick="closeMobileMenu()" class="mt-3 bg-secondary text-primary px-6 py-3 rounded-full font-bold text-sm text-center hover:bg-secondary/90 transition-colors">
            Confirm Attendance
          </a>
        </div>
      </div>
    </nav>

    <main class="w-full">

      <!-- ===== HERO ===== -->
      <section class="w-full mx-auto px-5 sm:px-8 py-20 sm:py-32 flex flex-col items-center text-center reveal" id="hero">
        <div class="w-full max-w-5xl mx-auto px-5 sm:px-8 py-22 flex flex-col items-center text-center reveal" style="transition-delay:200ms">

          <!-- Badge -->
          <span class="inline-flex items-center gap-2 px-5 py-2 bg-secondary/15 border border-secondary/30 text-secondary text-xs font-bold rounded-full mb-6 tracking-[0.15em] uppercase backdrop-blur-sm">
            <span class="material-symbols-outlined text-base">emoji_events</span>
            GCP Award 2026
          </span>

          <!-- Title -->
          <h1 class="font-display text-white mb-4 leading-none uppercase tracking-wide" style="font-size: clamp(2.8rem, 10vw, 6.5rem); font-weight: 800; letter-spacing: 0.04em;">
            Generasi Cinta<br/>
            <span class="text-secondary italic" style="font-weight: 700;">Prestasi</span>
          </h1>

          <!-- Subtitle -->
          <p class="text-white/70 mb-8 leading-relaxed max-w-3xl" style="font-size: clamp(0.95rem, 2.5vw, 1.1rem)">
          An appreciation event celebrating the outstanding students of SMK Pariwisata Metland School who have brought pride to our school through their achievements at the national and international levels, inspiring excellence and future success.
          </p>

          <!-- Event Meta -->
          <div class="flex flex-wrap justify-center gap-4 sm:gap-8 mb-8 text-white/80 text-sm font-semibold tracking-wide bg-white/5 border border-white/10 rounded-2xl p-4 sm:p-5 backdrop-blur-md">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-secondary text-lg">calendar_month</span>
              Friday, June 19, 2026
            </div>
            <div class="flex items-center gap-2 h-4 w-px bg-white/10 hidden sm:block"></div>
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-secondary text-lg">schedule</span>
              13:00 – 17:00 WIB
            </div>
            <div class="flex items-center gap-2 h-4 w-px bg-white/10 hidden sm:block"></div>
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-secondary text-lg">location_on</span>
              Metland School Auditorium
            </div>
          </div>

          <!-- Countdown -->
          <div class="flex justify-center gap-3 sm:gap-4 mb-10" id="countdown">
            <div class="glass-card-gold px-4 sm:px-6 py-4 rounded-2xl text-center min-w-[75px] sm:min-w-[90px]">
              <div class="font-display text-2xl sm:text-3xl font-bold text-secondary" id="days">00</div>
              <div class="text-[9px] sm:text-[10px] uppercase tracking-widest text-white/50 mt-1">Days</div>
            </div>
            <div class="glass-card-gold px-4 sm:px-6 py-4 rounded-2xl text-center min-w-[75px] sm:min-w-[90px]">
              <div class="font-display text-2xl sm:text-3xl font-bold text-secondary" id="hours">00</div>
              <div class="text-[9px] sm:text-[10px] uppercase tracking-widest text-white/50 mt-1">Hours</div>
            </div>
            <div class="glass-card-gold px-4 sm:px-6 py-4 rounded-2xl text-center min-w-[75px] sm:min-w-[90px]">
              <div class="font-display text-2xl sm:text-3xl font-bold text-secondary" id="minutes">00</div>
              <div class="text-[9px] sm:text-[10px] uppercase tracking-widest text-white/50 mt-1">Mins</div>
            </div>
            <div class="glass-card-gold px-4 sm:px-6 py-4 rounded-2xl text-center min-w-[75px] sm:min-w-[90px]">
              <div class="font-display text-2xl sm:text-3xl font-bold text-secondary" id="seconds">00</div>
              <div class="text-[9px] sm:text-[10px] uppercase tracking-widest text-white/50 mt-1">Secs</div>
            </div>
          </div>

          <!-- CTAs -->
          <div class="flex flex-col sm:flex-row gap-4 justify-center w-full sm:w-auto">
            <a class="bg-secondary text-primary px-8 py-4 rounded-full font-bold text-sm tracking-widest hover:scale-105 transition-all shadow-[0_0_20px_rgba(212,175,55,0.2)] flex items-center justify-center gap-2" href="#about">
              VIEW INVITATION
              <span class="material-symbols-outlined text-base">expand_more</span>
            </a>
            <a class="border-2 border-secondary/35 text-secondary px-8 py-4 rounded-full font-bold text-sm tracking-widest hover:bg-secondary/10 transition-all backdrop-blur-sm text-center" href="#rsvp">
              CONFIRM ATTENDANCE
            </a>
          </div>
        </div>

        <!-- Scroll hint -->
        <div class="absolute bottom-8 left-1/2 scroll-indicator flex flex-col items-center gap-1 text-white/30">
          <span class="text-[9px] tracking-[0.2em] uppercase">Scroll</span>
          <span class="material-symbols-outlined text-lg">keyboard_arrow_down</span>
        </div>
      </section>

      <!-- ===== HEADMASTER WELCOME ===== -->
      <section class="py-20 sm:py-28 bg-[#0A0A0A] border-y border-secondary/5">
        <div class="max-w-6xl mx-auto px-5 sm:px-8 lg:px-16">
          <div class="bg-[#141414] rounded-3xl sm:rounded-[3rem] overflow-hidden flex flex-col md:flex-row items-stretch reveal shadow-2xl border border-secondary/10">
            <!-- Photo -->
            <div class="w-full md:w-2/5 h-64 sm:h-80 md:h-auto relative">
              <img alt="Principal" class="w-full h-full object-cover object-top" src="img/gcp/darmawan.jpeg" />
              <div class="absolute inset-0 bg-gradient-to-r from-transparent to-black/20"></div>
            </div>
            <!-- Content -->
            <div class="w-full md:w-3/5 p-8 sm:p-12 md:p-16 flex flex-col justify-center">
              <span class="material-symbols-outlined text-secondary text-5xl mb-5" style="font-variation-settings:'FILL' 1">format_quote</span>
              <h2 class="font-display text-2xl sm:text-3xl font-bold mb-5 text-white">Principal's Welcome Address</h2>
              <p class="font-body italic text-gray-300 mb-8 leading-relaxed text-base sm:text-lg">
                "Success is not the finish line, and failure is never fatal. What matters most is the courage to keep moving forward. Generation of Achievement is our shared stage to celebrate the fighting spirit of SMK Pariwisata Metland School students as they carve out their accomplishments."
              </p>
              <div class="border-l-4 border-secondary pl-5">
                <p class="font-display font-bold text-white text-xl">Dr. Darmawan Sunarja, MM.Par</p>
                <p class="text-gray-400 text-xs font-semibold uppercase tracking-[0.15em] mt-1">Principal, SMK Pariwisata Metland School</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ===== STATS ===== -->
      <section class="py-16 sm:py-24 bg-[#050505] text-white">
        <div class="max-w-5xl mx-auto px-5 sm:px-8">
          <div class="grid grid-cols-2 gap-8 max-w-md mx-auto justify-items-center bg-[#141414] border border-secondary/15 rounded-3xl p-6 sm:p-10 shadow-2xl">
            <div class="reveal text-center py-5 px-6" style="transition-delay:100ms">
              <div class="font-display text-secondary counter mb-2" data-target="68" style="font-size:clamp(2.5rem,7vw,4rem);font-weight:800;line-height:1">0</div>
              <p class="text-white/50 text-[10px] uppercase tracking-[0.2em] font-semibold">Awards</p>
            </div>
            <div class="reveal text-center py-5 px-6" style="transition-delay:400ms">
              <div class="font-display text-secondary counter mb-2" data-target="45" style="font-size:clamp(2.5rem,7vw,4rem);font-weight:800;line-height:1">0</div>
              <p class="text-white/50 text-[10px] uppercase tracking-[0.2em] font-semibold">Students</p>
            </div>
          </div>
        </div>
      </section>

      <!-- ===== AWARD CATEGORIES ===== -->
      <section class="py-20 sm:py-28 bg-[#0A0A0A] border-y border-secondary/5" id="about">
          <div class="max-w-6xl mx-auto px-5 sm:px-8 lg:px-16">
              <div class="text-center mb-14 reveal">
                  <span class="text-secondary text-xs font-bold tracking-[0.2em] uppercase mb-3 block">
                      Recognition Fields
                  </span>

                  <h2 class="font-display text-3xl sm:text-4xl md:text-5xl font-bold text-white">
                      Award Categories
                  </h2>

                  <div class="w-16 h-0.5 bg-secondary mx-auto mt-5 rounded-full"></div>
              </div>

              <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

                  <!-- Academic Excellence -->
                  <div class="cat-card bg-[#141414] p-6 rounded-2xl text-center reveal shadow-lg border border-secondary/10">
                      <span class="material-symbols-outlined text-secondary text-4xl block mb-3 cat-icon">
                          workspace_premium
                      </span>
                      <p class="font-bold text-white text-sm leading-tight transition-colors">
                          Academic Excellence
                      </p>
                  </div>

                  <!-- Mathematics -->
                  <div class="cat-card bg-[#141414] p-6 rounded-2xl text-center reveal shadow-lg border border-secondary/10">
                      <span class="material-symbols-outlined text-secondary text-4xl block mb-3 cat-icon">
                          functions
                      </span>
                      <p class="font-bold text-white text-sm leading-tight transition-colors">
                          Mathematics
                      </p>
                  </div>

                  <!-- English -->
                  <div class="cat-card bg-[#141414] p-6 rounded-2xl text-center reveal shadow-lg border border-secondary/10">
                      <span class="material-symbols-outlined text-secondary text-4xl block mb-3 cat-icon">
                          language
                      </span>
                      <p class="font-bold text-white text-sm leading-tight transition-colors">
                          English
                      </p>
                  </div>

                  <!-- Vocational Skills -->
                  <div class="cat-card bg-[#141414] p-6 rounded-2xl text-center reveal shadow-lg border border-secondary/10">
                      <span class="material-symbols-outlined text-secondary text-4xl block mb-3 cat-icon">
                          engineering
                      </span>
                      <p class="font-bold text-white text-sm leading-tight transition-colors">
                          Vocational Skills
                      </p>
                  </div>

                  <!-- Competition Achievement -->
                  <div class="cat-card bg-[#141414] p-6 rounded-2xl text-center reveal shadow-lg border border-secondary/10">
                      <span class="material-symbols-outlined text-secondary text-4xl block mb-3 cat-icon">
                          emoji_events
                      </span>
                      <p class="font-bold text-white text-sm leading-tight transition-colors">
                          Competition Achievement
                      </p>
                  </div>

                  <!-- GCP Role Model -->
                  <div class="cat-card bg-[#141414] p-6 rounded-2xl text-center reveal shadow-lg border border-secondary/10">
                      <span class="material-symbols-outlined text-secondary text-4xl block mb-3 cat-icon">
                          military_tech
                      </span>
                      <p class="font-bold text-white text-sm leading-tight transition-colors">
                          GCP Role Model
                      </p>
                  </div>

              </div>
          </div>
      </section>

      <!-- ===== EVENT DETAILS ===== -->
      <section class="py-20 sm:py-24 bg-[#050505]">
        <div class="max-w-6xl mx-auto px-5 sm:px-8 lg:px-16">
          <div class="text-center mb-12 reveal">
            <span class="text-secondary text-xs font-bold tracking-[0.2em] uppercase mb-3 block">Information</span>
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-white">Event Details</h2>
          </div>
          <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-[#141414] p-8 sm:p-10 rounded-3xl reveal shadow-lg border border-secondary/10">
              <div class="w-14 h-14 bg-secondary/10 rounded-2xl flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-secondary text-3xl">event</span>
              </div>
              <h3 class="font-display font-bold text-xl mb-3 text-white">Date &amp; Time</h3>
              <p class="text-gray-300 leading-relaxed">Friday, June 19, 2026<br/>13:00 – 17:00 WIB</p>
            </div>
            <div class="bg-[#141414] p-8 sm:p-10 rounded-3xl reveal shadow-lg border border-secondary/10" style="transition-delay:150ms">
              <div class="w-14 h-14 bg-secondary/10 rounded-2xl flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-secondary text-3xl">location_on</span>
              </div>
              <h3 class="font-display font-bold text-xl mb-3 text-white">Venue</h3>
              <p class="text-gray-300 leading-relaxed mb-5">Metland School Auditorium, 5th Floor, Cileungsi, Bogor.</p>
              <a href="https://maps.google.com" target="_blank" class="inline-flex items-center gap-2 text-secondary font-bold text-sm hover:gap-3 transition-all">
                Open in Maps <span class="material-symbols-outlined text-base">open_in_new</span>
              </a>
            </div>
            <div class="bg-[#141414] p-8 sm:p-10 rounded-3xl reveal shadow-lg border border-secondary/10 sm:col-span-2 lg:col-span-1" style="transition-delay:300ms">
              <div class="w-14 h-14 bg-secondary/10 rounded-2xl flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-secondary text-3xl">apparel</span>
              </div>
              <h3 class="font-display font-bold text-xl mb-3 text-white">Dress Code</h3>
              <p class="text-gray-300 leading-relaxed">
                  <b class="text-secondary">Ladies:</b> Black Formal Dress<br>
                  <b class="text-secondary">Gentlemen:</b> Black Suit or Blazer
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- ===== TIMELINE ===== -->
      <section class="py-20 sm:py-28 bg-[#0A0A0A] border-y border-secondary/5" id="schedule">
        <div class="max-w-4xl mx-auto px-5 sm:px-8 lg:px-16">
          <div class="text-center mb-16 reveal">
            <span class="text-secondary text-xs font-bold tracking-[0.2em] uppercase mb-3 block">Rundown</span>
            <h2 class="font-display text-3xl sm:text-4xl md:text-5xl font-bold text-white">
              Event Schedule
            </h2>
            <p class="text-gray-400 mt-3 text-base">
              Program lineup for the Graduation & Achievement Award Ceremony
            </p>
          </div>

          <div class="relative">
            <div class="timeline-line block"></div>

            <!-- 1 -->
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between mb-12 md:mb-16 reveal">
              <div class="w-full md:w-5/12 text-right md:pr-12 pl-12 md:pl-0">
                <span class="text-secondary font-bold text-lg">13:00 - 13:30</span>
              </div>
              <div class="hidden md:block w-5 h-5 bg-secondary rounded-full border-4 border-black shadow-lg z-10"></div>
              <div class="w-full md:w-5/12 pl-12">
                <h4 class="font-bold text-white text-xl mb-1">Registration</h4>
                <p class="text-gray-400">Guest registration and check-in scanner open.</p>
              </div>
            </div>

            <!-- 2 -->
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between mb-12 md:mb-16 reveal">
              <div class="w-full md:w-5/12 text-right md:pr-12 pl-12 md:pl-0">
                <h4 class="font-bold text-white text-xl mb-1">Opening Ceremony</h4>
                <p class="text-gray-400">Official opening of the event.</p>
              </div>
              <div class="hidden md:block w-5 h-5 bg-secondary rounded-full border-4 border-black shadow-lg z-10"></div>
              <div class="w-full md:w-5/12 pl-12">
                <span class="text-secondary font-bold text-lg">13:30 - 14:00</span>
              </div>
            </div>

            <!-- 3 -->
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between mb-12 md:mb-16 reveal">
              <div class="w-full md:w-5/12 text-right md:pr-12 pl-12 md:pl-0">
                <span class="text-secondary font-bold text-lg">14:00 - 15:30</span>
              </div>
              <div class="hidden md:block w-5 h-5 bg-secondary rounded-full border-4 border-black shadow-lg z-10"></div>
              <div class="w-full md:w-5/12 pl-12">
                <h4 class="font-bold text-white text-xl mb-1">Awarding Event</h4>
                <p class="text-gray-400">Awarding event performances.</p>
              </div>
            </div>

            <!-- 4 -->
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between mb-12 md:mb-16 reveal">
              <div class="w-full md:w-5/12 text-right md:pr-12 pl-12 md:pl-0">
                <h4 class="font-bold text-white text-xl mb-1">Entertainment</h4>
                <p class="text-gray-400">Entertainment performances.</p>
              </div>
              <div class="hidden md:block w-5 h-5 bg-secondary rounded-full border-4 border-black shadow-lg z-10"></div>
              <div class="w-full md:w-5/12 pl-12">
                <span class="text-secondary font-bold text-lg">15:30 - 17:00</span>
              </div>
            </div>

            <!-- 5 -->
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between reveal">
              <div class="w-full md:w-5/12 text-right md:pr-12 pl-12 md:pl-0">
                <span class="text-secondary font-bold text-lg">17:00</span>
              </div>
              <div class="hidden md:block w-5 h-5 bg-secondary rounded-full border-4 border-black shadow-lg z-10"></div>
              <div class="w-full md:w-5/12 pl-12">
                <h4 class="font-bold text-white text-xl mb-1">Closing</h4>
                <p class="text-gray-400">Event Finished</p>
              </div>
            </div>

          </div>
        </div>
      </section>


      <!-- ===== GALLERY ===== -->
      <section class="py-20 sm:py-28 bg-[#050505]" id="gallery">
        <div class="max-w-6xl mx-auto px-5 sm:px-8 lg:px-16">
          <div class="text-center mb-12 reveal">
            <span class="text-secondary text-xs font-bold tracking-[0.2em] uppercase mb-3 block">Our Best Moments</span>
            <h2 class="font-display text-3xl sm:text-4xl md:text-5xl font-bold text-white">Achievement Gallery</h2>
          </div>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
            <div class="aspect-square overflow-hidden rounded-2xl sm:rounded-3xl reveal shadow-md group border border-secondary/5 hover:border-secondary/20 transition-colors" style="transition-delay:0ms">
              <img alt="Gallery 1" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 cursor-pointer" src="img/gcp/gallery/1.JPG" />
            </div>
            <div class="aspect-square overflow-hidden rounded-2xl sm:rounded-3xl reveal shadow-md group border border-secondary/5 hover:border-secondary/20 transition-colors" style="transition-delay:80ms">
              <img alt="Gallery 2" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 cursor-pointer" src="img/gcp/gallery/4.JPG" />
            </div>
            <div class="aspect-square overflow-hidden rounded-2xl sm:rounded-3xl reveal shadow-md group border border-secondary/5 hover:border-secondary/20 transition-colors" style="transition-delay:160ms">
              <img alt="Gallery 3" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 cursor-pointer" src="img/gcp/gallery/3.JPG" />
            </div>
            <div class="aspect-square overflow-hidden rounded-2xl sm:rounded-3xl reveal shadow-md group border border-secondary/5 hover:border-secondary/20 transition-colors" style="transition-delay:240ms">
              <img alt="Gallery 4" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 cursor-pointer" src="img/gcp/gallery/2.JPG" />
            </div>
          </div>
        </div>
      </section>

      <!-- ===== RSVP ===== -->
      <section class="py-20 sm:py-28 bg-[#0A0A0A]" id="rsvp">
        <div class="max-w-3xl mx-auto px-5 sm:px-8">
          
          <div id="rsvp-container" class="bg-[#141414] p-8 sm:p-12 md:p-16 rounded-3xl sm:rounded-[3rem] shadow-2xl reveal border border-secondary/20 relative overflow-hidden transition-all duration-500">
            
            <!-- FORM COMPONENT -->
            <div id="rsvp-form-container" class="<?= $hasRsvp ? 'hidden' : '' ?>">
              <div class="text-center mb-10">
                <span class="text-secondary text-xs font-bold tracking-[0.2em] uppercase mb-3 block">RSVP Form</span>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-white">Confirm Attendance</h2>
                <p class="text-gray-400 mt-3">Please confirm your attendance by filling in the details below.</p>
              </div>
              <form class="space-y-5" id="rsvp-form">
                <!-- Keep code in hidden field if student -->
                <input type="hidden" name="code" id="student-code" value="<?= htmlspecialchars($code) ?>" />
                
                <div class="grid sm:grid-cols-2 gap-5">
                  <div>
                    <label class="block font-bold text-white text-sm mb-2 px-1">Full Name</label>
                    <input type="text" name="name" id="form-name" placeholder="Enter your full name" required 
                      <?= $isStudent ? 'readonly' : '' ?>
                      value="<?= htmlspecialchars($guestName) ?>"
                      class="form-input w-full bg-[#0C0C0C] border border-secondary/20 rounded-2xl px-4 py-3.5 text-white text-sm transition-all focus:border-secondary <?= $isStudent ? 'opacity-60 cursor-not-allowed bg-black/40' : '' ?>" />
                  </div>
                  <div>
                    <label class="block font-bold text-white text-sm mb-2 px-1">Class / Affiliation</label>
                    <?php if ($isStudent): ?>
                        <input type="text" name="classroom" value="<?= htmlspecialchars($classroom) ?>" readonly
                          class="form-input w-full bg-[#0C0C0C] border border-secondary/20 rounded-2xl px-4 py-3.5 text-white text-sm transition-all opacity-60 cursor-not-allowed bg-black/40" />
                    <?php else: ?>
                        <select name="classroom" class="form-input w-full bg-[#0C0C0C] border border-secondary/20 rounded-2xl px-4 py-3.5 text-white text-sm transition-all focus:border-secondary appearance-none">
                          <option value="Tamu Undangan">Tamu Undangan</option>
                          <option value="Orang Tua / Wali">Orang Tua / Wali</option>
                          <option value="XII AKT">XII AKT</option>
                          <option value="XII HOS 1">XII HOS 1</option>
                          <option value="XII HOS 2">XII HOS 2</option>
                          <option value="XII HOS 3">XII HOS 3</option>
                          <option value="XII DKV 1">XII DKV 1</option>
                          <option value="XII DKV 2">XII DKV 2</option>
                          <option value="XII PPLG 1">XII PPLG 1</option>
                          <option value="XII PPLG 2">XII PPLG 2</option>
                        </select>
                    <?php endif; ?>
                  </div>
                  <div>
                    <label class="block font-bold text-white text-sm mb-2 px-1">WhatsApp Number</label>
                    <input type="tel" name="whatsapp" value="<?= htmlspecialchars($whatsapp ?? '') ?>" placeholder="+62 8xx xxxx xxxx" required
                      class="form-input w-full bg-[#0C0C0C] border border-secondary/20 rounded-2xl px-4 py-3.5 text-white text-sm transition-all focus:border-secondary" />
                  </div>
                  <div>
                    <label class="block font-bold text-white text-sm mb-2 px-1">Attendance Status</label>
                    <select name="rsvp_status" id="form-rsvp-status" class="form-input w-full bg-[#0C0C0C] border border-secondary/20 rounded-2xl px-4 py-3.5 text-white text-sm transition-all focus:border-secondary appearance-none">
                      <option value="Attending" <?= $rsvpStatus === 'Attending' ? 'selected' : '' ?>>Will Attend</option>
                      <option value="Absent" <?= $rsvpStatus === 'Absent' ? 'selected' : '' ?>>Unable to Attend</option>
                    </select>
                  </div>
                </div>
                <div>
                  <label class="block font-bold text-white text-sm mb-2 px-1">Pilihan Pendamping (Companion)</label>
                  <select name="companion_type" id="form-companion-type" class="form-input w-full bg-[#0C0C0C] border border-secondary/20 rounded-2xl px-4 py-3.5 text-white text-sm transition-all focus:border-secondary appearance-none">
                    <option value="none" <?= $companionType === 'none' ? 'selected' : '' ?>>Datang Sendiri (Tanpa Pendamping)</option>
                    <option value="parents" <?= $companionType === 'parents' ? 'selected' : '' ?>>Orang Tua / Wali (Father / Mother)</option>
                    <option value="sibling" <?= $companionType === 'sibling' ? 'selected' : '' ?>>Saudara / Kerabat (Sibling / Relative)</option>
                  </select>
                </div>
                <div class="pt-3">
                  <button type="submit" class="w-full bg-secondary text-primary py-4 rounded-2xl font-bold text-xs tracking-widest uppercase hover:bg-secondary/90 hover:scale-[1.01] transition-all shadow-[0_0_20px_rgba(212,175,55,0.15)]">
                    SUBMIT CONFIRMATION
                  </button>
                </div>
              </form>
            </div>

            <!-- E-TICKET COMPONENT -->
            <div id="ticket-container" class="<?= !$hasRsvp || $rsvpStatus === 'Absent' ? 'hidden' : '' ?> flex flex-col items-center">
              <div class="text-center mb-6">
                <span class="text-secondary text-xs font-bold tracking-[0.2em] uppercase mb-2 block">E-TICKET ENTRY</span>
                <h3 class="font-display text-2xl font-bold text-white">RSVP BERHASIL DIKONFIRMASI</h3>
                <p class="text-gray-400 text-xs mt-1">Tunjukkan E-Ticket ini ke penerima tamu pada hari H acara.</p>
              </div>
              
              <!-- E-Ticket physical card design -->
              <div id="ticket-card" class="relative w-full max-w-sm bg-gradient-to-b from-[#1c1c1e] to-[#0c0c0e] border border-secondary/30 rounded-3xl overflow-hidden shadow-2xl p-6 flex flex-col items-center">
                <!-- Circular Ticket side cutouts -->
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-4 h-8 bg-[#141414] rounded-r-full border-r border-t border-b border-secondary/20 -ml-0.5"></div>
                <div class="absolute right-0 top-1/2 -translate-y-1/2 w-4 h-8 bg-[#141414] rounded-l-full border-l border-t border-b border-secondary/20 -mr-0.5"></div>
                
                <!-- Ticket Header -->
                <div class="flex items-center gap-2 mb-4">
                  <img src="img/metschoo/Metschoo.png" alt="Logo" class="w-8 h-8 object-contain" />
                  <span class="font-display text-white text-base font-bold tracking-wide">GCP Award 2026</span>
                </div>
                
                <div class="w-full border-b border-dashed border-secondary/25 my-2"></div>
                
                <!-- Ticket Details -->
                <div class="w-full py-4 text-center">
                  <p class="text-gray-500 text-[9px] uppercase tracking-widest mb-1">Nama Siswa / Tamu</p>
                  <h4 class="text-secondary font-display font-bold text-lg uppercase tracking-wide px-2 break-words" id="ticket-name"><?= htmlspecialchars($guestName) ?></h4>
                  
                  <div class="grid grid-cols-2 gap-4 mt-4 text-left px-2">
                    <div>
                      <p class="text-gray-500 text-[9px] uppercase tracking-wider">Kelas / Afiliasi</p>
                      <p class="text-white font-bold text-xs" id="ticket-class"><?= htmlspecialchars($isStudent ? $classroom : 'Tamu Undangan') ?></p>
                    </div>
                    <div>
                      <p class="text-gray-500 text-[9px] uppercase tracking-wider">Pendamping</p>
                      <p class="text-white font-bold text-xs" id="ticket-companion">
                        <?= $companionType === 'parents' ? 'Orang Tua / Wali' : ($companionType === 'sibling' ? 'Saudara / Kerabat' : 'Tanpa Pendamping') ?>
                      </p>
                    </div>
                    <div class="col-span-2">
                      <p class="text-gray-500 text-[9px] uppercase tracking-wider">Waktu & Tempat</p>
                      <p class="text-white text-xs font-semibold">Jumat, 19 Juni 2026 @ 13:00 WIB<br>Auditorium SMK Metland</p>
                    </div>
                  </div>
                </div>
                
                <div class="w-full border-b border-dashed border-secondary/25 my-2"></div>
                
                <!-- QR Code Wrapper -->
                <div class="py-4 flex flex-col items-center">
                  <div id="qrcode-container" class="bg-white p-3 rounded-2xl shadow-lg w-fit"></div>
                  <p class="text-secondary text-xs font-bold tracking-[0.2em] mt-3 uppercase" id="ticket-code-display"><?= htmlspecialchars($code) ?></p>
                </div>
              </div>
              
              <!-- Ticket Buttons -->
              <div class="flex gap-4 mt-6 w-full justify-center">
                <button id="btn-edit-rsvp" class="bg-white/5 border border-white/10 hover:bg-white/10 text-white font-semibold text-xs tracking-widest uppercase px-5 py-3.5 rounded-xl transition-all">
                  Ubah RSVP
                </button>
                <button id="btn-download-ticket" class="bg-secondary text-primary font-bold text-xs tracking-widest uppercase px-5 py-3.5 rounded-xl hover:scale-105 active:scale-95 transition-all flex items-center gap-1 shadow-lg">
                  <span class="material-symbols-outlined text-base">download</span> Unduh Tiket
                </button>
              </div>
            </div>

            <!-- ABSENT CONFIRMATION COMPONENT -->
            <div id="absent-container" class="<?= !$hasRsvp || $rsvpStatus === 'Attending' ? 'hidden' : '' ?> text-center flex flex-col items-center py-6">
              <span class="material-symbols-outlined text-secondary text-6xl mb-4">info</span>
              <h3 class="font-display text-2xl font-bold text-white mb-2">Terima Kasih Konfirmasinya</h3>
              <p class="text-gray-400 text-sm max-w-md mb-6">Anda telah mengonfirmasi bahwa Anda berhalangan hadir. Jika rencana Anda berubah, Anda dapat memperbarui RSVP Anda.</p>
              <button id="btn-edit-rsvp-absent" class="bg-secondary text-primary font-bold text-xs tracking-widest uppercase px-6 py-3 rounded-xl hover:scale-105 transition-transform shadow-lg">
                Ubah RSVP Kehadiran
              </button>
            </div>

          </div>
        </div>
      </section>

      <!-- ===== FOOTER ===== -->
      <footer class="bg-black text-white/50 py-16 px-5 sm:px-8 border-t border-secondary/10">
        <div class="max-w-4xl mx-auto flex flex-col items-center gap-6">
          <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-6 py-3">
            <img src="img/metschoo/Metschoo.png" alt="Metland School" class="w-16 h-16 object-contain" />
            <img src="img/metschoo/always-inspiring.png" alt="Always Inspiring" class="w-16 h-16 object-contain bg-white/90 p-1 rounded-lg" />
            <img src="img/metschoo/gcp.png" alt="GCP" class="w-16 h-16 object-contain" />
          </div>
          <div class="w-full max-w-xs h-px bg-secondary/15"></div>
          <p class="text-[10px] text-center tracking-widest uppercase text-gray-500">© 2026 SMK Pariwisata Metland School. All Rights Reserved.</p>
        </div>
      </footer>
    </main>

    <!-- Success Modal -->
    <div class="fixed inset-0 bg-black/90 z-[200] hidden items-center justify-center p-5 backdrop-blur-md" id="success-modal">
      <div class="bg-[#141414] border border-secondary/30 w-full max-w-sm p-10 rounded-3xl text-center shadow-2xl">
        <span class="material-symbols-outlined text-secondary text-6xl mb-4" style="font-variation-settings:'FILL' 1">check_circle</span>
        <h3 class="font-display font-bold text-2xl text-white mb-3">Thank You!</h3>
        <p class="text-gray-300 text-sm mb-6 leading-relaxed">Your confirmation has been received successfully.</p>
        <button onclick="document.getElementById('success-modal').classList.add('hidden');document.getElementById('success-modal').classList.remove('flex')"
          class="w-full bg-secondary text-primary py-4 rounded-2xl font-bold text-xs tracking-widest uppercase hover:bg-secondary/90 transition-all shadow-lg">
          DONE
        </button>
      </div>
    </div>

    <script>
      let studentCode = "<?= htmlspecialchars($code) ?>";
      let isStudent = <?= $isStudent ? 'true' : 'false' ?>;

      // Cover overlay opening triggers
      window.addEventListener("load", () => {
        setTimeout(() => {
          const ls = document.getElementById("loading-screen");
          if (ls) {
            ls.style.opacity = "0";
            setTimeout(() => ls.classList.add("hidden"), 1000);
          }
        }, 800);
      });

      const btnOpen = document.getElementById("btn-open-invitation");
      const coverOverlay = document.getElementById("cover-overlay");
      const bgMusic = document.getElementById("bg-music");

      btnOpen.addEventListener("click", () => {
        if (bgMusic) {
          bgMusic.play().then(() => {
            document.getElementById("music-toggle").querySelector("span").innerText = "volume_up";
          }).catch(err => {
            console.log("Autoplay blocked:", err);
          });
        }
        coverOverlay.style.transform = "translateY(-100%)";
        coverOverlay.style.transition = "transform 1s cubic-bezier(0.77, 0, 0.175, 1)";
        document.body.classList.remove("overflow-hidden");
        
        setTimeout(() => {
          coverOverlay.classList.add("hidden");
        }, 1000);
      });

      // Mobile Menu functions
      const hamburger = document.getElementById("hamburger");
      const mobileMenu = document.getElementById("mobile-menu");
      let menuOpen = false;
      function closeMobileMenu() { mobileMenu.classList.remove("open"); menuOpen = false; }
      hamburger.addEventListener("click", () => { menuOpen = !menuOpen; mobileMenu.classList.toggle("open", menuOpen); });

      window.addEventListener("scroll", () => {
        const winScroll = document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        document.getElementById("progress-bar").style.width = (winScroll / height * 100) + "%";
        document.getElementById("main-nav").classList.toggle("scrolled", winScroll > 60);
      });

      // Music toggle
      document.getElementById("music-toggle").addEventListener("click", function() {
        const icon = this.querySelector("span");
        if (bgMusic.paused) {
          bgMusic.play();
          icon.innerText = "volume_up";
        } else {
          bgMusic.pause();
          icon.innerText = "volume_off";
        }
      });

      // Countdown Date
      const countdownDate = new Date("June 19, 2026 13:00:00").getTime();
      const secEl = document.getElementById("seconds");
      const countInterval = setInterval(() => {
        const dist = countdownDate - Date.now();
        if (dist < 0) {
          clearInterval(countInterval);
          document.getElementById("countdown").innerHTML = '<div class="text-secondary font-bold text-xl tracking-widest glass-card-gold px-8 py-4 rounded-2xl">🎉 EVENT IS LIVE</div>';
          return;
        }
        const pad = n => String(n).padStart(2, "0");
        document.getElementById("days").innerText    = pad(Math.floor(dist / 86400000));
        document.getElementById("hours").innerText   = pad(Math.floor((dist % 86400000) / 3600000));
        document.getElementById("minutes").innerText = pad(Math.floor((dist % 3600000) / 60000));
        if (secEl) secEl.innerText = pad(Math.floor((dist % 60000) / 1000));
      }, 1000);

      // Intersection Observers for reveal animations
      const revealObs = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add("active"); revealObs.unobserve(e.target); } });
      }, { threshold: 0.08 });
      document.querySelectorAll(".reveal").forEach(el => revealObs.observe(el));

      // Stats counters animation
      const counterObs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
          if (!e.isIntersecting) return;
          e.target.querySelectorAll(".counter").forEach(el => {
            const target = +el.dataset.target;
            let count = 0;
            const inc = target / 60;
            const tick = () => { count = Math.min(count + inc, target); el.innerText = Math.ceil(count); if (count < target) setTimeout(tick, 25); };
            tick();
          });
          counterObs.unobserve(e.target);
        });
      }, { threshold: 0.15 });
      const statsSection = document.querySelector(".counter")?.closest("section");
      if (statsSection) counterObs.observe(statsSection);

      // Generate QR Code Client-side helper
      let qrcodeObj = null;
      function generateQRCode(code) {
        const qrContainer = document.getElementById("qrcode-container");
        qrContainer.innerHTML = ""; // Clear
        
        // Resolve dynamic URL for checkin scanner
        const checkinUrl = window.location.origin + window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')) + '/checkin.php?code=' + code;
        
        qrcodeObj = new QRCode(qrContainer, {
          text: checkinUrl,
          width: 160,
          height: 160,
          colorDark : "#000000",
          colorLight : "#ffffff",
          correctLevel : QRCode.CorrectLevel.H
        });
      }

      // Initialize QR if already attending on load
      if (studentCode && "<?= $rsvpStatus ?>" === "Attending") {
        generateQRCode(studentCode);
      }

      // Toggle RSVP form and E-Ticket views
      const rsvpFormContainer = document.getElementById("rsvp-form-container");
      const ticketContainer = document.getElementById("ticket-container");
      const absentContainer = document.getElementById("absent-container");

      function showForm() {
        ticketContainer.classList.add("hidden");
        absentContainer.classList.add("hidden");
        rsvpFormContainer.classList.remove("hidden");
      }

      document.getElementById("btn-edit-rsvp")?.addEventListener("click", showForm);
      document.getElementById("btn-edit-rsvp-absent")?.addEventListener("click", showForm);

      // Handle RSVP Form Submission via AJAX
      document.getElementById("rsvp-form").addEventListener("submit", function(e) {
        e.preventDefault();
        
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerText = "SUBMITTING...";

        const formData = new FormData(this);
        
        fetch('api.php?action=submit_rsvp', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          submitButton.disabled = false;
          submitButton.innerText = "SUBMIT CONFIRMATION";

          if (data.success) {
            // Update client-side variables
            studentCode = data.student.code;
            document.getElementById("student-code").value = studentCode;

            // Pre-fill E-ticket fields
            document.getElementById("ticket-name").innerText = data.student.name;
            document.getElementById("ticket-class").innerText = data.student.classroom;
            
            let companionName = "Tanpa Pendamping";
            if (data.student.companion_type === 'parents') companionName = "Orang Tua / Wali";
            else if (data.student.companion_type === 'sibling') companionName = "Saudara / Kerabat";
            document.getElementById("ticket-companion").innerText = companionName;
            document.getElementById("ticket-code-display").innerText = studentCode;

            // Handle display logic based on selection
            rsvpFormContainer.classList.add("hidden");
            if (data.student.rsvp_status === 'Attending') {
              generateQRCode(studentCode);
              ticketContainer.classList.remove("hidden");
            } else {
              absentContainer.classList.remove("hidden");
            }

            // Show success popup
            const modal = document.getElementById("success-modal");
            modal.classList.remove("hidden");
            modal.classList.add("flex");
          } else {
            alert(data.message || "An error occurred. Please try again.");
          }
        })
        .catch(err => {
          submitButton.disabled = false;
          submitButton.innerText = "SUBMIT CONFIRMATION";
          console.error(err);
          alert("Network error. Please check your connection.");
        });
      });

      // HTML2Canvas ticket download trigger
      document.getElementById("btn-download-ticket").addEventListener("click", function() {
        const ticketCard = document.getElementById("ticket-card");
        const downloadButton = this;
        downloadButton.disabled = true;
        downloadButton.innerText = "Generating...";

        html2canvas(ticketCard, {
          backgroundColor: "#0c0c0e",
          scale: 3, // Premium HD quality
          useCORS: true
        }).then(canvas => {
          downloadButton.disabled = false;
          downloadButton.innerHTML = '<span class="material-symbols-outlined text-base">download</span> Unduh Tiket';
          
          const link = document.createElement("a");
          link.download = `GCP_Award_2026_Ticket_${studentCode || 'guest'}.png`;
          link.href = canvas.toDataURL("image/png");
          link.click();
        }).catch(err => {
          downloadButton.disabled = false;
          downloadButton.innerHTML = '<span class="material-symbols-outlined text-base">download</span> Unduh Tiket';
          console.error(err);
          alert("Gagal mengunduh tiket. Silakan screenshot layar Anda.");
        });
      });
    </script>
  </body>
</html>
