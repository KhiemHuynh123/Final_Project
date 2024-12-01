<?php
// session_start();
// ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motorbike</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
        integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1MA2VgR/t7JO3B1" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
.search-container {
    display: flex;
    align-items: center;
}

.search-input {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 20px;
    font-size: 16px;
    width: 100%;
    box-sizing: border-box;
}

.search-button {
    border: none;
    /* Remove the border */
    background: none;
    /* Remove the background */
    padding: 0;
    /* Remove padding */
    margin-left: -45px;
    /* Adjust as needed to align with input */
    cursor: pointer;
    /* Change cursor to pointer */
    display: flex;
    /* Use flex to center the icon if needed */
    align-items: center;
    /* Center the icon vertically */
}

.search-icon {
    width: 20px;
    /* Adjust the size as needed */
    height: 20px;
    /* Adjust the size as needed */
    display: block;
    /* Remove extra space around the image */
}

.login-image {
    width: 30px;
    /* Chỉnh kích thước hình ảnh */
    height: auto;
    cursor: pointer;
    /* Hiển thị con trỏ khi di chuột lên ảnh */
}
</style>

<body>
    <header>
        <input type="checkbox" name="" id="toggler">
        <label for="toggler" class="fas fa-bars"></label>

        <a href="homepage.php" class="logo">
            <img src="image/fire logo-Photoroom.png" alt="GearShift Logo" style="height: 70px;">
        </a>
        <nav class="navbar">
            <a href="homepage.php" class="nav-link">Home</a>
            <a href="#product" class="nav-link">Products</a>
            <a href="#footer" class="nav-link">Contact</a>

            <form method="POST" action="search.php">
                <div class="search-container">
                    <input type="text" name="txtSearch" placeholder="Search..." class="search-input" required>
                    <button type="submit" class="search-button">
                        <img src="./uploads/icons8-search-16.png" alt="Search Icon" class="search-icon">
                    </button>
                </div>
            </form>
        </nav>
        <div class="icons">
            <?php
        if (isset($_SESSION['customer_name'])) {
            // Nếu người dùng đã đăng nhập
            echo "<span>Hi, " . htmlspecialchars($_SESSION['customer_name']) . "</span>";
            echo '<a href="profile.php" class="bi bi-person-circle"></a>'; // Thêm liên kết đến trang Profile
            echo '<a href="cart.php" class="bi bi-cart-check"></a>';
            echo '<a href="logout.php" class="bi bi-box-arrow-right"></a>';
        } else {
            // Nếu là guest (chưa đăng nhập)
            echo '<span>Hi, Guest</span>';
            echo '<a href="loginnew.php" class="bi bi-box-arrow-in-left"></a>';
        }
        ?>
        </div>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-mQ93NGK02aC2TdE5lI1eV+Lv5F0O1iZsHb1z4LlY8Zy1pD+5T5En1RfuWDaP8f3p" crossorigin="anonymous">
    </script>