<?php
session_start();
include_once 'connect.php';
$conn = new Connect();
$db_link = $conn->connectToPDO();

// Kiểm tra trạng thái đăng nhập
if (!isset($_SESSION['customer_id'])) {
    header('Location: loginnew.php');
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Lấy dữ liệu từ form
$customer_name = $_POST['customer_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];

// Xử lý hình ảnh
$profile_image = $_FILES['profile_image']['name'];
$target_dir = "./uploads";
$uploadOk = 1;

// Kiểm tra xem có hình ảnh được tải lên không
if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
    // Xác định định dạng file
    $imageFileType = strtolower(pathinfo($profile_image, PATHINFO_EXTENSION));
    $target_file = $target_dir . '/' . basename($profile_image);

    // Kiểm tra định dạng hình ảnh
    if(!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        $uploadOk = 0;
        echo "<script>alert('Chỉ cho phép các định dạng JPG, JPEG, PNG & GIF.');</script>";
    }

 

    // Kiểm tra kích thước file (giới hạn 500KB)
    if ($_FILES["profile_image"]["size"] > 5000000) {
        $uploadOk = 0;
        echo "<script>alert('File too large.');</script>";
    }

    // Nếu không có lỗi nào xảy ra, tiến hành upload file
    if ($uploadOk) {
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            echo "<script>alert('image " . htmlspecialchars(basename($profile_image)) . " has been uploaded.');</script>";
        } else {
            $profile_image = $_POST['current_image']; // Giữ lại hình ảnh cũ nếu upload thất bại
            echo "<script>alert('Sorry, there was an error loading your image.n.');</script>";
        }
    } else {
        $profile_image = $_POST['current_image']; // Giữ lại hình ảnh cũ nếu không upload thành công
    }
} else {
    // Nếu không có hình ảnh mới
    $profile_image = $_POST['current_image'];
}

// Cập nhật thông tin khách hàng
$query = "UPDATE customer SET customer_name = :customer_name, email = :email, phone = :phone, address = :address, profile_image = :profile_image WHERE customer_id = :customer_id";
$stmt = $db_link->prepare($query);
$success = $stmt->execute([
    ':customer_name' => $customer_name,
    ':email' => $email,
    ':phone' => $phone,
    ':address' => $address,
    ':profile_image' => $profile_image,
    ':customer_id' => $customer_id
]);

// Thông báo sau khi cập nhật
if ($success) {
    echo "<script>alert('Update successfull!'); window.location.href='profile.php';</script>";
} else {
    echo "<script>alert('Update fail. Please try again!.');</script>";
}

?>
