<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../../config/koneksi.php';

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header('Location:  ../dashboard.php');  // Kembali satu level ke 'admin' dan menuju 'dashboard.php'
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = md5($_POST['password']); // Menggunakan MD5 untuk password

    // Debug input values
    error_log("Username Input: " . $username);
    error_log("Password Hash: " . $password);

    $query = "SELECT id_user, username, level, password
FROM tbl_user
WHERE username = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        die("Query gagal diproses: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $execute_result = $stmt->execute();

    if (!$execute_result) {
        error_log("Execute failed: " . $stmt->error);
        die("Execute failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Debug database values
        error_log("DB Username: " . $user['username']);
        error_log("DB Password: " . $user['password']);

        // Membandingkan password yang di-hash dengan yang ada di database
        if ($user['password'] === $password) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['level'] = $user['level'];

            // Debug session
            error_log("Session set - Username: " . $_SESSION['username']);
            error_log("Session set - Level: " . $_SESSION['level']);

            header('Location: ../dashboard.php');
            exit;
        } else {
            error_log("Password mismatch!");
            error_log("Input (hashed): " . $password);
            error_log("DB Password: " . $user['password']);
            $error = 'Password salah';
        }
    } else {
        error_log("No user found with username: " . $username);
        $error = 'Username tidak ditemukan';
    }

    $stmt->close();
}

// Test koneksi database
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PES-Kisni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .demo-credentials {
            margin-top: 20px;
            text-align: center;
            padding: 15px;
            background-color: #e3f2fd;
            border: 2px dashed #1a1a1a;
            border-radius: 10px;
        }

        .demo-credentials p {
            color: #1a1a1a;
            font-size: 15px;
            margin: 0;
            padding: 3px 0;
        }

        .demo-credentials .highlight {
            font-weight: bold;
            color: #1a1a1a;
        }

        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            margin: 20px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            transition: all 0.3s ease;
            border-color: #1a1a1a;
            /* Mengubah warna border */
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.15);
            /* Mengubah warna focus */
            border-color: #1a1a1a;
            transform: translateY(-2px);
        }

        .btn-primary {
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            background-color: #1a1a1a;
            /* Mengubah warna background button */
            border-color: #1a1a1a;
            /* Mengubah border button */
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 26, 26, 0.3);
            /* Mengubah efek hover button */
            background-color: #1a1a1a;
            /* Mengubah warna hover */
            border-color: #1a1a1a;
        }


        .alert {
            border-radius: 8px;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        @media (max-width: 576px) {
            .login-container {
                margin: 20px 30px;
            }

            .card {
                border-radius: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="card">
            <div class="card-body p-4">
                <h2 class="text-center mb-4">Login PES-Kisni</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="demo-credentials">
                    <p>Demo Account:</p>
                    <p><span class="highlight">Username:</span> admin</p>
                    <p><span class="highlight">Password:</span> admin</p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>