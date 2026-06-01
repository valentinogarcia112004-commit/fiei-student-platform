<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['fullName']);
    $email = trim($_POST['email']);
    $career = $_POST['career'];
    $password = $_POST['password'];
    $confirm = $_POST['confirmPassword'];

    // Validaciones básicas (también las tienes en JS, aquí las repetimos por seguridad)
    if (empty($full_name) || empty($email) || empty($career) || empty($password)) {
        header("Location: ../register.html?error=empty_fields");
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !strpos($email, 'universidad.edu')) {
        header("Location: ../register.html?error=invalid_email");
        exit;
    }
    if (strlen($password) < 8 || $password !== $confirm) {
        header("Location: ../register.html?error=password_mismatch");
        exit;
    }

    // Verificar si el correo ya existe
    $stmt = $pdo->prepare("SELECT id_user FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        header("Location: ../register.html?error=email_exists");
        exit;
    }

    // Insertar usuario
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, career) VALUES (?, ?, ?, ?)");
    $stmt->execute([$full_name, $email, $hashed, $career]);

    header("Location: ../login.html?registered=1");
    exit;
}
?>