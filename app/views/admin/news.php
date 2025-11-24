<!-- filepath: c:\laragon\www\WebProfilInLET_PBL\app\views\admin\news.php -->
<?php
// Ambil data dari database
require_once __DIR__ . '/../../../config/database.php'; // sesuaikan path

$db = new Database();
$conn = $db->connect();
$stmt = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
$newsList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="/assets/img/favicon.png" />
    <title>Form News Lab - Soft UI Dashboard Tailwind</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <link href="assets/css/soft-ui-dashboard-tailwind.min.css" rel="stylesheet" />
  </head>
  <body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">
    <aside class="max-w-62.5 ease-nav-brand z-990 fixed inset-y-0 my-4 ml-4 block w-full -translate-x-full flex-wrap items-center justify-between overflow-y-auto rounded-2xl border-0 bg-white p-0 antialiased shadow-none transition-transform duration-200 xl:left-0 xl:translate-x-0 xl:bg-transparent">
      <!-- ...sidebar content... -->
      <div class="h-19.5">
        <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="?page=admin-dashboard">
          <img src="/assets/img/logo-ct.png" class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-8" alt="main_logo" />
          <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Soft UI Dashboard</span>
        </a>
      </div>
      <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />
      <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
        <ul class="flex flex-col pl-0 mb-0">
          <li class="mt-0.5 w-full">
            <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors" href="?page=admin-dashboard">
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Dashboard</span>
            </a>
          </li>
          <li class="mt-0.5 w-full">
            <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors" href="?page=gallery">
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Gallery</span>
            </a>
          </li>
          <li class="mt-0.5 w-full">
            <a class="py-2.7 shadow-soft-xl text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg bg-white px-4 font-semibold text-slate-700 transition-colors" href="?page=news">
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">News</span>
            </a>
          </li>
        </ul>
      </div>
    </aside>
    <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
      <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="true">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
          <nav>
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
              <li class="leading-normal text-sm">
                <a class="opacity-50 text-slate-700" href="javascript:;">Pages</a>
              </li>
              <li class="text-sm pl-2 capitalize leading-normal text-slate-700 before:float-left before:pr-2 before:text-gray-600 before:content-['/']" aria-current="page">News</li>
            </ol>
            <h6 class="mb-0 font-bold capitalize">Form News Lab</h6>
          </nav>
        </div>
      </nav>
      <div class="w-full px-6 py-6 mx-auto">
        <!-- Tombol Tambah News -->
        <div class="flex justify-end mb-4">
          <button
            id="addNewsBtn"
            class="bg-gradient-to-tl from-purple-700 to-pink-500 text-white px-4 py-2 rounded-lg font-semibold text-sm hover:scale-102 transition-all"
            onclick="toggleNewsPopover()"
          >
            + Tambah News
          </button>
        </div>
        <!-- Pop Up Form Tambah News -->
        <div
          id="newsPopover"
          class="absolute right-10 top-32 z-50 hidden bg-white rounded-lg shadow-lg p-6 w-full max-w-md"
          style="min-width:300px;"
        >
          <h3 class="text-lg font-bold mb-4">Tambah Artikel / News Lab</h3>
          <form action="../app/views/admin/proses_news.php" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
              <label class="block text-sm font-semibold mb-1">Judul Artikel</label>
              <input type="text" name="judul" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold mb-1">Isi Konten</label>
              <textarea name="konten" rows="5" class="w-full border rounded px-3 py-2" required></textarea>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold mb-1">Upload Thumbnail</label>
              <input type="file" name="thumbnail" accept="image/*" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="flex justify-end">
              <button type="button" class="mr-2 px-4 py-2 rounded bg-gray-300" onclick="toggleNewsPopover()">Batal</button>
              <button type="submit" class="px-4 py-2 rounded bg-purple-700 text-white">Simpan</button>
            </div>
          </form>
        </div>
        <!-- Tabel List News -->
        <div class="overflow-x-auto bg-white rounded-2xl shadow-soft-xl p-6">
          <table class="min-w-full text-slate-700">
          <thead>
            <tr>
              <th class="px-4 py-2 text-center font-bold">Thumbnail</th>
              <th class="px-4 py-2 text-center font-bold">Judul</th>
              <th class="px-4 py-2 text-center font-bold">Published Date</th>
              <th class="px-4 py-2 text-center font-bold">Created At</th>
              <th class="px-4 py-2 text-center font-bold">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($newsList as $news): 
              // safe mapping: use DB column names (title, content, thumbnail, published_date, created_at)
              $thumb = !empty($news['thumbnail']) ? $news['thumbnail'] : '/assets/img/placeholder.png';
              $title = $news['title'] ?? $news['judul'] ?? '';
              $published = $news['published_date'] ?? '';
              $created = $news['created_at'] ?? '';
            ?>
            <tr>
              <td class="px-4 py-2 text-center">
                <img src="<?= htmlspecialchars((string)$thumb) ?>" alt="thumb" class="h-16 w-24 object-cover rounded-lg mx-auto" />
              </td>
              <td class="px-4 py-2 text-center"><?= htmlspecialchars((string)$title) ?></td>
              <td class="px-4 py-2 text-center"><?= htmlspecialchars((string)$published) ?></td>
              <td class="px-4 py-2 text-center"><?= htmlspecialchars((string)$created) ?></td>
              <td class="px-4 py-2 text-center">
                <a href="edit_news.php?id=<?= urlencode($news['id']) ?>" class="text-xs font-semibold text-blue-500 mr-2">Edit</a>
                <a href="delete_news.php?id=<?= urlencode($news['id']) ?>" class="text-xs font-semibold text-red-500" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        </div>
      </div>
      <footer class="pt-4">
        <div class="w-full px-6 mx-auto">
          <div class="flex flex-wrap items-center -mx-3 lg:justify-between">
            <div class="w-full max-w-full px-3 mt-0 mb-6 shrink-0 lg:mb-0 lg:w-1/2 lg:flex-none">
              <div class="leading-normal text-center text-sm text-slate-500 lg:text-left">
                ©
                <script>
                  document.write(new Date().getFullYear() + ",");
                </script>
                made with <i class="fa fa-heart"></i> by
                <a href="https://www.creative-tim.com" class="font-semibold text-slate-700" target="_blank">Creative Tim</a>
                for a better web.
              </div>
            </div>
          </div>
        </div>
      </footer>
    </main>
    <script>
      function toggleNewsPopover() {
        const popover = document.getElementById("newsPopover");
        popover.classList.toggle("hidden");
      }
      document.addEventListener("click", function(e) {
        const btn = document.getElementById("addNewsBtn");
        const popover = document.getElementById("newsPopover");
        if (!popover.contains(e.target) && e.target !== btn) {
          popover.classList.add("hidden");
        }
      });
    </script>
    <script src="/assets/js/plugins/perfect-scrollbar.min.js" async></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="/assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5" async></script>
  </body>
</html>