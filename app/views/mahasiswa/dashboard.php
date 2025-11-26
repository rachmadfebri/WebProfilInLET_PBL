<?php
// 1. Pastikan Session Dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Ambil Data Pengguna dari Session
// Fallback nama jika session belum diset
$nama_pengguna = $_SESSION['full_name'] ?? 'Mahasiswa';
$user_id = $_SESSION['user_id'] ?? null; // Digunakan jika perlu untuk action

// 3. INISIALISASI VARIABEL PENTING DARI CONTROLLER

// Status Absensi: Default ke 'belum_absen'. 
// Nilai ini HARUS ditimpa oleh Controller yang memuat view ini.
if (!isset($status_absen_hari_ini)) {
    // Opsi: 'belum_absen', 'sudah_datang', 'sudah_lengkap'
    $status_absen_hari_ini = 'belum_absen'; 
}

// Flash Message Handling
$session_message = '';
$message_type = 'info'; // Default type

// Prioritaskan pesan dari variabel $flash_message (dari Controller)
if (isset($flash_message)) {
    if (is_array($flash_message)) {
        $session_message = $flash_message['text'] ?? '';
        $message_type = $flash_message['type'] ?? 'info';
    } elseif (is_string($flash_message)) {
        $session_message = $flash_message;
    }
} 
// Jika tidak ada dari Controller, cek SESSION 'flash_message' sebagai fallback (jika redirect dilakukan)
elseif (isset($_SESSION['flash_message'])) {
    if (is_array($_SESSION['flash_message'])) {
        $session_message = $_SESSION['flash_message']['text'] ?? '';
        $message_type = $_SESSION['flash_message']['type'] ?? 'info';
    } elseif (is_string($_SESSION['flash_message'])) {
        $session_message = $_SESSION['flash_message'];
    }
    
    // Hapus flash message dari session setelah diambil
    unset($_SESSION['flash_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    
    <title>Dashboard Mahasiswa - Absensi Lab InLET</title>
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Pastikan path ini benar untuk Soft UI Dashboard -->
    <link href="assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5" rel="stylesheet" />
    
    <style>
        /* Sedikit style tambahan untuk jam digital agar terlihat menarik */
        #clock {
            font-family: 'Courier New', Courier, monospace; /* Font ala digital */
            letter-spacing: 2px;
        }
    </style>
  </head>

  <body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">
    
    <!-- Sidebar -->
    <aside class="max-w-62.5 ease-nav-brand z-990 fixed inset-y-0 my-4 ml-4 block w-full -translate-x-full flex-wrap items-center justify-between overflow-y-auto rounded-2xl border-0 bg-white p-0 antialiased shadow-none transition-transform duration-200 xl:left-0 xl:translate-x-0 xl:bg-transparent">
      
      <div class="h-19.5">
        <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden" sidenav-close></i>
        
        <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="javascript:void(0);">
          <div class="flex flex-col justify-center">
              <h6 class="font-bold text-lg mb-0 text-blue-600 tracking-tight">MAHASISWA</h6>
              <p class="text-xs font-semibold text-slate-500 mt-1 uppercase">
                  Hello, <?= htmlspecialchars($nama_pengguna) ?>
              </p>
          </div>
        </a>
      </div>

      <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />

     <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
        <ul class="flex flex-col pl-0 mb-0">
          <li class="mt-0.5 w-full">
            <a
              class="py-2.7 shadow-soft-xl text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg bg-white px-4 font-semibold text-slate-700 transition-colors"
              href="?page=mahasiswa-dashboard"
            >
              <div
                class="bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5"
              >
                <svg
                  width="12px"
                  height="12px"
                  viewBox="0 0 45 40"
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                  <title>shop</title>
                  <g
                    stroke="none"
                    stroke-width="1"
                    fill="none"
                    fill-rule="evenodd"
                  >
                    <g
                      transform="translate(-1716.000000, -439.000000)"
                      fill="#FFFFFF"
                      fill-rule="nonzero"
                    >
                      <g transform="translate(1716.000000, 291.000000)">
                        <g transform="translate(0.000000, 148.000000)">
                          <path
                            class="opacity-60"
                            d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"
                          ></path>
                          <path
                            class=""
                            d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"
                          ></path>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Absensi Harian</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="mx-4 my-4">
        <a href="?action=logout" class="inline-block w-full px-8 py-2 mb-4 font-bold text-center text-white uppercase transition-all ease-in border-0 border-white rounded-lg shadow-soft-md bg-150 leading-pro text-xs bg-gradient-to-tl from-slate-600 to-slate-300 hover:shadow-soft-2xl hover:scale-102">
          Logout
        </a>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="ease-soft-in-out xl:ml-68 relative h-full max-h-screen rounded-xl transition-all duration-200">
      
      <!-- Navbar (Header) -->
      <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="true">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
          <nav>
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
              <li class="text-sm leading-normal">
                <a class="opacity-50 text-slate-700" href="javascript:;">Pages</a>
              </li>
              <li class="text-sm leading-normal text-slate-700 pl-2 before:float-left before:pr-2 before:text-gray-600 before:content-['/']" aria-current="page">Absensi</li>
            </ol>
            <h6 class="mb-0 font-bold capitalize">Panel Absensi</h6>
          </nav>

          <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto justify-end">
              <!-- Ganti logo.jpg dengan logo yang sesuai, tambahkan fallback jika gambar tidak ditemukan -->
              <img src="assets/img/logo.jpg" alt="Logo Lab InLET" class="h-12 w-auto object-contain" onerror="this.style.display='none';">
              
              <ul class="flex flex-col pl-0 mb-0 list-none md-max:w-full ml-4 lg:hidden">
                <li class="flex items-center">
                  <a href="javascript:;" class="block p-0 text-sm transition-all ease-nav-brand text-slate-500" sidenav-trigger>
                    <div class="w-4.5 overflow-hidden">
                      <i class="ease-soft mb-0.75 relative block h-0.5 rounded-sm bg-slate-500 transition-all"></i>
                      <i class="ease-soft mb-0.75 relative block h-0.5 rounded-sm bg-slate-500 transition-all"></i>
                      <i class="ease-soft relative block h-0.5 rounded-sm bg-slate-500 transition-all"></i>
                    </div>
                  </a>
                </li>
              </ul>
          </div>
        </div>
      </nav>
      
      <!-- Content Body -->
      <div class="w-full px-6 py-6 mx-auto">
        
        <!-- Flash Message Area -->
        <?php if ($session_message): 
            $base_class = "p-4 mb-4 text-sm rounded-lg shadow-soft-md";
            $icon = 'fas fa-info-circle';
            $bg_color = 'bg-gray-500';

            if ($message_type == 'success') {
                $icon = 'fas fa-check-circle';
                $bg_color = 'bg-green-500';
            } elseif ($message_type == 'warning') {
                $icon = 'fas fa-exclamation-triangle';
                $bg_color = 'bg-yellow-500';
            } elseif ($message_type == 'danger') {
                $icon = 'fas fa-times-circle';
                $bg_color = 'bg-red-500';
            }
        ?>
            <div class="<?= $base_class ?> <?= $bg_color ?>" role="alert">
                <i class="<?= $icon ?> mr-2"></i> <span class="font-bold">Info!</span> <?= htmlspecialchars($session_message) ?>
            </div>
        <?php endif; ?>

        <!-- Attendance Card -->
        <div class="flex flex-wrap -mx-3">
          <div class="w-full max-w-full px-3 mx-auto mt-0 lg:w-8/12"> <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-padding">
              
              <div class="p-6 pb-0 mb-0 text-center bg-white border-b-0 rounded-t-2xl">
                <h5 class="mb-2 text-2xl font-bold text-slate-700">
                    <i class="fas fa-clipboard-list mr-2 text-purple-500"></i> Absensi Kehadiran
                </h5>
                <p class="mb-4 text-sm font-semibold text-slate-500">
                    <i class="far fa-calendar-alt mr-1"></i> <?= date('l, d F Y') ?>
                </p>

                    <div class="my-6">
                        <div class="inline-block px-6 py-3 bg-gray-100 rounded-xl shadow-inner-soft">
                            <h3 id="clock" class="text-4xl font-bold text-slate-700 mb-0">Loading...</h3>
                            <p class="text-xs text-slate-400 mt-1">Waktu Server Terkini</p>
                        </div>
                    </div>
              </div>
              
              <div class="flex-auto p-6 pt-0 text-center">
                
                <!-- Status Display -->
                <div class="mb-6 p-3 bg-blue-50 rounded-lg border border-blue-100 inline-block shadow-sm">
                    <p class="text-sm text-blue-800 mb-0 font-semibold">
                        Status Hari Ini: 
                        <?php if($status_absen_hari_ini == 'belum_absen'): ?>
                            <span class="text-slate-500"><i class="fas fa-clock mr-1"></i> Menunggu Absen Datang</span>
                        <?php elseif($status_absen_hari_ini == 'sudah_datang'): ?>
                            <span class="text-green-600"><i class="fas fa-check mr-1"></i> Sudah Datang (Menunggu Pulang)</span>
                        <?php else: /* sudah_lengkap */ ?>
                            <span class="text-blue-600"><i class="fas fa-check-double mr-1"></i> Kehadiran Lengkap</span>
                        <?php endif; ?>
                    </p>
                </div>

                <p class="leading-normal text-base mb-8 text-slate-600">
                    Silakan klik tombol di bawah ini sesuai dengan aktivitas kehadiran Anda di Laboratorium.
                </p>

                <!-- Attendance Form -->
                <!-- Action form mengarah ke index.php, Controller akan menentukan aksi berdasarkan 'action' value -->
                <form method="POST" action="index.php"> 
                    <div class="flex flex-wrap justify-center gap-6 mt-8">
                        
                        <!-- Tombol Absen Datang -->
                        <?php 
                        $is_datang_disabled = ($status_absen_hari_ini != 'belum_absen');
                        $datang_class = $is_datang_disabled 
                            ? 'bg-gray-400 cursor-not-allowed opacity-60' 
                            : 'bg-gradient-to-tl from-green-600 to-lime-400 cursor-pointer hover:scale-105 hover:shadow-soft-xs active:opacity-85';
                        $datang_text = $is_datang_disabled ? 'Sudah Absen Datang' : 'Absen Datang';
                        ?>
                        <button
                            type="submit"
                            name="action"
                            value="absen_datang" 
                            <?= $is_datang_disabled ? 'disabled' : '' ?>
                            class="inline-block px-8 py-4 font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg shadow-soft-md bg-150 bg-x-25 leading-pro text-sm <?= $datang_class ?>"
                        >
                            <i class="fas fa-sign-in-alt mr-2 text-lg"></i> 
                            <?= $datang_text ?>
                        </button>

                        <!-- Tombol Absen Pulang -->
                        <?php 
                        $is_pulang_disabled = ($status_absen_hari_ini == 'belum_absen' || $status_absen_hari_ini == 'sudah_lengkap');
                        $pulang_class = $is_pulang_disabled 
                            ? 'opacity-50 cursor-not-allowed' /* Disabled */
                            : 'cursor-pointer hover:scale-105 hover:shadow-soft-xs active:opacity-85'; /* Bisa Diklik */
                        ?>
                        <button
                            type="submit"
                            name="action"
                            value="absen_pulang" 
                            <?= $is_pulang_disabled ? 'disabled' : '' ?>
                            class="inline-block px-8 py-4 font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg shadow-soft-md bg-150 bg-x-25 leading-pro text-sm bg-gradient-to-tl from-red-600 to-rose-400 <?= $pulang_class ?>"
                        >
                            <i class="fas fa-sign-out-alt mr-2 text-lg"></i> Absen Pulang
                        </button>

                    </div>
                </form>
                <p class="text-xs text-slate-400 mt-6 mb-0">Pastikan Anda berada di area Lab saat melakukan absensi.</p>

              </div>
            </div>

          </div>
        </div>

        <!-- Footer -->
        <footer class="pt-4">
          <div class="w-full px-6 mx-auto">
            <div class="flex flex-wrap items-center -mx-3 lg:justify-between">
              <div class="w-full max-w-full px-3 mt-0 mb-6 shrink-0 lg:mb-0 lg:w-1/2 lg:flex-none">
                <div class="text-sm leading-normal text-center text-slate-500 lg:text-left">
                  © <script>document.write(new Date().getFullYear() + ",");</script>
                  Soft by Team Inlet.
                </div>
              </div>
            </div>
          </div>
        </footer>

      </div>
    </main>
    </body>
  
  <script src="assets/js/plugins/perfect-scrollbar.min.js" async></script>
  <script src="assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5" async></script>

  <script>
    // Fungsi untuk memperbarui jam digital setiap detik
    function updateClock() {
        const now = new Date();
        let hours = now.getHours();
        let minutes = now.getMinutes();
        let seconds = now.getSeconds();

        // Tambahkan angka 0 di depan jika kurang dari 10 (misal: 09:05:02)
        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        const timeString = hours + ':' + minutes + ':' + seconds + ' WIB'; 
        document.getElementById('clock').innerText = timeString;
    }

    // Update jam setiap 1 detik (1000ms)
    setInterval(updateClock, 1000);
    
    // Jalankan fungsi sekali saat halaman pertama kali dimuat
    updateClock();
  </script>
</html>