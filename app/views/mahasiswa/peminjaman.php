<?php
// 1. Pastikan Session Dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Ambil Data Pengguna dari Session
$nama_pengguna = $_SESSION['full_name'] ?? 'Mahasiswa';
$user_id = $_SESSION['user_id'] ?? null;

// Flash Message Handling
$session_message = '';
$message_type = 'info';

if (isset($flash_message)) {
    if (is_array($flash_message)) {
        $session_message = $flash_message['text'] ?? '';
        $message_type = $flash_message['type'] ?? 'info';
    } elseif (is_string($flash_message)) {
        $session_message = $flash_message;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets/img/logo.jpg" />
    
    <title>Peminjaman Barang/Ruang - Lab InLET</title>
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    
    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
        crossorigin="anonymous" 
        referrerpolicy="no-referrer" 
    />
    
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <link href="assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5" rel="stylesheet" />
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
          <!-- Menu Utama Section -->
          <li class="mt-4 w-full px-4">
            <h6 class="pl-2 ml-2 text-xs font-bold uppercase leading-tight opacity-60">Menu Utama</h6>
          </li>

          <li class="mt-0.5 w-full">
            <a
              class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
              href="?page=mahasiswa-dashboard"
            >
              <div
                class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5"
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
                            class="fill-slate-800 opacity-60"
                            d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"
                          ></path>
                          <path
                            class="fill-slate-800"
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

          <!-- Menu Peminjaman (Active) -->
          <li class="mt-0.5 w-full">
            <a
              class="py-2.7 shadow-soft-xl text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg bg-white px-4 font-semibold text-slate-700 transition-colors"
              href="?page=peminjaman"
            >
              <div
                class="bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5"
              >
                <i class="fas fa-box text-white"></i>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Peminjaman</span>
            </a>
          </li>

          <!-- Pengaturan Section -->
          <li class="mt-4 w-full px-4">
            <h6 class="pl-2 ml-2 text-xs font-bold uppercase leading-tight opacity-60">Pengaturan</h6>
          </li>

          <!-- Profil Menu -->
          <li class="mt-0.5 w-full">
            <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors" href="?page=profil">
                <div class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 text-slate-700">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2" fill="none"/>
                        <path stroke="currentColor" stroke-width="2" d="M4 20c0-3.333 3.333-6 8-6s8 2.667 8 6" fill="none"/>
                    </svg>
                </div>
                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Profil</span>
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
      
      <!-- Navbar -->
      <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="true">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
          <nav>
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
              <li class="text-sm leading-normal">
                <a class="opacity-50 text-slate-700" href="javascript:;">Pages</a>
              </li>
              <li class="text-sm leading-normal text-slate-700 pl-2 before:float-left before:pr-2 before:text-gray-600 before:content-['/']" aria-current="page">Peminjaman</li>
            </ol>
            <h6 class="mb-0 font-bold capitalize">Peminjaman Barang/Ruang</h6>
          </nav>

          <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto justify-end">
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
        
        <!-- Flash Message -->
        <?php if ($session_message): 
            $base_class = "p-4 mb-4 text-sm rounded-lg shadow-soft-md";
            $icon = 'fas fa-info-circle';
            $bg_color = 'bg-gray-100 text-gray-800';

            if ($message_type == 'success') {
                $icon = 'fas fa-check-circle';
                $bg_color = 'bg-green-100 text-green-800';
            } elseif ($message_type == 'warning') {
                $icon = 'fas fa-exclamation-triangle';
                $bg_color = 'bg-yellow-100 text-yellow-800';
            } elseif ($message_type == 'error') {
                $icon = 'fas fa-times-circle';
                $bg_color = 'bg-red-100 text-red-800';
            }
        ?>
            <div class="<?= $base_class ?> <?= $bg_color ?>" role="alert">
                <i class="<?= $icon ?> mr-2"></i> <?= htmlspecialchars($session_message) ?>
            </div>
        <?php endif; ?>

        <div class="flex flex-wrap -mx-3">
          
          <!-- Form Pengajuan Peminjaman -->
          <div class="w-full max-w-full px-3 mb-6 lg:w-5/12">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
              <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                <h6 class="mb-0 font-bold text-slate-700">
                  <i class="fas fa-plus-circle mr-2 text-green-500"></i> Form Pengajuan Peminjaman
                </h6>
              </div>
              
              <div class="flex-auto p-6">
                <form method="POST" action="index.php?page=peminjaman&action=create_loan">
                  
                  <!-- Pilih Barang/Ruang -->
                  <div class="mb-4">
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                      <i class="fas fa-box mr-1"></i> Barang/Ruang <span class="text-red-500">*</span>
                    </label>
                    <select name="inventory_id" required class="block w-full px-3 py-2 text-sm text-slate-700 bg-white border border-gray-300 rounded-lg focus:border-purple-500 focus:ring-purple-500">
                      <option value="">-- Pilih Barang/Ruang --</option>
                      <?php if (!empty($availableInventory)): ?>
                        <?php foreach ($availableInventory as $item): ?>
                          <option value="<?= $item['id'] ?>">
                            <?= htmlspecialchars($item['name']) ?> (<?= ucfirst($item['type']) ?>)
                          </option>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <option value="" disabled>Tidak ada barang/ruang tersedia</option>
                      <?php endif; ?>
                    </select>
                  </div>

                  <!-- Tanggal Peminjaman -->
                  <div class="mb-4">
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                      <i class="fas fa-calendar-alt mr-1"></i> Tanggal Peminjaman <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="loan_date" required min="<?= date('Y-m-d') ?>" 
                           class="block w-full px-3 py-2 text-sm text-slate-700 bg-white border border-gray-300 rounded-lg focus:border-purple-500 focus:ring-purple-500">
                  </div>

                  <!-- Tanggal Pengembalian -->
                  <div class="mb-4">
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                      <i class="fas fa-calendar-check mr-1"></i> Tanggal Pengembalian <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="return_date" required min="<?= date('Y-m-d') ?>" 
                           class="block w-full px-3 py-2 text-sm text-slate-700 bg-white border border-gray-300 rounded-lg focus:border-purple-500 focus:ring-purple-500">
                  </div>

                  <!-- Alasan Peminjaman -->
                  <div class="mb-4">
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                      <i class="fas fa-comment-alt mr-1"></i> Alasan/Keperluan
                    </label>
                    <textarea name="reason" rows="3" placeholder="Tuliskan alasan peminjaman..."
                              class="block w-full px-3 py-2 text-sm text-slate-700 bg-white border border-gray-300 rounded-lg focus:border-purple-500 focus:ring-purple-500"></textarea>
                  </div>

                  <button type="submit" class="w-full px-4 py-3 font-bold text-white uppercase transition-all rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 hover:shadow-soft-2xl hover:scale-102">
                    <i class="fas fa-paper-plane mr-2"></i> Ajukan Peminjaman
                  </button>
                </form>
              </div>
            </div>
          </div>

          <!-- Daftar Peminjaman Aktif -->
          <div class="w-full max-w-full px-3 mb-6 lg:w-7/12">
            
            <!-- Peminjaman Aktif -->
            <?php if (!empty($activeLoans)): ?>
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border mb-6">
              <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                <h6 class="mb-0 font-bold text-slate-700">
                  <i class="fas fa-clock mr-2 text-orange-500"></i> Peminjaman Aktif
                </h6>
              </div>
              
              <div class="flex-auto p-4">
                <div class="space-y-4">
                  <?php foreach ($activeLoans as $loan): 
                    $isOverdue = strtotime($loan['return_date']) < strtotime(date('Y-m-d'));
                  ?>
                    <div class="p-4 <?= $isOverdue ? 'bg-red-50 border-red-300' : 'bg-orange-50 border-orange-200' ?> border rounded-lg">
                      <div class="flex justify-between items-start">
                        <div>
                          <h6 class="font-bold text-slate-700"><?= htmlspecialchars($loan['inventory_name']) ?></h6>
                          <p class="text-xs text-slate-500">
                            <i class="fas fa-calendar mr-1"></i>
                            <?= date('d M Y', strtotime($loan['loan_date'])) ?> - <?= date('d M Y', strtotime($loan['return_date'])) ?>
                          </p>
                          <?php if ($isOverdue): ?>
                            <p class="text-xs text-red-600 mt-1 font-semibold">
                              <i class="fas fa-exclamation-triangle mr-1"></i> Sudah melewati batas waktu pengembalian!
                            </p>
                          <?php endif; ?>
                        </div>
                        <?php if ($isOverdue): ?>
                          <span class="px-2 py-1 text-xs font-bold text-red-700 bg-red-200 rounded-full">
                            <i class="fas fa-exclamation-circle mr-1"></i> Terlambat
                          </span>
                        <?php else: ?>
                          <span class="px-2 py-1 text-xs font-bold text-orange-700 bg-orange-200 rounded-full">
                            Dipinjam
                          </span>
                        <?php endif; ?>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
            <?php endif; ?>

            <!-- Riwayat Peminjaman -->
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
              <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                <h6 class="mb-0 font-bold text-slate-700">
                  <i class="fas fa-history mr-2 text-blue-500"></i> Riwayat Peminjaman
                </h6>
              </div>
              
              <div class="flex-auto p-4">
                <?php if (!empty($myLoans)): ?>
                  <div class="overflow-x-auto">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                      <thead class="align-bottom">
                        <tr>
                          <th class="px-4 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 text-xxs text-slate-400">Barang/Ruang</th>
                          <th class="px-4 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 text-xxs text-slate-400">Periode</th>
                          <th class="px-4 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 text-xxs text-slate-400">Status</th>
                          <th class="px-4 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 text-xxs text-slate-400">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($myLoans as $loan): ?>
                          <tr>
                            <td class="p-4 align-middle bg-transparent border-b">
                              <div class="flex flex-col">
                                <h6 class="mb-0 text-sm font-semibold text-slate-700"><?= htmlspecialchars($loan['inventory_name']) ?></h6>
                                <p class="mb-0 text-xs text-slate-400"><?= ucfirst($loan['inventory_type']) ?></p>
                              </div>
                            </td>
                            <td class="p-4 text-center align-middle bg-transparent border-b">
                              <span class="text-xs font-semibold text-slate-400">
                                <?= date('d/m/Y', strtotime($loan['loan_date'])) ?> - <?= date('d/m/Y', strtotime($loan['return_date'])) ?>
                              </span>
                            </td>
                            <td class="p-4 text-center align-middle bg-transparent border-b">
                              <?php
                                $statusClass = '';
                                $statusText = '';
                                
                                // Cek apakah sudah melewati tanggal pengembalian (overdue)
                                $isOverdue = ($loan['status'] === 'approved' && 
                                              empty($loan['actual_return_date']) && 
                                              strtotime($loan['return_date']) < strtotime(date('Y-m-d')));
                                
                                if ($isOverdue) {
                                    $statusClass = 'bg-orange-100 text-orange-700';
                                    $statusText = 'Terlambat';
                                } else {
                                    switch ($loan['status']) {
                                      case 'pending':
                                        $statusClass = 'bg-yellow-100 text-yellow-700';
                                        $statusText = 'Menunggu';
                                        break;
                                      case 'approved':
                                        $statusClass = 'bg-green-100 text-green-700';
                                        $statusText = 'Dipinjam';
                                        break;
                                      case 'rejected':
                                        $statusClass = 'bg-red-100 text-red-700';
                                        $statusText = 'Ditolak';
                                        break;
                                      case 'returned':
                                        $statusClass = 'bg-blue-100 text-blue-700';
                                        $statusText = 'Dikembalikan';
                                        break;
                                      default:
                                        $statusClass = 'bg-gray-100 text-gray-700';
                                        $statusText = ucfirst($loan['status']);
                                    }
                                }
                              ?>
                              <span class="px-3 py-1 text-xs font-bold rounded-full <?= $statusClass ?>">
                                <?= $statusText ?>
                              </span>
                              <?php if ($isOverdue): ?>
                                <p class="text-xs text-orange-600 mt-1">
                                  <i class="fas fa-exclamation-triangle"></i> Segera kembalikan!
                                </p>
                              <?php endif; ?>
                            </td>
                            <td class="p-4 text-center align-middle bg-transparent border-b">
                              <?php if ($loan['status'] === 'pending'): ?>
                                <form method="POST" action="index.php?page=peminjaman&action=cancel_loan" class="inline" onsubmit="return confirm('Yakin ingin membatalkan pengajuan ini?');">
                                  <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                  <button type="submit" class="px-3 py-1 text-xs font-bold text-red-600 hover:text-red-800">
                                    <i class="fas fa-times mr-1"></i> Batal
                                  </button>
                                </form>
                              <?php elseif ($loan['status'] === 'rejected' && !empty($loan['admin_note'])): ?>
                                <button type="button" onclick="alert('Alasan: <?= htmlspecialchars(addslashes($loan['admin_note'])) ?>')" class="px-3 py-1 text-xs font-bold text-blue-600 hover:text-blue-800">
                                  <i class="fas fa-info-circle mr-1"></i> Lihat Alasan
                                </button>
                              <?php else: ?>
                                <span class="text-xs text-slate-400">-</span>
                              <?php endif; ?>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                <?php else: ?>
                  <div class="text-center py-8">
                    <i class="fas fa-box-open text-4xl text-slate-300 mb-3"></i>
                    <p class="text-slate-400">Belum ada riwayat peminjaman.</p>
                  </div>
                <?php endif; ?>
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
</html>
