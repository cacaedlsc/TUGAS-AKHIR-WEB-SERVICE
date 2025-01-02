<?php
// Koneksi ke database
$host = '127.0.0.1';
$username = 'root';
$password = ''; // Sesuaikan dengan password MySQL Anda
$dbname = 'klinik_dokter';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// CRUD untuk tabel janji_temu
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'add':
            $id_pasien = $_POST['id_pasien'];
            $id_dokter = $_POST['id_dokter'];
            $tgl_janji = $_POST['tgl_janji'];
            $waktu_janji = $_POST['waktu_janji'];
            $kategori = $_POST['kategori'];
            $biaya = $_POST['biaya'];
            $nomor_referensi = $_POST['nomor_referensi'];

            $sql = "INSERT INTO janji_temu (id_pasien, id_dokter, tgl_janji, waktu_janji, kategori, biaya, nomor_referensi) VALUES ('$id_pasien', '$id_dokter', '$tgl_janji', '$waktu_janji', '$kategori', '$biaya', '$nomor_referensi')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data berhasil ditambahkan!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
            break;

        case 'edit':
            $id_janji = $_POST['id_janji'];
            $id_pasien = $_POST['id_pasien'];
            $id_dokter = $_POST['id_dokter'];
            $tgl_janji = $_POST['tgl_janji'];
            $waktu_janji = $_POST['waktu_janji'];
            $kategori = $_POST['kategori'];
            $biaya = $_POST['biaya'];
            $nomor_referensi = $_POST['nomor_referensi'];

            $sql = "UPDATE janji_temu SET id_pasien='$id_pasien', id_dokter='$id_dokter', tgl_janji='$tgl_janji', waktu_janji='$waktu_janji', kategori='$kategori', biaya='$biaya', nomor_referensi='$nomor_referensi' WHERE id_janji=$id_janji";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data berhasil diperbarui!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
            break;

        case 'delete':
            $id_janji = $_POST['id_janji'];
            $sql = "DELETE FROM janji_temu WHERE id_janji=$id_janji";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data berhasil dihapus!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
            break;
    }
}

// Menampilkan data janji temu
$result = $conn->query("SELECT * FROM janji_temu");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Janji Temu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #388e3c;
        }
        form {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        form input, form select, form button {
            padding: 10px;
            border: 1px solid #c8e6c9;
            border-radius: 5px;
            font-size: 16px;
        }
        form button {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        form button:hover {
            background-color: #388e3c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #c8e6c9;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #a5d6a7;
            color: #1b5e20;
        }
        table tr:nth-child(even) {
            background-color: #f1f8e9;
        }
        .action-buttons button {
            margin: 5px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .action-buttons .edit {
            background-color: #66bb6a;
            color: white;
        }
        .action-buttons .edit:hover {
            background-color: #388e3c;
        }
        .action-buttons .delete {
            background-color: #ef5350;
            color: white;
        }
        .action-buttons .delete:hover {
            background-color: #d32f2f;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .modal-content button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .modal-content button:hover {
            background-color: #388e3c;
        }
        .modal-content .cancel-button {
            background-color: #ef5350;
            color: white;
        }
        .modal-content .cancel-button:hover {
            background-color: #d32f2f;
        }
        .back-home {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            padding: 8px 12px;
            background-color: #ffeb3b;
            color: #2e7d32;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .back-home:hover {
            background-color: #fbc02d;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px 0;
            background-color: #e8f5e9;
            color: #388e3c;
            font-size: 14px;
        }
    </style>
    <script>
        function openEditModal(id, pasien, dokter, tgl, waktu, kategori, biaya, referensi) {
            document.getElementById('editModal').style.display = 'flex';
            document.getElementById('edit_id_janji').value = id;
            document.getElementById('edit_id_pasien').value = pasien;
            document.getElementById('edit_id_dokter').value = dokter;
            document.getElementById('edit_tgl_janji').value = tgl;
            document.getElementById('edit_waktu_janji').value = waktu;
            document.getElementById('edit_kategori').value = kategori;
            document.getElementById('edit_biaya').value = biaya;
            document.getElementById('edit_nomor_referensi').value = referensi;
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Manajemen Janji Temu</h1>
        <form action="" method="POST">
            <input type="hidden" name="action" value="add">
            <input type="number" name="id_pasien" placeholder="ID Pasien" required>
            <input type="number" name="id_dokter" placeholder="ID Dokter" required>
            <input type="date" name="tgl_janji" placeholder="Tanggal Janji" required>
            <input type="time" name="waktu_janji" placeholder="Waktu Janji" required>
            <input type="text" name="kategori" placeholder="Kategori" required>
            <input type="number" name="biaya" placeholder="Biaya" required>
            <input type="text" name="nomor_referensi" placeholder="Nomor Referensi" required>
            <button type="submit">Tambah</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Pasien</th>
                    <th>ID Dokter</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Kategori</th>
                    <th>Biaya</th>
                    <th>Nomor Referensi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_janji'] ?></td>
                        <td><?= $row['id_pasien'] ?></td>
                        <td><?= $row['id_dokter'] ?></td>
                        <td><?= $row['tgl_janji'] ?></td>
                        <td><?= $row['waktu_janji'] ?></td>
                        <td><?= $row['kategori'] ?></td>
                        <td><?= $row['biaya'] ?></td>
                        <td><?= $row['nomor_referensi'] ?></td>
                        <td class="action-buttons">
                            <button class="edit" onclick="openEditModal('<?= $row['id_janji'] ?>', '<?= $row['id_pasien'] ?>', '<?= $row['id_dokter'] ?>', '<?= $row['tgl_janji'] ?>', '<?= $row['waktu_janji'] ?>', '<?= $row['kategori'] ?>', '<?= $row['biaya'] ?>', '<?= $row['nomor_referensi'] ?>')">Ubah</button>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id_janji" value="<?= $row['id_janji'] ?>">
                                <button type="submit" class="delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="home.html" class="back-home">Home</a>
    </div>
    <footer>
        Copyright by Salsa E
    </footer>

    <div id="editModal" class="modal" style="display:none; justify-content:center; align-items:center;">
        <div class="modal-content">
            <form action="" method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id_janji" id="edit_id_janji">
                <input type="number" name="id_pasien" id="edit_id_pasien" placeholder="ID Pasien" required>
                <input type="number" name="id_dokter" id="edit_id_dokter" placeholder="ID Dokter" required>
                <input type="date" name="tgl_janji" id="edit_tgl_janji" required>
                <input type="time" name="waktu_janji" id="edit_waktu_janji" required>
                <input type="text" name="kategori" id="edit_kategori" placeholder="Kategori" required>
                <input type="number" name="biaya" id="edit_biaya" placeholder="Biaya" required>
                <input type="text" name="nomor_referensi" id="edit_nomor_referensi" placeholder="Nomor Referensi" required>
                <button type="submit">Simpan</button>
                <button type="button" class="cancel-button" onclick="closeModal()">Batal</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
