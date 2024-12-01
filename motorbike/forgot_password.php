<?php
session_start();
include_once 'connect.php'; // Kết nối cơ sở dữ liệu

$conn = new Connect();
$db_link = $conn->connectToPDO(); 

if (isset($_POST['btnSubmitEmail'])) {
    $email = $_POST['txtEmail'];
    $err = "";

    // Kiểm tra email có trong database không
    $sql = "SELECT * FROM customer WHERE email = ?";
    $stmt = $db_link->prepare($sql);
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        // Email hợp lệ, chuyển sang bước nhập mật khẩu mới
        $_SESSION['reset_email'] = $email;
        $_SESSION['step'] = 'new_password';
    } else {
        $err = "Email does not exist in the system.";
    }
}

// Kiểm tra nếu bước hiện tại là nhập mật khẩu mới
if (isset($_POST['btnSavePassword']) && isset($_SESSION['step']) && $_SESSION['step'] == 'new_password') {
    $pass1 = $_POST['txtNewPass'];
    $pass2 = $_POST['txtConfirmPass'];
    $err = "";

    // Kiểm tra mật khẩu
    if (strlen($pass1) <= 5) {
        $err .= "Password must be longer than 5 characters. ";
    }
    if ($pass1 != $pass2) {
        $err .= "Password and confirm password do not match. ";
    }

    if ($err == "") {
        // Mật khẩu hợp lệ, tiến hành cập nhật
        $hashed_pass = password_hash($pass1, PASSWORD_BCRYPT);
        $email = $_SESSION['reset_email'];

        $sql = "UPDATE customer SET pass = ? WHERE email = ?";
        $stmt = $db_link->prepare($sql);
        if ($stmt->execute([$hashed_pass, $email])) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Password changed successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            window.location.href='loginnew.php';
                        });
                    });
                  </script>";
            unset($_SESSION['reset_email']);
            unset($_SESSION['step']);
            session_destroy();
        } else {
            $err = "An error occurred. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Thêm SweetAlert2 -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 500px;
            margin-top: 100px;
        }
        .card {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h2 class="text-center">Forgot Password</h2>

        <?php if (isset($err) && $err != "") { ?>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: '<?php echo $err; ?>',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            </script>

        <?php } ?>

        <!-- Bước 1: Nhập email -->
        <?php if (!isset($_SESSION['step']) || $_SESSION['step'] != 'new_password') { ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="txtEmail">Enter your email:</label>
                    <input type="email" name="txtEmail" id="txtEmail" class="form-control" required>
                </div>
                <button type="submit" name="btnSubmitEmail" class="btn btn-primary btn-block">Send</button>
                <a href="loginnew.php" class="btn btn-success btn-block"> Back To Login Page</a>
            </form>

        <!-- Bước 2: Nhập mật khẩu mới -->
        <?php } elseif ($_SESSION['step'] == 'new_password') { ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="txtNewPass">New Password:</label>
                    <input type="password" name="txtNewPass" id="txtNewPass" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="txtConfirmPass">Confirm Password:</label>
                    <input type="password" name="txtConfirmPass" id="txtConfirmPass" class="form-control" required>
                </div>
                <button type="submit" name="btnSavePassword" class="btn btn-primary btn-block">Save changes</button>
                <a href="loginnew.php" class="btn btn-success btn-block"> Back To Login Page</a>

            </form>
        <?php } ?>
    </div>
</div>

</body>
</html>
