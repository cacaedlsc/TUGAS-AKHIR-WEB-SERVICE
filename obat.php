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

// CRUD untuk tabel obat
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'add':
            $nama_obat = $_POST['nama_obat'];
            $jenis_obat = $_POST['jenis_obat'];
            $stok = $_POST['stok'];
            $harga = $_POST['harga'];

            $sql = "INSERT INTO obat (nama_obat, jenis_obat, stok, harga) VALUES ('$nama_obat', '$jenis_obat', '$stok', '$harga')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data berhasil ditambahkan!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
            break;

        case 'edit':
            $id_obat = $_POST['id_obat'];
            $nama_obat = $_POST['nama_obat'];
            $jenis_obat = $_POST['jenis_obat'];
            $stok = $_POST['stok'];
            $harga = $_POST['harga'];

            $sql = "UPDATE obat SET nama_obat='$nama_obat', jenis_obat='$jenis_obat', stok='$stok', harga='$harga' WHERE id_obat=$id_obat";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data berhasil diperbarui!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
            break;

        case 'delete':
            $id_obat = $_POST['id_obat'];
            $sql = "DELETE FROM obat WHERE id_obat=$id_obat";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data berhasil dihapus!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
            break;
    }
}

// Menampilkan data jadwal_dokter
$result = $conn->query("SELECT * FROM obat");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Obat</title>
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
    function openEditModal(id, nama, jenis, stok, harga) {
        document.getElementById('editModal').style.display = 'flex';
        document.getElementById('edit_id_obat').value = id;
        document.getElementById('edit_nama_obat').value = nama;
        document.getElementById('edit_jenis_obat').value = jenis;
        document.getElementById('edit_stok').value = stok;
        document.getElementById('edit_harga').value = harga;
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>
</head>
<body>
    <div class="container">
        <h1>Manajemen Obat</h1>
        <form action="" method="POST">
            <input type="hidden" name="action" value="add">
            <input type="text" name="nama_obat" placeholder="Nama Obat" required>
            <input type="text" name="jenis_obat" placeholder="Jenis Obat" required>
            <input type="number" name="stok" placeholder="Stok" required>
            <input type="number" name="harga" placeholder="Harga" required>
            <button type="submit">Tambah</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID Obat</th>
                    <th>Nama Obat</th>
                    <th>Jenis Obat</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_obat'] ?></td>
                        <td><?= $row['nama_obat'] ?></td>
                        <td><?= $row['jenis_obat'] ?></td>
                        <td><?= $row['stok'] ?></td>
                        <td><?= $row['harga'] ?></td>
                        <td class="action-buttons">
                            <button class="edit" onclick="openEditModal('<?= $row['id_obat'] ?>', '<?= $row['nama_obat'] ?>', '<?= $row['jenis_obat'] ?>', '<?= $row['stok'] ?>', '<?= $row['harga'] ?>')">Ubah</button>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id_obat" value="<?= $row['id_obat'] ?>">
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
                <input type="hidden" name="id_obat" id="edit_id_obat">
                <input type="text" name="nama_obat" id="edit_nama_obat" placeholder="Nama Obat" required>
                <input type="text" name="jenis_obat" id="edit_jenis_obat" placeholder="Jenis Obat" required>
                <input type="number" name="stok" id="edit_stok" placeholder="Stok" required>
                <input type="number" name="harga" id="edit_harga" placeholder="Harga" required>
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
