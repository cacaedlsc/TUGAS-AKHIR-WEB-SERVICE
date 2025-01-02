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

// CRUD untuk tabel jadwal_dokter
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'add':
            $id_dokter = $_POST['id_dokter'];
            $hari = $_POST['hari'];
            $jam_mulai = $_POST['jam_mulai'];
            $jam_selesai = $_POST['jam_selesai'];

            $sql = "INSERT INTO jadwal_dokter (id_dokter, hari, jam_mulai, jam_selesai) VALUES ('$id_dokter', '$hari', '$jam_mulai', '$jam_selesai')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data berhasil ditambahkan!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
            break;

        case 'edit':
            $id_jadwal = $_POST['id_jadwal'];
            $id_dokter = $_POST['id_dokter'];
            $hari = $_POST['hari'];
            $jam_mulai = $_POST['jam_mulai'];
            $jam_selesai = $_POST['jam_selesai'];

            $sql = "UPDATE jadwal_dokter SET id_dokter='$id_dokter', hari='$hari', jam_mulai='$jam_mulai', jam_selesai='$jam_selesai' WHERE id_jadwal=$id_jadwal";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data berhasil diperbarui!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
            break;

        case 'delete':
            $id_jadwal = $_POST['id_jadwal'];
            $sql = "DELETE FROM jadwal_dokter WHERE id_jadwal=$id_jadwal";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data berhasil dihapus!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
            break;
    }
}

// Menampilkan data jadwal_dokter
$result = $conn->query("SELECT * FROM jadwal_dokter");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Jadwal Dokter</title>
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
    function openEditModal(id, dokter, hari, mulai, selesai) {
        document.getElementById('editModal').style.display = 'flex';
        document.getElementById('edit_id_jadwal').value = id;
        document.getElementById('edit_id_dokter').value = dokter;
        document.getElementById('edit_hari').value = hari;
        document.getElementById('edit_jam_mulai').value = mulai;
        document.getElementById('edit_jam_selesai').value = selesai;
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>
</head>
<body>
    <div class="container">
        <h1>Manajemen Jadwal Dokter</h1>
        <form action="" method="POST">
            <input type="hidden" name="action" value="add">
            <input type="number" name="id_dokter" 
            placeholder="ID Dokter" required>
            <select name="hari" required>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
                <option value="Minggu">Minggu</option>
            </select>
            <input type="time" name="jam_mulai" placeholder="Jam Mulai" required>
            <input type="time" name="jam_selesai" placeholder="Jam Selesai" required>
            <button type="submit">Tambah</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID Jadwal</th>
                    <th>ID Dokter</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_jadwal'] ?></td>
                        <td><?= $row['id_dokter'] ?></td>
                        <td><?= $row['hari'] ?></td>
                        <td><?= $row['jam_mulai'] ?></td>
                        <td><?= $row['jam_selesai'] ?></td>
                        <td class="action-buttons">
                            <button class="edit" onclick="openEditModal('<?= $row['id_jadwal'] ?>', '<?= $row['id_dokter'] ?>', '<?= $row['hari'] ?>', '<?= $row['jam_mulai'] ?>', '<?= $row['jam_selesai'] ?>')">Ubah</button>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id_jadwal" value="<?= $row['id_jadwal'] ?>">
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
                <input type="hidden" name="id_jadwal" id="edit_id_jadwal">
                <input type="number" name="id_dokter" id="edit_id_dokter" placeholder="ID Dokter" required>
                <select name="hari" id="edit_hari" required>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                    <option value="Minggu">Minggu</option>
                </select>
                <input type="time" name="jam_mulai" id="edit_jam_mulai" required>
                <input type="time" name="jam_selesai" id="edit_jam_selesai" required>
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
