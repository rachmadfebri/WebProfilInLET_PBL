<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nama_pengguna = $_SESSION['full_name'] ?? 'Administrator';

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

// Default stats
$stats = $stats ?? ['pending' => 0, 'active' => 0, 'overdue' => 0, 'returned' => 0, 'rejected' => 0];
$loans = $loans ?? [];
$filter = $_GET['filter'] ?? 'all';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    
    <title>Kelola Peminjaman - Lab InLET</title>
    
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    
    <!-- Popper -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    
    <!-- Main Styling -->
    <link href="assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5" rel="stylesheet" />
</head>

<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">
    
    <!-- sidenav -->
    <aside
      id="sidenav-main"
      class="fixed inset-y-0 left-0 w-full max-w-62.5 -translate-x-full p-0 antialiased shadow-2xl transition-transform duration-300 xl:ml-4 xl:my-4 xl:translate-x-0 xl:rounded-2xl xl:shadow-soft-xl xl:h-[calc(100vh-2rem)] h-full flex flex-col border-r border-gray-200 xl:border-0"
      style="z-index: 9999 !important; background-color: white !important;"
    >
    
      <!-- LOGO -->
      <div class="h-19.5 shrink-0 px-2 py-2">
        <i
          class="absolute top-0 right-0 hidden p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden"
          sidenav-close
        ></i>
        <a
          class="block px-8 py-4 m-0 text-sm whitespace-nowrap text-slate-700"
          href="javascript:;"
          target="_blank"
        >
          <img
            src="assets/img/logo_inlet_horizontal-removebg.png"
            class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-12"
            style="margin-top: -36px; margin-left: -5px !important;"
            alt="main_logo"
          />
        </a>
      </div>
      
      <hr
        class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent"
      />

      <div class="mx-4 mt-2 mb-2 font-bold text-slate-700 text-base">
        Utama
      </div>
      <!-- Tombol Beranda -->
      <div
        class="items-center block w-auto max-h-screen overflow-y-auto h-sidenav grow basis-full"
      >
        <ul class="flex flex-col pl-0 mb-0">
          <li class="mt-0.5 w-full">
            <a
              class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
              href="?page=admin-dashboard"
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
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Beranda</span>
            </a>
          </li>

          <!-- Tombol Galeri -->
          <li class="mt-0.5 w-full">
            <a
              class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
              href="?page=gallery"
            >
              <div
                class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5"
              >
                <svg
                  width="12px"
                  height="12px"
                  viewBox="0 0 42 42"
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                  <title>office</title>
                  <g
                    stroke="none"
                    stroke-width="1"
                    fill="none"
                    fill-rule="evenodd"
                  >
                    <g
                      transform="translate(-1869.000000, -293.000000)"
                      fill="#FFFFFF"
                      fill-rule="nonzero"
                    >
                      <g transform="translate(1716.000000, 291.000000)">
                        <g transform="translate(153.000000, 2.000000)">
                          <path
                            class="fill-slate-800 opacity-60"
                            d="M12.25,17.5 L8.75,17.5 L8.75,1.75 C8.75,0.78225 9.53225,0 10.5,0 L31.5,0 C32.46775,0 33.25,0.78225 33.25,1.75 L33.25,12.25 L29.75,12.25 L29.75,3.5 L12.25,3.5 L12.25,17.5 Z"
                          ></path>
                          <path
                            class="fill-slate-800"
                            d="M40.25,14 L24.5,14 C23.53225,14 22.75,14.78225 22.75,15.75 L22.75,38.5 L19.25,38.5 L19.25,22.75 C19.25,21.78225 18.46775,21 17.5,21 L1.75,21 C0.78225,21 0,21.78225 0,22.75 L0,40.25 C0,41.21775 0.78225,42 1.75,42 L40.25,42 C41.21775,42 42,41.21775 42,40.25 L42,15.75 C42,14.78225 41.21775,14 40.25,14 Z M12.25,36.75 L7,36.75 L7,33.25 L12.25,33.25 L12.25,36.75 Z M12.25,29.75 L7,29.75 L7,26.25 L12.25,26.25 L12.25,29.75 Z M35,36.75 L29.75,36.75 L29.75,33.25 L35,33.25 L35,36.75 Z M35,29.75 L29.75,29.75 L29.75,26.25 L35,26.25 L35,29.75 Z M35,22.75 L29.75,22.75 L29.75,19.25 L35,19.25 L35,22.75 Z"
                          ></path>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </div>
              <span
                class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft"
                >Galeri</span
              >
            </a>
          </li>

          <!-- Tombol News -->
          <li class="mt-0.5 w-full">
            <a
              class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
              href="?page=news"
            >
              <div
                class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center fill-current stroke-0 text-center xl:p-2.5"
              >
                <svg
                  width="12px"
                  height="12px"
                  viewBox="0 0 43 36"
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                  <title>credit-card</title>
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                      <g transform="translate(1716.000000, 291.000000)">
                        <g transform="translate(453.000000, 454.000000)">
                          <path
                            class="fill-slate-800 opacity-60"
                            d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                          ></path>
                          <path
                            class="fill-slate-800"
                            d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"
                          ></path>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Berita</span>
            </a>
          </li>

          <!-- Tombol Produk -->
          <li class="mt-0.5 w-full">
            <a
              class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
              href="?page=products"
            >
              <div
                class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5"
              >
                <svg
                  width="12px"
                  height="12px"
                  viewBox="0 0 42 42"
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                  <title>box-3d-50</title>
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-2319.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                      <g transform="translate(1716.000000, 291.000000)">
                        <g transform="translate(603.000000, 0.000000)">
                          <path
                            class="fill-slate-800"
                            d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z"
                          ></path>
                          <path
                            class="fill-slate-800 opacity-60"
                            d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z"
                          ></path>
                          <path
                            class="fill-slate-800 opacity-60"
                            d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z"
                          ></path>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Produk</span>
            </a>
          </li>

          <!-- Tombol Riset -->
          <li class="mt-0.5 w-full">
            <a
              class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
              href="?page=research"
            >
              <div
                class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5"
              >
                <svg
                  width="12px"
                  height="12px"
                  viewBox="0 0 40 40"
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                  <title>settings</title>
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF" fill-rule="nonzero">
                      <g transform="translate(1716.000000, 291.000000)">
                        <g transform="translate(304.000000, 151.000000)">
                          <polygon
                            class="fill-slate-800 opacity-60"
                            points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667"
                          ></polygon>
                          <path
                            class="fill-slate-800 opacity-60"
                            d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z"
                          ></path>
                          <path
                            class="fill-slate-800"
                            d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z"
                          ></path>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Riset</span>
            </a>
          </li>

          <!-- Tombol Tim -->
          <li class="mt-0.5 w-full">
            <a
              class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
              href="?page=team"
            >
              <div
                class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5"
              >
                <svg
                  width="12px"
                  height="12px"
                  viewBox="0 0 46 42"
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                  <title>customer-support</title>
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                      <g transform="translate(1716.000000, 291.000000)">
                        <g transform="translate(1.000000, 0.000000)">
                          <path
                            class="fill-slate-800 opacity-60"
                            d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z"
                          ></path>
                          <path
                            class="fill-slate-800"
                            d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z"
                          ></path>
                          <path
                            class="fill-slate-800"
                            d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z"
                          ></path>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Tim</span>
            </a>
          </li>

          <!-- Tombol Kerjasama -->
          <li class="mt-0.5 w-full">
            <a
              class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
              href="?page=collaboration"
            >
              <div
                class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5"
              >
                <i class="ni leading-none ni-paper-diploma text-xs relative top-2 text-gray"></i>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Kerjasama</span>
            </a>
          </li>

          <!-- Tombol Buku Tamu -->
          <li class="mt-0.5 w-full">
            <a
              class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
              href="?page=admin-guestbook"
            >
              <div
                class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5"
              >
                <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg">
                  <title>book</title>
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-1869.000000, -293.000000)" fill="#FFFFFF" fill-rule="nonzero">
                      <g transform="translate(1716.000000, 291.000000)">
                        <g transform="translate(153.000000, 2.000000)">
                          <path class="fill-slate-800" d="M21,0 C9.402,0 0,9.402 0,21 C0,32.598 9.402,42 21,42 C32.598,42 42,32.598 42,21 C42,9.402 32.598,0 21,0 Z M21,39.417 C11.106,39.417 3.583,31.894 3.583,21 C3.583,11.106 11.106,3.583 21,3.583 C30.894,3.583 38.417,11.106 38.417,21 C38.417,30.894 30.894,39.417 21,39.417 Z"></path>
                          <path class="fill-slate-800 opacity-60" d="M21,10.5 C18.5133333,10.5 16.5,12.5133333 16.5,15 C16.5,17.4866667 18.5133333,19.5 21,19.5 C23.4866667,19.5 25.5,17.4866667 25.5,15 C25.5,12.5133333 23.4866667,10.5 21,10.5 Z M21,26.25 C17.5633333,26.25 14.6633333,28.5133333 13.875,31.5 L28.125,31.5 C27.3366667,28.5133333 24.4366667,26.25 21,26.25 Z"></path>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Buku Tamu</span>
            </a>
          </li>

          <!-- menu mahasiswa -->
      <div class="mx-4 my-6 shrink-0">
        <div class="mb-2 font-bold text-slate-700 text-base">Mahasiswa</div>
        <ul class="flex flex-col pl-0 mb-0">
          <!-- Tombol Absensi -->
          <li class="mt-0.5 w-full">
            <a
              class="py-2.7 text-sm ease-nav-brand my-0 mx-0 flex items-center whitespace-nowrap px-4 transition-colors"
              href="?page=absensi"
            >
              <div
                class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5"
              >
                <svg
                  width="20px"
                  height="20px"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <circle cx="12" cy="12" r="10" fill="#8B5CF6" />
                  <path d="M8 12.5l2 2 4-4" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Absensi</span>
            </a>
          </li>
          <!-- Tombol Daftar Mahasiswa -->
          <li class="mt-* w-full">
            <a
              class="py-2.7 text-sm ease-nav-brand my-0 mx-0 flex items-center whitespace-nowrap px-4 transition-colors"
              href="?page=students"
            >
              <div
                class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5"
              >
                <!-- Icon kertas simpel -->
                <svg
                  width="20px"
                  height="20px"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <rect x="4" y="4" width="16" height="20" rx="3" fill="#8B5CF6" />
                  <rect x="7" y="8" width="10" height="2" rx="1" fill="#fff"/>
                  <rect x="7" y="12" width="10" height="2" rx="1" fill="#fff"/>
                  <rect x="7" y="16" width="6" height="2" rx="1" fill="#fff"/>
                </svg>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Daftar Mahasiswa</span>
            </a>
          </li>
          <!-- Tombol Peminjaman (ACTIVE) -->
          <li class="mt-* w-full">
            <a
              class="py-2.7 shadow-soft-xl text-sm ease-nav-brand my-0 mx-0 flex items-center whitespace-nowrap rounded-lg bg-white px-4 font-semibold text-slate-700 transition-colors"
              href="?page=admin-loans"
            >
              <div
                class="bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5"
              >
                <svg
                  width="20px"
                  height="20px"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <rect x="3" y="6" width="18" height="12" rx="2" fill="#fff" />
                  <path d="M8 12H16M12 8V16" stroke="#8B5CF6" stroke-width="2" stroke-linecap="round"/>
                </svg>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Peminjaman</span>
            </a>
          </li>
          <!-- Tombol Inventaris -->
          <li class="mt-* w-full">
            <a
              class="py-2.7 text-sm ease-nav-brand my-0 mx-0 flex items-center whitespace-nowrap px-4 transition-colors"
              href="?page=inventory"
            >
              <div
                class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5"
              >
                <svg
                  width="20px"
                  height="20px"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <rect x="3" y="4" width="18" height="16" rx="2" fill="#8B5CF6" />
                  <rect x="6" y="7" width="4" height="3" rx="1" fill="#fff"/>
                  <rect x="11" y="7" width="4" height="3" rx="1" fill="#fff"/>
                  <rect x="6" y="12" width="4" height="3" rx="1" fill="#fff"/>
                  <rect x="11" y="12" width="4" height="3" rx="1" fill="#fff"/>
                </svg>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Inventaris</span>
            </a>
          </li>
          <!-- Tombol Log Out -->
          <li class="mt-6 w-full">
            <a href="?action=logout"
              class="inline-block w-full px-8 py-2 font-bold text-center text-white uppercase transition-all ease-in border-0 border-white rounded-lg shadow-soft-md bg-150 leading-pro text-xs bg-gradient-to-tl from-slate-600 to-slate-300 hover:shadow-soft-2xl hover:scale-102">
              Logout
            </a>
          </li>
        </ul>
      </div>
    </aside>
    <!-- end sidenav -->

    <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
      
      <!-- Navbar -->
      <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="true">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
          <nav>
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
              <li class="leading-normal text-sm">
                <a class="opacity-50 text-slate-700" href="javascript:;">Pages</a>
              </li>
              <li class="text-sm pl-2 capitalize leading-normal text-slate-700 before:float-left before:pr-2 before:text-gray-600 before:content-['/']" aria-current="page">
                Peminjaman
              </li>
            </ol>
            <h6 class="mb-0 font-bold capitalize">Kelola Peminjaman</h6>
          </nav>

          <div class="flex items-center md:ml-auto md:pr-4">
            <span class="flex items-center px-3 py-2 bg-white rounded-lg shadow-soft-md">
              <i class="fas fa-user-circle text-purple-600 mr-2"></i>
              <span class="font-semibold text-slate-700"><?= htmlspecialchars($nama_pengguna) ?></span>
            </span>
          </div>
          
          <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
            <li class="flex items-center pl-4 xl:hidden">
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
      </nav>

      <!-- Content -->
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

        <!-- Stats Cards -->
        <div class="flex flex-wrap -mx-3 mb-6">
          
          <!-- Pending -->
          <div class="w-full max-w-full px-3 mb-4 sm:w-1/2 xl:w-1/5">
            <a href="?page=admin-loans&filter=pending" class="block">
              <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border <?= $filter == 'pending' ? 'ring-2 ring-yellow-400' : '' ?>">
                <div class="flex-auto p-4">
                  <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                      <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-500">Menunggu</p>
                      <h5 class="mb-0 font-bold text-xl text-yellow-600"><?= $stats['pending'] ?? 0 ?></h5>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                      <div class="inline-flex items-center justify-center w-12 h-12 text-center rounded-lg" style="background: linear-gradient(310deg, #f7b924 0%, #ffc107 100%);">
                        <i class="fas fa-clock text-lg text-white"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <!-- Active -->
          <div class="w-full max-w-full px-3 mb-4 sm:w-1/2 xl:w-1/5">
            <a href="?page=admin-loans&filter=active" class="block">
              <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border <?= $filter == 'active' ? 'ring-2 ring-green-400' : '' ?>">
                <div class="flex-auto p-4">
                  <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                      <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-500">Aktif</p>
                      <h5 class="mb-0 font-bold text-xl text-green-600"><?= $stats['active'] ?? 0 ?></h5>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                      <div class="inline-flex items-center justify-center w-12 h-12 text-center rounded-lg" style="background: linear-gradient(310deg, #17ad37 0%, #98ec2d 100%);">
                        <i class="fas fa-check-circle text-lg text-white"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <!-- Overdue -->
          <div class="w-full max-w-full px-3 mb-4 sm:w-1/2 xl:w-1/5">
            <a href="?page=admin-loans&filter=overdue" class="block">
              <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border <?= $filter == 'overdue' ? 'ring-2 ring-red-400' : '' ?>">
                <div class="flex-auto p-4">
                  <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                      <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-500">Terlambat</p>
                      <h5 class="mb-0 font-bold text-xl text-red-600"><?= $stats['overdue'] ?? 0 ?></h5>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                      <div class="inline-flex items-center justify-center w-12 h-12 text-center rounded-lg" style="background: linear-gradient(310deg, #ea0606 0%, #ff667c 100%);">
                        <i class="fas fa-exclamation-triangle text-lg text-white"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <!-- Returned -->
          <div class="w-full max-w-full px-3 mb-4 sm:w-1/2 xl:w-1/5">
            <a href="?page=admin-loans&filter=returned" class="block">
              <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border <?= $filter == 'returned' ? 'ring-2 ring-blue-400' : '' ?>">
                <div class="flex-auto p-4">
                  <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                      <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-500">Dikembalikan</p>
                      <h5 class="mb-0 font-bold text-xl text-blue-600"><?= $stats['returned'] ?? 0 ?></h5>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                      <div class="inline-flex items-center justify-center w-12 h-12 text-center rounded-lg" style="background: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%);">
                        <i class="fas fa-undo text-lg text-white"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <!-- Semua -->
          <div class="w-full max-w-full px-3 mb-4 sm:w-1/2 xl:w-1/5">
            <a href="?page=admin-loans&filter=all" class="block">
              <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border <?= $filter == 'all' ? 'ring-2 ring-purple-400' : '' ?>">
                <div class="flex-auto p-4">
                  <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                      <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-500">Semua</p>
                      <h5 class="mb-0 font-bold text-xl text-purple-600">
                        <?= ($stats['pending'] ?? 0) + ($stats['active'] ?? 0) + ($stats['returned'] ?? 0) + ($stats['rejected'] ?? 0) ?>
                      </h5>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                      <div class="inline-flex items-center justify-center w-12 h-12 text-center rounded-lg" style="background: linear-gradient(310deg, #7928ca 0%, #ff0080 100%);">
                        <i class="fas fa-list text-lg text-white"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>

        </div>

        <!-- Table -->
        <div class="flex flex-wrap -mx-3">
          <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
              
              <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                <div class="flex justify-between items-center">
                  <h6 class="mb-0 font-bold text-slate-700">
                    <i class="fas fa-exchange-alt mr-2 text-purple-500"></i> 
                    Daftar Peminjaman
                    <?php if ($filter != 'all'): ?>
                      <span class="text-sm font-normal text-slate-400">- Filter: <?= ucfirst($filter) ?></span>
                    <?php endif; ?>
                  </h6>
                </div>
              </div>

              <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-0 overflow-x-auto">
                  <?php if (!empty($loans)): ?>
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                      <thead class="align-bottom">
                        <tr>
                          <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 text-xxs text-slate-400">Peminjam</th>
                          <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 text-xxs text-slate-400">Barang/Ruang</th>
                          <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 text-xxs text-slate-400">Periode</th>
                          <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 text-xxs text-slate-400">Status</th>
                          <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 text-xxs text-slate-400">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($loans as $loan): ?>
                          <tr>
                            <td class="p-4 align-middle bg-transparent border-b">
                              <div class="flex flex-col">
                                <h6 class="mb-0 text-sm font-semibold text-slate-700"><?= htmlspecialchars($loan['user_name']) ?></h6>
                                <p class="mb-0 text-xs text-slate-400"><?= htmlspecialchars($loan['user_email']) ?></p>
                              </div>
                            </td>
                            <td class="p-4 align-middle bg-transparent border-b">
                              <div class="flex flex-col">
                                <h6 class="mb-0 text-sm font-semibold text-slate-700"><?= htmlspecialchars($loan['inventory_name']) ?></h6>
                                <p class="mb-0 text-xs text-slate-400"><?= ucfirst($loan['inventory_type']) ?></p>
                              </div>
                            </td>
                            <td class="p-4 text-center align-middle bg-transparent border-b">
                              <div class="flex flex-col">
                                <span class="text-xs font-semibold text-slate-700">
                                  <?= date('d M Y', strtotime($loan['loan_date'])) ?>
                                </span>
                                <span class="text-xs text-slate-400">s/d</span>
                                <span class="text-xs font-semibold text-slate-700">
                                  <?= date('d M Y', strtotime($loan['return_date'])) ?>
                                </span>
                              </div>
                            </td>
                            <td class="p-4 text-center align-middle bg-transparent border-b">
                              <?php
                                $statusClass = '';
                                $statusText = '';
                                $statusIcon = '';
                                switch ($loan['status']) {
                                  case 'pending':
                                    $statusClass = 'bg-yellow-100 text-yellow-700';
                                    $statusText = 'Menunggu';
                                    $statusIcon = 'fas fa-clock';
                                    break;
                                  case 'approved':
                                    $isOverdue = strtotime($loan['return_date']) < time() && empty($loan['actual_return_date']);
                                    if ($isOverdue) {
                                      $statusClass = 'bg-red-100 text-red-700';
                                      $statusText = 'Terlambat';
                                      $statusIcon = 'fas fa-exclamation-triangle';
                                    } else {
                                      $statusClass = 'bg-green-100 text-green-700';
                                      $statusText = 'Dipinjam';
                                      $statusIcon = 'fas fa-check-circle';
                                    }
                                    break;
                                  case 'rejected':
                                    $statusClass = 'bg-red-100 text-red-700';
                                    $statusText = 'Ditolak';
                                    $statusIcon = 'fas fa-times-circle';
                                    break;
                                  case 'returned':
                                    $statusClass = 'bg-blue-100 text-blue-700';
                                    $statusText = 'Dikembalikan';
                                    $statusIcon = 'fas fa-undo';
                                    break;
                                  default:
                                    $statusClass = 'bg-gray-100 text-gray-700';
                                    $statusText = ucfirst($loan['status']);
                                    $statusIcon = 'fas fa-info-circle';
                                }
                              ?>
                              <span class="px-3 py-1 text-xs font-bold rounded-full <?= $statusClass ?>">
                                <i class="<?= $statusIcon ?> mr-1"></i><?= $statusText ?>
                              </span>
                            </td>
                            <td class="p-4 align-middle bg-transparent border-b whitespace-nowrap">
                              <div class="flex justify-center items-center gap-3">
                                <?php if ($loan['status'] === 'pending'): ?>
                                  <!-- Approve Button -->
                                  <form method="POST" action="index.php?page=admin-loans&action=approve" class="inline" onsubmit="return confirm('Setujui peminjaman ini?');">
                                    <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-100 text-green-600 hover:bg-green-200 hover:text-green-800 transition-all" title="Setujui">
                                      <i class="fas fa-check"></i>
                                    </button>
                                  </form>
                                  
                                  <!-- Reject Button with Modal -->
                                  <button type="button" onclick="openRejectModal(<?= $loan['id'] ?>)" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 text-red-500 hover:bg-red-200 hover:text-red-700 transition-all" title="Tolak">
                                    <i class="fas fa-times"></i>
                                  </button>
                                  
                                <?php elseif ($loan['status'] === 'approved' && empty($loan['actual_return_date'])): ?>
                                  <!-- Return Button -->
                                  <form method="POST" action="index.php?page=admin-loans&action=return" class="inline" onsubmit="return confirm('Tandai barang sudah dikembalikan?');">
                                    <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-800 transition-all" title="Dikembalikan">
                                      <i class="fas fa-undo"></i>
                                    </button>
                                  </form>
                                <?php endif; ?>
                                
                                <!-- Delete Button -->
                                <form method="POST" action="index.php?page=admin-loans&action=delete" class="inline" onsubmit="return confirm('Hapus data peminjaman ini?');">
                                  <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                  <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-gray-700 transition-all" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </form>
                              </div>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  <?php else: ?>
                    <div class="text-center py-12">
                      <i class="fas fa-box-open text-5xl text-slate-300 mb-4"></i>
                      <p class="text-slate-400 text-lg">Tidak ada data peminjaman.</p>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </main>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeRejectModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <form method="POST" action="index.php?page=admin-loans&action=reject">
            <input type="hidden" name="loan_id" id="rejectLoanId" value="">
            
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                  <i class="fas fa-times text-red-600"></i>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                  <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                    Tolak Peminjaman
                  </h3>
                  <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                      Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="admin_note" rows="3" required placeholder="Tuliskan alasan penolakan..."
                              class="block w-full px-3 py-2 text-sm text-slate-700 bg-white border border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500"></textarea>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                Tolak
              </button>
              <button type="button" onclick="closeRejectModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Batal
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5" async></script>
    
    <script>
      function openRejectModal(loanId) {
        document.getElementById('rejectLoanId').value = loanId;
        document.getElementById('rejectModal').classList.remove('hidden');
      }
      
      function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectLoanId').value = '';
      }
    </script>
</body>
</html>
