<?php
// Cek session agar bisa menangkap pesan error
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="assets/img/logo.jpg" />
  <title>Lab Inlet - Sign Up</title>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />

  <link href="assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5" rel="stylesheet" />
</head>

<body class="m-0 font-sans antialiased font-normal bg-white text-start text-base leading-default text-slate-500">

  <main class="mt-0 transition-all duration-200 ease-soft-in-out">
    <section>
      <div class="relative flex items-center p-0 overflow-hidden bg-center bg-cover min-h-75-screen">
         <div class="absolute top-0 left-0 z-50 m-6">
            <img src="assets/img/logo.jpg" alt="Logo" class="h-16 w-auto object-contain" />
          </div>
        <div class="container z-10">
          <div class="flex flex-wrap mt-0 -mx-3">
            <div class="flex flex-col w-full max-w-full px-3 mx-auto md:flex-0 shrink-0 md:w-6/12 lg:w-5/12 xl:w-4/12">
              <div class="relative flex flex-col min-w-0 mt-32 break-words bg-transparent border-0 shadow-none rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-transparent border-b-0 rounded-t-2xl">
                  <h3 class="relative z-10 font-bold text-transparent bg-gradient-to-tl from-blue-600 to-cyan-400 bg-clip-text">
                    Create an account</h3>
                  <p class="mb-0">Enter your details to sign up</p>
                </div>
                <div class="flex-auto p-6">
                  
                  <?php if (isset($_SESSION['error'])): ?>
                      <div class="p-4 mb-4 text-sm text-red bg-red-500 rounded-lg" role="alert">
                          <span class="font-bold">Error!</span> <?= $_SESSION['error']; ?>
                      </div>
                      <?php unset($_SESSION['error']); ?>
                  <?php endif; ?>
                  
                  <form role="form" method="POST" action="index.php?action=register">

                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Full Name</label>
                    <div class="mb-4">
                      <input type="text" name="full_name" required
                        class="focus:shadow-soft-primary-outline text-sm block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none"
                        placeholder="Your Name" />
                    </div>

                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Username</label>
                    <div class="mb-4">
                      <input type="text" name="username" required
                        class="focus:shadow-soft-primary-outline text-sm block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none"
                        placeholder="Username" />
                    </div>
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Email</label>
                    <div class="mb-4">
                      <input type="email" name="email" required
                        class="focus:shadow-soft-primary-outline text-sm block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none"
                        placeholder="Email" />
                    </div>

                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Password</label>
                    <div class="mb-4">
                      <input type="password" name="password" required
                        class="focus:shadow-soft-primary-outline text-sm block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none"
                        placeholder="Password" />
                    </div>

                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Confirm Password</label>
                    <div class="mb-4">
                      <input type="password" name="confirm_password" required
                        class="focus:shadow-soft-primary-outline text-sm block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none"
                        placeholder="Confirm Password" />
                    </div>

                    <div class="text-center">
                      <button type="submit"
                        class="inline-block w-full px-6 py-3 mt-6 mb-0 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102 hover:shadow-soft-xs active:opacity-85">
                        Sign Up
                      </button>
                    </div>

                  </form>
                </div>

                <div class="p-6 px-1 pt-0 text-center bg-transparent border-t-0 border-t-solid rounded-b-2xl lg:px-2">
                  <p class="mx-auto mb-6 leading-normal text-sm">
                    Already have an account?
                    <a href="index.php?page=login"
                      class="relative z-10 font-semibold text-transparent bg-gradient-to-tl from-blue-600 to-cyan-400 bg-clip-text">
                      Sign in
                    </a>
                  </p>
                </div>

              </div>
            </div>

            <div class="w-full max-w-full px-3 lg:flex-0 shrink-0 md:w-6/12">
              <div
                class="absolute top-0 hidden w-3/5 h-full -mr-32 overflow-hidden -skew-x-10 -right-40 rounded-bl-xl md:block">
                <div class="absolute inset-x-0 top-0 z-0 h-full -ml-16 bg-cover skew-x-10"
                    style="background-image: url('assets/img/curved-images/fotobersama.jpg')">
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="py-12">
    <div class="container">
      <div class="flex flex-wrap -mx-3">
        <div class="w-8/12 max-w-full px-3 mx-auto mt-1 text-center flex-0">
          <p class="mb-0 text-slate-400">
            Copyright ©
            <script>document.write(new Date().getFullYear());</script>
            Soft by Team Inlet.
          </p>
        </div>
      </div>
    </div>
  </footer>

  <script src="assets/js/plugins/perfect-scrollbar.min.js" async></script>
  <script src="assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5" async></script>

</body>

</html>