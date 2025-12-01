<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lengkapi Profil Wajib</title>
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    
    <link href="assets/css/soft-ui-dashboard-tailwind.min.css" rel="stylesheet" /> 
</head>

<body class="m-0 font-sans antialiased font-normal text-base leading-default text-slate-500">
    
    <div class="flex items-center justify-center min-h-screen p-4 bg-gradient-to-br from-purple-900 via-purple-700 to-purple-600">
        
        <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-2xl border border-purple-200"> 
            
            <div class="text-center mb-6">
                <h3 class="font-bold text-transparent bg-gradient-to-tl from-red-600 to-red-400 bg-clip-text text-3xl">
                    Lengkapi Profil Wajib
                </h3>
                <p class="mb-0 text-slate-500">Mohon isi data di bawah ini untuk melanjutkan.</p>
            </div>

            <?php 
            if (!empty($error_message)): 
            ?>
                <div class="p-3 mb-4 text-sm text-white bg-red-500 rounded-lg shadow-soft-md" role="alert">
                    <i class="fas fa-times-circle mr-2"></i> <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <form role="form" action="" method="POST">
                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">NIM (Wajib)</label>
                <div class="mb-4">
                    <input type="text" id="nim" name="nim" required class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Nomor Induk Mahasiswa" value="<?= htmlspecialchars($data_mahasiswa_input['nim'] ?? '') ?>" />
                </div>

                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Tahun Masuk (Angkatan)</label>
<div class="mb-4">
    <input 
        type="number" 
        id="batch" 
        name="batch"  required 
        min="2000" 
        max="<?= date('Y') ?>" 
        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" 
        placeholder="Contoh: 2024" 
        value="<?= htmlspecialchars($data_mahasiswa_input['batch'] ?? '') ?>" 
    />
</div>

                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Program Studi</label>
                <div class="mb-4">
                    <select id="program_study" name="program_study" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                        <?php $selected_prodi = $data_mahasiswa_input['program_study'] ?? ''; ?>
                        <option value="Teknik Informatika" <?= $selected_prodi == 'Teknik Informatika' ? 'selected' : '' ?>>Teknik Informatika</option>
                        <option value="Sistem Informasi" <?= $selected_prodi == 'Sistem Informasi' ? 'selected' : '' ?>>Sistem Informasi</option>
                        <option value="Komputer Akuntansi" <?= $selected_prodi == 'Komputer Akuntansi' ? 'selected' : '' ?>>Komputer Akuntansi</option>
                        <option value="Lainnya" <?= $selected_prodi == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>

                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Tipe Aktivitas di Lab</label>
                <div class="mb-4">
                    <select id="activity_type" name="activity_type" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                        <?php $selected_activity = $data_mahasiswa_input['activity_type'] ?? 'Mahasiswa'; ?>
                        <option value="Mahasiswa" <?= $selected_activity == 'Mahasiswa' ? 'selected' : '' ?>>Mahasiswa Reguler</option>
                        <option value="Asisten Lab" <?= $selected_activity == 'Asisten Lab' ? 'selected' : '' ?>>Asisten Lab</option>
                        <option value="Penelitian" <?= $selected_activity == 'Penelitian' ? 'selected' : '' ?>>Penelitian/Skripsi</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="inline-block w-full px-6 py-3 mt-4 mb-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 hover:scale-102 hover:shadow-soft-xs leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-green-600 to-lime-400">
                        Simpan & Lanjutkan
                    </button>
                </div>
            </form>
        </div>

    </div>
</body>
</html>