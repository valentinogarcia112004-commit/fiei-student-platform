<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = $_POST['category'];
    $subject = $_POST['subject'] ?? '';
    $teacher = $_POST['teacher'] ?? '';
    $semester = $_POST['semester'] ?? '';

    // Validar archivo
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        header("Location: ../upload.html?error=file_required");
        exit;
    }

    $allowed = ['pdf', 'ppt', 'pptx', 'doc', 'docx', 'zip', 'rar'];
    $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        header("Location: ../upload.html?error=invalid_format");
        exit;
    }
    if ($_FILES['file']['size'] > 50 * 1024 * 1024) {
        header("Location: ../upload.html?error=file_too_large");
        exit;
    }

    // Mover archivo a uploads/
    $uploads_dir = '../uploads/';
    if (!is_dir($uploads_dir)) mkdir($uploads_dir, 0755, true);
    $filename = uniqid('file_') . '.' . $ext;
    move_uploaded_file($_FILES['file']['tmp_name'], $uploads_dir . $filename);

    // Insertar información del archivo en BD
    $stmt = $pdo->prepare("INSERT INTO resources (title, description, file_url, category, subject, teacher, semester, uploaded_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, 'uploads/' . $filename, $category, $subject, $teacher, $semester, $_SESSION['user_id']]);

    header("Location: ../resources.php?uploaded=1");
    exit;
}
?>