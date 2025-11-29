    // Ambil elemen tombol dan elemen section tersembunyi
    const toggleBtn = document.getElementById('toggleNewsBtn');
    const moreNewsSection = document.getElementById('moreNewsSection');
    const icon = toggleBtn.querySelector('i');

    // Tambahkan event listener saat diklik
    toggleBtn.addEventListener('click', function(e) {
        e.preventDefault(); // Mencegah layar melompat ke atas
        
        // Cek apakah sedang tersembunyi atau tampil
        if (moreNewsSection.style.display === "none") {
            // TAMPILKAN
            moreNewsSection.style.display = "block";
            // Ubah ikon panah jadi ke atas
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            // SEMBUNYIKAN
            moreNewsSection.style.display = "none";
            // Ubah ikon panah jadi ke bawah lagi
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    });