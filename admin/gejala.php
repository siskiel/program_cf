<h2> Data Gejala</h2>
<a href="index.php?halaman=gejalatambah" class="btn-primary btn">Tambah Gejala</a>
<br>
<br>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Gejala</th>
            <th>Gejala</th>
            <th>Measure Of Belief (MB)</th>
            <th>Measure Of Disbelief(MD)</th>
            <th>Nilai Bobot</th>
            <th>Aksi</th>

        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1; ?>
        <?php $ambil = $koneksi->query("SELECT * FROM gejala ORDER BY kode_gejala ASC"); ?>
        <?php while ($pecah = $ambil->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['kode_gejala']; ?></td>
            <td><?php echo $pecah['nama_gejala']; ?></td>
            <td><?php echo $pecah['MB']; ?></td>
            <td><?php echo $pecah['MD']; ?></td>
            <td><?php echo $pecah['nilai_bobot']; ?></td>
            <td>
                <a href="index.php?halaman=gejalaubah&id=<?php echo $pecah['id_gejala']; ?>" i
                    class="fa fa-clipboard fa-1x btn-primary btn ">Edit</a>
                <a href="index.php?halaman=gejalahapus&id=<?php echo $pecah['id_gejala']; ?>" i
                    class="fa fa-times fa-1x btn-danger btn"
                    onclick="return confirm('Apakah yakin ingin menghapus data gejala?');">Hapus</a>
            </td>
        </tr>
        <?php $nomor++; ?>
        <?php } ?>
    </tbody>
</table>