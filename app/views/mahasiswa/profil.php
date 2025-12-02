<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ?page=login");
    exit;
}

$flash_message = $_SESSION['flash_message'] ?? null;
unset($_SESSION['flash_message']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa</title>
     <link rel="icon" type="image/png" href="assets/img/logo.jpg" />
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <link id="pagestyle" href="assets/css/soft-ui-dashboard-tailwind.css?v=1.0.8" rel="stylesheet" />
  <link 
  rel="stylesheet" 
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
  integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
  crossorigin="anonymous" 
  referrerpolicy="no-referrer" 
/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <style>
        * {
            font-family: 'Open Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }
        body {
            font-family: 'Open Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }
    </style>
</head>

<body class="m-0 font-sans text-base antialiased font-normal leading-default bg-gray-50 text-slate-500">
    <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>
    
    <aside class="max-w-62.5 ease-nav-brand z-990 fixed inset-y-0 my-4 ml-4 block w-full -translate-x-full flex-wrap items-center justify-between overflow-y-auto rounded-2xl border-0 bg-white p-0 antialiased shadow-none transition-transform duration-200 xl:left-0 xl:translate-x-0 xl:bg-transparent">
        
        <div class="h-19.5">
            <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden" sidenav-close></i>
            
            <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="javascript:void(0);">
                <div class="flex flex-col justify-center">
                    <h6 class="font-bold text-lg mb-0 text-blue-600 tracking-tight">MAHASISWA</h6>
                    <p class="text-xs font-semibold text-slate-500 mt-1 uppercase">
                        Hello, <?= htmlspecialchars($_SESSION['full_name'] ?? 'Mahasiswa') ?>
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
                <!-- Menu Utama Section -->
                 <li class="mt-0.5 w-full">
            <a
              class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
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
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF" fill-rule="nonzero">
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

        <!-- Pengaturan Section -->
        <li class="mt-4 w-full px-4">
            <h6 class="pl-2 ml-2 text-xs font-bold uppercase leading-tight opacity-60">Pengaturan</h6>
        </li>

        <li class="mt-0.5 w-full">
            <a class="py-2.7 shadow-soft-xl text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg bg-white px-4 font-semibold text-slate-700 transition-colors" href="?page=profil">
                <div class="bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="8" r="4" stroke="white" stroke-width="2" fill="none"/>
                        <path stroke="white" stroke-width="2" d="M4 20c0-3.333 3.333-6 8-6s8 2.667 8 6" fill="none"/>
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
        
        <!-- Navbar (Header) -->
        <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="true">
            <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
                <nav>
                    <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
                        <li class="text-sm leading-normal">
                            <a class="opacity-50 text-slate-700" href="javascript:;">Pages</a>
                        </li>
                        <li class="text-sm leading-normal text-slate-700 pl-2 before:float-left before:pr-2 before:text-gray-600 before:content-['/']" aria-current="page">Profil</li>
                    </ol>
                    <h6 class="mb-0 font-bold capitalize">Edit Profil Mahasiswa</h6>
                </nav>

                <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto justify-end">
                    <img src="assets/img/logo_inlet_horizontal-removebg.png" alt="Logo Lab InLET" class="h-12 w-auto object-contain" onerror="this.style.display='none';">
                    
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
            <?php if ($flash_message): 
                $base_class = "p-4 mb-4 text-sm rounded-lg shadow-soft-md";
                $icon = 'fas fa-info-circle';
                $bg_color = 'bg-gray-100';
                $text_color = 'text-gray-800';
                $icon_color = 'text-gray-600';

                if ($flash_message['type'] == 'success') {
                    $icon = 'fas fa-check-circle';
                    $bg_color = 'bg-green-100';
                    $text_color = 'text-green-800';
                    $icon_color = 'text-green-600';
                } elseif ($flash_message['type'] == 'error') {
                    $icon = 'fas fa-times-circle';
                    $bg_color = 'bg-red-100';
                    $text_color = 'text-red-800';
                    $icon_color = 'text-red-600';
                } elseif ($flash_message['type'] == 'warning') {
                    $icon = 'fas fa-exclamation-circle';
                    $bg_color = 'bg-yellow-100';
                    $text_color = 'text-yellow-800';
                    $icon_color = 'text-yellow-600';
                }
            ?>
                <div class="<?php echo $base_class; ?> <?php echo $bg_color; ?> <?php echo $text_color; ?>">
                    <i class="<?php echo $icon; ?> mr-2 <?php echo $icon_color; ?>"></i>
                    <?php echo $flash_message['text']; ?>
                </div>
            <?php endif; ?>

            <!-- Error Message Area -->
            <?php if ($error_message): ?>
                <div class="p-4 mb-4 text-sm rounded-lg shadow-soft-md bg-red-100 text-red-800">
                    <i class="fas fa-times-circle mr-2 text-red-600"></i>
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <!-- Profile Card -->
            <div class="w-full mb-6">
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent flex items-center justify-between">
                        <div>
                            <h6 class="mb-0 text-2xl font-bold">Data Profil Saya</h6>
                            <p class="text-sm text-gray-500 mt-1">Kelola informasi akun Anda</p>
                        </div>
                        <!-- Edit/Cancel Buttons Header -->
                        <div id="headerButtons" class="flex gap-2">
                            <button type="button" id="editModeBtn" onclick="enableEditMode()" class="px-6 py-2 font-bold text-center text-white uppercase transition-all ease-in border-0 rounded-lg shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 hover:shadow-soft-2xl text-xs">
                                Edit
                            </button>
                            <button type="button" id="cancelEditBtn" onclick="disableEditMode()" class="hidden px-6 py-2 font-bold text-center text-slate-700 uppercase transition-all ease-in border-2 border-slate-300 rounded-lg text-xs hover:bg-gray-100">
                                Batal
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex-auto p-6">
                        <form method="POST" class="space-y-6">
                            
                            <!-- NIM -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="ml-1 font-bold text-xs text-slate-700">NIM</label>
                                    <i class="editIcon fas fa-pencil-alt text-purple-500 cursor-pointer opacity-60 text-xs" title="Klik edit untuk mengubah"></i>
                                </div>
                                <input type="text" id="nimField" name="nim" value="<?php echo htmlspecialchars($student_data['nim'] ?? ''); ?>" disabled class="disabled-field focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 text-slate-700 shadow-soft-md transition-all placeholder:text-gray-500 placeholder:opacity-100 focus:border-fuchsia-500 focus:outline-none focus:transition-shadow" placeholder="Masukkan NIM Anda" />
                                <small class="text-gray-500 mt-1 block">Gunakan NIM yang terdaftar di sistem akademik</small>
                            </div>

                            <!-- Nama Lengkap -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="ml-1 font-bold text-xs text-slate-700">Nama Lengkap</label>
                                    <i class="editIcon fas fa-pencil-alt text-purple-500 cursor-pointer opacity-60 text-xs" title="Klik edit untuk mengubah"></i>
                                </div>
                                <input type="text" id="fullNameField" name="full_name" value="<?php echo htmlspecialchars($student_data['full_name'] ?? ''); ?>" disabled class="disabled-field focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 text-slate-700 shadow-soft-md transition-all placeholder:text-gray-500 placeholder:opacity-100 focus:border-fuchsia-500 focus:outline-none focus:transition-shadow" placeholder="Masukkan nama lengkap Anda" />
                                <small class="text-gray-500 mt-1 block">Nama sesuai dengan kartu identitas</small>
                            </div>

                            <!-- Email -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="ml-1 font-bold text-xs text-slate-700">Email</label>
                                    <i class="editIcon fas fa-pencil-alt text-purple-500 cursor-pointer opacity-60 text-xs" title="Klik edit untuk mengubah"></i>
                                </div>
                                <input type="email" id="emailField" name="email" value="<?php echo htmlspecialchars($student_data['email'] ?? ''); ?>" disabled class="disabled-field focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 text-slate-700 shadow-soft-md transition-all placeholder:text-gray-500 placeholder:opacity-100 focus:border-fuchsia-500 focus:outline-none focus:transition-shadow" placeholder="Masukkan email Anda" />
                                <small class="text-gray-500 mt-1 block">Gunakan email yang aktif untuk komunikasi penting</small>
                            </div>

                            <!-- Program Study (Editable Dropdown) -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="ml-1 font-bold text-xs text-slate-700">Program Studi</label>
                                    <i class="editIcon fas fa-pencil-alt text-purple-500 cursor-pointer opacity-60 text-xs" title="Klik edit untuk mengubah"></i>
                                </div>
                                <select id="programStudyField" name="program_study" disabled class="disabled-field focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-slate-700 shadow-soft-md transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                                    <?php $selected_prodi = $student_data['program_study'] ?? ''; ?>
                                    <option value="Teknik Informatika" <?= $selected_prodi == 'Teknik Informatika' ? 'selected' : '' ?>>Teknik Informatika</option>
                                    <option value="Sistem Informasi" <?= $selected_prodi == 'Sistem Informasi' ? 'selected' : '' ?>>Sistem Informasi</option>
                                    <option value="Komputer Akuntansi" <?= $selected_prodi == 'Komputer Akuntansi' ? 'selected' : '' ?>>Komputer Akuntansi</option>
                                    <option value="Lainnya" <?= $selected_prodi == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>

                            <!-- Batch (Editable) -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="ml-1 font-bold text-xs text-slate-700">Angkatan</label>
                                    <i class="editIcon fas fa-pencil-alt text-purple-500 cursor-pointer opacity-60 text-xs" title="Klik edit untuk mengubah"></i>
                                </div>
                                <input type="number" id="batchField" name="batch" value="<?php echo htmlspecialchars($student_data['batch'] ?? ''); ?>" disabled min="2000" max="<?= date('Y') ?>" class="disabled-field focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 text-slate-700 shadow-soft-md transition-all placeholder:text-gray-500 placeholder:opacity-100 focus:border-fuchsia-500 focus:outline-none focus:transition-shadow" placeholder="Contoh: 2024" />
                            </div>

                            <!-- Password Preview (Shows minimal until edit) -->
                            <div id="passwordPreview" class="rounded-lg bg-blue-50 border border-blue-200 p-3">
                                <p class="text-xs text-blue-700 mb-0">
                                    <i class="fas fa-lock mr-2"></i>
                                    <span>Password tersembunyi. Klik tombol Edit untuk mengubah password</span>
                                </p>
                            </div>

                            <hr class="my-6">

                            <!-- Password Section (Hidden until edit mode) -->
                            <div id="passwordSection" class="hidden rounded-lg bg-gray-50 p-4 border border-gray-200">
                                <h6 class="text-sm font-bold text-slate-700 mb-4">Ubah Password</h6>
                                
                                <div class="mb-4">
                                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Password Lama</label>
                                    <input type="password" name="old_password" class="focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 text-slate-700 shadow-soft-md transition-all placeholder:text-gray-500 placeholder:opacity-100 focus:border-fuchsia-500 focus:outline-none focus:transition-shadow" placeholder="Masukkan password lama (jika ingin mengubah password)" />
                                    <small class="text-gray-500 mt-1 block">Kosongkan jika tidak ingin mengubah password</small>
                                </div>

                                <div class="mb-4">
                                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Password Baru</label>
                                    <input type="password" name="new_password" class="focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 text-slate-700 shadow-soft-md transition-all placeholder:text-gray-500 placeholder:opacity-100 focus:border-fuchsia-500 focus:outline-none focus:transition-shadow" placeholder="Masukkan password baru" />
                                </div>

                                <div>
                                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Konfirmasi Password Baru</label>
                                    <input type="password" name="confirm_password" class="focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 text-slate-700 shadow-soft-md transition-all placeholder:text-gray-500 placeholder:opacity-100 focus:border-fuchsia-500 focus:outline-none focus:transition-shadow" placeholder="Konfirmasi password baru" />
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div id="formButtons" class="hidden gap-4 pt-6 border-t flex">
                                <button type="submit" class="inline-block px-8 py-2 font-bold text-center text-white uppercase transition-all ease-in border-0 rounded-lg shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 hover:shadow-soft-2xl hover:scale-102 text-xs">
                                    Simpan Perubahan
                                </button>
                                <button type="button" onclick="disableEditMode()" class="inline-block px-8 py-2 font-bold text-center text-slate-700 uppercase transition-all ease-in border-2 border-slate-300 rounded-lg hover:bg-gray-100 text-xs">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/js/navbar-collapse.js"></script>
    <script src="assets/js/sidenav-burger.js"></script>

    <style>
        /* Disabled input field styling */
        input:disabled,
        textarea:disabled,
        select:disabled {
            background-color: #f3f4f6 !important;
            opacity: 1 !important;
            color: #6b7280;
        }

        input:disabled::placeholder {
            color: #9ca3af;
            opacity: 1;
        }

        .disabled-field {
            background-color: #f3f4f6 !important;
        }

        /* Smooth transitions for button visibility */
        #editModeBtn,
        #cancelEditBtn,
        #formButtons,
        #passwordSection {
            transition: all 0.3s ease-in-out;
        }

        .hidden {
            display: none !important;
        }
    </style>

    <script>
        function enableEditMode() {
            // Enable all editable fields
            document.getElementById('nimField').disabled = false;
            document.getElementById('fullNameField').disabled = false;
            document.getElementById('emailField').disabled = false;
            document.getElementById('programStudyField').disabled = false;
            document.getElementById('batchField').disabled = false;
            
            // Enable password fields
            const passwordInputs = document.querySelectorAll('#passwordSection input[type="password"]');
            passwordInputs.forEach(input => input.disabled = false);
            
            // Hide icon edits
            document.querySelectorAll('.editIcon').forEach(icon => {
                icon.style.opacity = '0';
            });
            
            // Hide password preview, show password section
            document.getElementById('passwordPreview').classList.add('hidden');
            document.getElementById('passwordSection').classList.remove('hidden');
            
            // Show/hide header buttons
            document.getElementById('editModeBtn').classList.add('hidden');
            document.getElementById('cancelEditBtn').classList.remove('hidden');
            
            // Show form action buttons
            document.getElementById('formButtons').classList.remove('hidden');
            
            // Scroll to top to show edit mode notification
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function disableEditMode() {
            // Disable all editable fields
            document.getElementById('nimField').disabled = true;
            document.getElementById('fullNameField').disabled = true;
            document.getElementById('emailField').disabled = true;
            document.getElementById('programStudyField').disabled = true;
            document.getElementById('batchField').disabled = true;
            
            // Disable password fields and clear them
            const passwordInputs = document.querySelectorAll('#passwordSection input[type="password"]');
            passwordInputs.forEach(input => {
                input.disabled = true;
                input.value = '';
            });
            
            // Clear old password field
            const oldPasswordField = document.querySelector('input[name="old_password"]');
            if (oldPasswordField) oldPasswordField.value = '';
            
            // Show icon edits
            document.querySelectorAll('.editIcon').forEach(icon => {
                icon.style.opacity = '0.6';
            });
            
            // Show password preview, hide password section
            document.getElementById('passwordPreview').classList.remove('hidden');
            document.getElementById('passwordSection').classList.add('hidden');
            
            // Show/hide header buttons
            document.getElementById('editModeBtn').classList.remove('hidden');
            document.getElementById('cancelEditBtn').classList.add('hidden');
            
            // Hide form action buttons
            document.getElementById('formButtons').classList.add('hidden');
            
            // Clear any error messages
            const alertElements = document.querySelectorAll('.alert-danger, .alert-warning');
            alertElements.forEach(alert => {
                if (!alert.classList.contains('persistent')) {
                    alert.style.display = 'none';
                }
            });
        }

        // Initialize on page load - ensure fields are disabled
        document.addEventListener('DOMContentLoaded', function() {
            // Make sure we start in view-only mode
            disableEditMode();
            
            // Add icon hover effects
            document.querySelectorAll('.editIcon').forEach(icon => {
                const parentDiv = icon.closest('div');
                if (parentDiv) {
                    parentDiv.addEventListener('mouseenter', function() {
                        icon.style.opacity = '1';
                    });
                    parentDiv.addEventListener('mouseleave', function() {
                        icon.style.opacity = '0.6';
                    });
                }
            });
            
            // Add form submission handler - enable all fields before submit so they get sent
            const profileForm = document.querySelector('form');
            if (profileForm) {
                profileForm.addEventListener('submit', function(e) {
                    // Enable all fields temporarily so they get submitted
                    document.getElementById('nimField').disabled = false;
                    document.getElementById('fullNameField').disabled = false;
                    document.getElementById('emailField').disabled = false;
                    document.getElementById('programStudyField').disabled = false;
                    document.getElementById('batchField').disabled = false;
                    
                    // Password fields will remain in their current state
                });
            }
        });
    </script>
</body>

</html>
