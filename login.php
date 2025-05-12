<?php
session_start();
require '../includes/firebase_auth.php';

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        $signInResult = $auth->signInWithEmailAndPassword($email, $password);
        $_SESSION["admin_logged_in"] = true;
        $_SESSION["admin_email"] = $email;
        header("Location: dashboard.php");
        exit();
    } catch (\Throwable $e) {
        $errorMessage = "❌ Login failed! " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LGS Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            background: white;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            margin-bottom: 30px;
            font-weight: bold;
        }
        .form-control:focus {
            border-color: #2575fc;
            box-shadow: 0 0 0 0.2rem rgba(37, 117, 252, 0.25);
        }
        .input-group-text {
            background-color: #f0f0f0;
            border-right: none;
        }
    </style>
</head>
<body>

    <div class="login-container text-center">
        <div class="mb-4">
            <i class="bi bi-shield-lock-fill fs-1 text-primary"></i>
        </div>
        <h2>LGS ADMIN</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger text-start"><?= $errorMessage; ?></div>
        <?php endif; ?>

        <form method="post" action="login.php" class="text-start">
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
        </form>
    </div>

</body>
</html>
