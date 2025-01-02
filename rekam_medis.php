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

// CRUD untuk tabel rekam_medis
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'add':
            $id_pasien = $_POST['id_pasien'];
            $id_dokter = $_POST['id_dokter'];
            $diagnosis = $_POST['diagnosis'];
            $tindakan = $_POST['tindakan'];
            $tanggal = $_POST['tanggal'];

            $sql = "INSERT INTO rekam_medis (id_pasien, id_dokter, diagnosis, tindakan, tanggal) 
                    VALUES ('$id_pasien', '$id_dokter', '$diagnosis', '$tindakan', '$tanggal')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data berhasil ditambahkan!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
            break;

        case 'edit':
            $id_rekam_medis = $_POST['id_rekam_medis'];
            $id_pasien = $_POST['id_pasien'];
            $id_dokter = $_POST['id_dokter'];
            $diagnosis = $_POST['diagnosis'];
            $tindakan = $_POST['tindakan'];
            $tanggal = $_POST['tanggal'];

            $sql = "UPDATE rekam_medis 
                    SET id_pasien='$id_pasien', id_dokter='$id_dokter', diagnosis='$diagnosis', tindakan='$tindakan', tanggal='$tanggal' 
                    WHERE id_rekam_medis=$id_rekam_medis";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data berhasil diperbarui!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
            break;

        case 'delete':
            $id_rekam_medis = $_POST['id_rekam_medis'];
            $sql = "DELETE FROM rekam_medis WHERE id_rekam_medis=$id_rekam_medis";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Data berhasil dihapus!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
            break;
    }
}

// Menampilkan data rekam_medis
$result = $conn->query("SELECT * FROM rekam_medis");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pasien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        .container {
            width: 900px;
            margin: 50px auto;
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
        function openEditModal(id, pasien, dokter, diagnosis, tindakan, tanggal) {
            document.getElementById('editModal').style.display = 'flex';
            document.getElementById('edit_id_rekam_medis').value = id;
            document.getElementById('edit_id_pasien').value = pasien;
            document.getElementById('edit_id_dokter').value = dokter;
            document.getElementById('edit_diagnosis').value = diagnosis;
            document.getElementById('edit_tindakan').value = tindakan;
            document.getElementById('edit_tanggal').value = tanggal;
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Manajemen Rekam Medis</h1>
        <form action="" method="POST">
            <input type="hidden" name="action" value="add">
            <input type="number" name="id_pasien" placeholder="ID Pasien" required>
            <input type="number" name="id_dokter" placeholder="ID Dokter" required>
            <input type="text" name="diagnosis" placeholder="Diagnosis" required>
            <input type="text" name="tindakan" placeholder="Tindakan" required>
            <input type="date" name="tanggal" placeholder="Tanggal" required>
            <button type="submit">Tambah</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Pasien</th>
                    <th>ID Dokter</th>
                    <th>Diagnosis</th>
                    <th>Tindakan</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_rekam_medis'] ?></td>
                        <td><?= $row['id_pasien'] ?></td>
                        <td><?= $row['id_dokter'] ?></td>
                        <td><?= $row['diagnosis'] ?></td>
                        <td><?= $row['tindakan'] ?></td>
                        <td><?= $row['tanggal'] ?></td>
                        <td class="action-buttons">
                            <button class="edit" onclick="openEditModal('<?= $row['id_rekam_medis'] ?>', '<?= $row['id_pasien'] ?>', '<?= $row['id_dokter'] ?>', '<?= $row['diagnosis'] ?>', '<?= $row['tindakan'] ?>', '<?= $row['tanggal'] ?>')">Ubah</button>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id_rekam_medis" value="<?= $row['id_rekam_medis'] ?>">
                                <button type="submit" class="delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="home.html" class="back-home">Home</a>
    </div>

    <div id="editModal" class="modal" style="display:none; justify-content:center; align-items:center;">
        <div class="modal-content">
            <form action="" method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id_rekam_medis" id="edit_id_rekam_medis">
                <input type="number" name="id_pasien" id="edit_id_pasien" placeholder="ID Pasien" required>
                <input type="number" name="id_dokter" id="edit_id_dokter" placeholder="ID Dokter" required>
                <input type="text" name="diagnosis" id="edit_diagnosis" placeholder="Diagnosis" required>
                <input type="text" name="tindakan" id="edit_tindakan" placeholder="Tindakan" required>
                <input type="date" name="tanggal" id="edit_tanggal" required>
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
