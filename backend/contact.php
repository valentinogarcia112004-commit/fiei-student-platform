<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = $_POST['subject'] ?? '';
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        header("Location: ../contact.html?error=empty_fields");
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $subject, $message]);

    header("Location: ../contact.html?sent=1");
    exit;
}
?>