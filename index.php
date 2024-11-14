<?php
// Koneksi ke Database
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "todolist_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['add'])) {
    $task = $_POST['task'];
    $sql = "INSERT INTO todos (task) VALUES ('$task')";
    $conn->query($sql);
    header("Location: index.php");
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $task = $_POST['task'];
    $sql = "UPDATE todos SET task='$task' WHERE id=$id";
    $conn->query($sql);
    header("Location: index.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM todos WHERE id=$id";
    $conn->query($sql);
    header("Location: index.php");
}

$sql = "SELECT * FROM todos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List - Persona</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ff7e5f 0%, #feb47b 100%);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 600px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }
        .task-list-item {
            transition: background 0.3s;
        }
        .task-list-item:hover {
            background: #f5f5f5;
        }
        .btn-primary {
            background-color: #ff7e5f;
            border: none;
        }
        .btn-primary:hover {
            background-color: #feb47b;
        }
        .btn-warning, .btn-danger {
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4" style="color: #ff7e5f;">To-Do List</h2>

    <div class="mb-4">
        <form method="POST" action="" class="input-group">
            <input type="text" name="task" placeholder="Tambahkan kegiatan baru" class="form-control" required>
            <button type="submit" name="add" class="btn btn-primary">Tambah</button>
        </form>
    </div>

    <ul class="list-group">
        <?php while ($row = $result->fetch_assoc()): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center task-list-item">
                <span><?= htmlspecialchars($row['task']) ?></span>
                <div>
                    <!-- Form Edit -->
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="text" name="task" value="<?= htmlspecialchars($row['task']) ?>" class="form-control form-control-sm d-inline me-2" style="width: auto;" required>
                        <button type="submit" name="edit" class="btn btn-warning btn-sm">Edit</button>
                    </form>
                    <!-- Tombol Hapus -->
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm ms-2">Hapus</a>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
