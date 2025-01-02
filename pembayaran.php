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

// CRUD untuk tabel pembayaran
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'add':
            $id_pasien = isset($_POST['id_pasien']) ? $_POST['id_pasien'] : null;
            $id_janji = isset($_POST['id_janji']) ? $_POST['id_janji'] : null;
            $tanggal_pembayaran = isset($_POST['tanggal_pembayaran']) ? $_POST['tanggal_pembayaran'] : null;
            $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : null;
            $metode_pembayaran = isset($_POST['metode_pembayaran']) ? $_POST['metode_pembayaran'] : null;

            if ($id_pasien && $id_janji && $tanggal_pembayaran && $jumlah && $metode_pembayaran) {
                $sql = "INSERT INTO pembayaran (id_pasien, id_janji, tanggal_pembayaran, jumlah, metode_pembayaran) 
                        VALUES ('$id_pasien', '$id_janji', '$tanggal_pembayaran', '$jumlah', '$metode_pembayaran')";
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Data berhasil ditambahkan!');</script>";
                } else {
                    echo "<script>alert('Error: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Harap isi semua field.');</script>";
            }
            break;

        case 'edit':
            $id_pembayaran = isset($_POST['id_pembayaran']) ? $_POST['id_pembayaran'] : null;
            $id_pasien = isset($_POST['id_pasien']) ? $_POST['id_pasien'] : null;
            $id_janji = isset($_POST['id_janji']) ? $_POST['id_janji'] : null;
            $tanggal_pembayaran = isset($_POST['tanggal_pembayaran']) ? $_POST['tanggal_pembayaran'] : null;
            $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : null;
            $metode_pembayaran = isset($_POST['metode_pembayaran']) ? $_POST['metode_pembayaran'] : null;

            if ($id_pembayaran && $id_pasien && $id_janji && $tanggal_pembayaran && $jumlah && $metode_pembayaran) {
                $sql = "UPDATE pembayaran 
                        SET id_pasien='$id_pasien', id_janji='$id_janji', tanggal_pembayaran='$tanggal_pembayaran', jumlah='$jumlah', metode_pembayaran='$metode_pembayaran' 
                        WHERE id_pembayaran=$id_pembayaran";
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Data berhasil diperbarui!');</script>";
                } else {
                    echo "<script>alert('Error: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Harap isi semua field.');</script>";
            }
            break;

        case 'delete':
            $id_pembayaran = isset($_POST['id_pembayaran']) ? $_POST['id_pembayaran'] : null;

            if ($id_pembayaran) {
                $sql = "DELETE FROM pembayaran WHERE id_pembayaran=$id_pembayaran";
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Data berhasil dihapus!');</script>";
                } else {
                    echo "<script>alert('Error: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('ID Pembayaran tidak ditemukan.');</script>";
            }
            break;
    }
}


// Menampilkan data pembayaran
$result = $conn->query("SELECT * FROM pembayaran");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pembayaran</title>
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
    function openEditModal(id, pasien, janji, tanggal, jumlah, metode) {
        document.getElementById('editModal').style.display = 'flex';
        document.getElementById('edit_id_pembayaran').value = id;
        document.getElementById('edit_id_pasien').value = pasien;
        document.getElementById('edit_id_janji').value = janji;
        document.getElementById('edit_tanggal_pembayaran').value = tanggal;
        document.getElementById('edit_jumlah').value = jumlah;
        document.getElementById('edit_metode_pembayaran').value = metode;
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>
</head>
<body>
    <div class="container">
        <h1>Manajemen Pembayaran</h1>
        <form action="" method="POST">
            <input type="hidden" name="action" value="add">
            <input type="number" name="id_pasien" placeholder="ID Pasien" required>
            <input type="number" name="id_janji" placeholder="ID Janji" required>
            <input type="date" name="tanggal_pembayaran" placeholder="Tanggal Pembayaran" required>
            <input type="number" name="jumlah" placeholder="Jumlah Pembayaran" required>
            <input type="text" name="metode_pembayaran" placeholder="Metode Pembayaran" required>
            <button type="submit">Tambah</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID Pembayaran</th>
                    <th>ID Pasien</th>
                    <th>ID Janji</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Jumlah</th>
                    <th>Metode Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_pembayaran'] ?></td>
                        <td><?= $row['id_pasien'] ?></td>
                        <td><?= $row['id_janji'] ?></td>
                        <td><?= $row['tanggal_pembayaran'] ?></td>
                        <td><?= $row['jumlah'] ?></td>
                        <td><?= $row['metode_pembayaran'] ?></td>
                        <td class="action-buttons">
                            <button class="edit" onclick="openEditModal('<?= $row['id_pembayaran'] ?>', '<?= $row['id_pasien'] ?>', '<?= $row['id_janji'] ?>', '<?= $row['tanggal_pembayaran'] ?>', '<?= $row['jumlah'] ?>', '<?= $row['metode_pembayaran'] ?>')">Ubah</button>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id_pembayaran" value="<?= $row['id_pembayaran'] ?>">
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
                <input type="hidden" name="id_pembayaran" id="edit_id_pembayaran">
                <input type="number" name="id_pasien" id="edit_id_pasien" placeholder="ID Pasien" required>
                <input type="number" name="id_janji" id="edit_id_janji" placeholder="ID Janji" required>
                <input type="date" name="tanggal_pembayaran" id="edit_tanggal_pembayaran" required>
                <input type="number" name="jumlah" id="edit_jumlah" placeholder="Jumlah Pembayaran" required>
                <input type="text" name="metode_pembayaran" id="edit_metode_pembayaran" placeholder="Metode Pembayaran" required>
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
