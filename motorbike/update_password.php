<link rel="icon" href="assets/images/faviconn.ico" type="image/x-icon">

<?php
session_start();
include_once 'connect.php'; // Kết nối cơ sở dữ liệu

$conn = new Connect();
$db_link = $conn->connectToPDO();

// Xử lý thay đổi mật khẩu
if (isset($_POST['btnSavePassword'])) {
    $current_pass = $_POST['txtCurrentPass'];
    $new_pass = $_POST['txtNewPass'];
    $confirm_pass = $_POST['txtConfirmPass'];
    $err = "";

    // Kiểm tra mật khẩu hiện tại
    $customer_id = $_SESSION['customer_id'];
    $sql = "SELECT pass FROM customer WHERE customer_id = ?";
    $stmt = $db_link->prepare($sql);
    $stmt->execute([$customer_id]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$customer || !password_verify($current_pass, $customer['pass'])) {
        $err .= "Current password is incorrect. ";
    }

    // Kiểm tra mật khẩu mới
    if (strlen($new_pass) <= 5) {
        $err .= "New password must be longer than 5 characters. ";
    }
    if ($new_pass != $confirm_pass) {
        $err .= "New password and confirm password do not match. ";
    }

    if ($err == "") {
        // Mật khẩu hợp lệ, tiến hành cập nhật
        $hashed_pass = password_hash($new_pass, PASSWORD_BCRYPT);

        $sql = "UPDATE customer SET pass = ? WHERE customer_id = ?";
        $stmt = $db_link->prepare($sql);
        if ($stmt->execute([$hashed_pass, $customer_id])) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Password changed successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            window.location.href='profile.php';
                        });
                    });
                  </script>";
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
    <title>Change Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <h2 class="text-center">Change Password</h2>

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

        <!-- Form thay đổi mật khẩu -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="txtCurrentPass">Current Password:</label>
                <input type="password" name="txtCurrentPass" id="txtCurrentPass" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="txtNewPass">New Password:</label>
                <input type="password" name="txtNewPass" id="txtNewPass" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="txtConfirmPass">Confirm Password:</label>
                <input type="password" name="txtConfirmPass" id="txtConfirmPass" class="form-control" required>
            </div>
            <button type="submit" name="btnSavePassword" class="btn btn-primary btn-block">Save changes</button>
            <a href="profile.php" class="btn btn-success btn-block">Back to Profile</a>
        </form>
    </div>
</div>

</body>
</html>
