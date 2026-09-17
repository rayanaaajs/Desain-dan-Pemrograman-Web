async function muatDaftarbuku() {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        await new Promise((resolve) => setTimeout(resolve, 3000));

        const res = await fetch("../data/buku.json")
        if (!res.ok) throw new Error("Gagal mengambil data")
            const daftarBuku = await res.json();
        
        // Looping data JSON dan cetak baris ke tabel
        daftarBuku.forEach(function (buku) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + buku.judul + "</td>" +
                "<td>" + buku.pengarang + "</td>" +
                "<td>" + buku.tahun + "</td>" +
                "<td>" + buku.stok + "</td>" +
                "<td>" + buku.kategori + "</td>" +
                "<td><button type=\"button\">Edit</button> <button type=\"button\" class=\"btn-hapus\">Hapus</button></td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML = "<tr><td colspan=\"5\">Error: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none"; // Sembunyikan loading
    }
}
document.addEventListener("DOMContentLoaded", muatDaftarbuku);

document.addEventListener("DOMContentLoaded", function () {
    // 1. Panggil fungsi satu kali saat halaman pertama kali dibuka
    muatDaftarbuku();

    // 2. Cari tombol muat ulang
    const btnReload = document.getElementById("btn-reload");
    
    // 3. Jika tombolnya ada, pasang event klik untuk menjalankan ulang fungsinya
    if (btnReload) {
        btnReload.addEventListener("click", muatDaftarbuku);
    }
});