<?php
session_start();
include_once 'connect.php';
$conn = new Connect();
$db_link = $conn->connectToPDO();

// Kiểm tra trạng thái đăng nhập
$is_logged_in = isset($_SESSION['customer_id']) && $_SESSION['role'] === 'customer';

// Fetch top selling products

$query = "SELECT p.product_name, p.product_img, SUM(o.quantity) AS quantity_sold 
          FROM `order` o
          JOIN product p ON o.product_id = p.product_id 
          WHERE o.order_status = 'completed'
          GROUP BY p.product_id 
          ORDER BY quantity_sold DESC 
          LIMIT 4";
$stmt = $db_link->prepare($query);
$stmt->execute();
$top_products = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Fetch all products
$query = "SELECT * FROM product";
$stmt = $db_link->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="assets/images/faviconn.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
    /* Custom button styles */
    </style>
</head>
<style>
@keyframes gradient {
    0% {
        color: #ff6f61;
    }
    50% {
        color: #6b5b95;
    }
    100% {
        color: #88d8b0;
    }
}

.animated-text {
    font-size: 2rem;
    font-weight: bold;
    animation: gradient 5s ease infinite;
    background: linear-gradient(45deg, #ff6f61, #6b5b95, #88d8b0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
body h3{
    font-family: 'Roboto', sans-serif;

}

.carousel-item img {
    height: 400px;
    /* Thay đổi chiều cao hình ảnh nếu cần */
    object-fit: cover;
    /* Đảm bảo hình ảnh không bị biến dạng */
}

.carousel-caption {
    background-color: rgba(0, 0, 0, 0.5);
    /* Nền mờ cho chú thích */
    color: white;
    /* Màu chữ */
}

.banner-title {
    font-family: 'Roboto', sans-serif;
    /* Font chữ tinh tế */
    font-size: 2.5rem;
    /* Kích thước chữ lớn hơn */
    font-weight: bold;
    /* Đậm chữ */
    color: #333;
    /* Màu chữ chính */
    text-align: center;
    /* Căn giữa */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    /* Hiệu ứng bóng chữ nhẹ */
    background: linear-gradient(to right, #ff7e5f, #feb47b);
    /* Gradient màu nền */
    -webkit-background-clip: text;
    /* Cắt nền theo chữ */
    -webkit-text-fill-color: transparent;
    /* Làm chữ trong suốt để nhìn thấy gradient */
    padding: 10px 0;
    /* Padding trên và dưới */
    border-radius: 5px;
    /* Bo góc cho tiêu đề */
    border: 2px solid #feb47b;
    /* Border màu tương phản */
}
</style>

<body>
    <?php include_once 'header.php'; ?>
    <br><br>
    <!-- Home -->
    <section class="home" id="home">
    <div class="content">
        <h3 class="animated-text">Motorbike you need</h3>
            <span>Welcome to GearShift - The leading website providing top-notch motorbike models at the most
                competitive prices. Here, you will easily find your dream motor from our diverse collection, including
                sports motorbikes and more. GearShift is committed to bringing you a great shopping experience with
                professional consulting services and a reputable warranty.</span>
            <p>Explore now to enjoy great driving on every road!</p>
            <a href="#product" id="shopNowButton" class="button">Shop now</a>
        </div>
    </section>

    <!-- Top Selling Products Banner -->
    <section class="banner py-4">
        <div class="container">
            <h2 class="banner-title">Top Selling Products</h2>
            <div id="topSellingCarousel" class="carousel slide">
                <div class="carousel-inner">
                    <?php $is_active = true; ?>
                    <?php foreach ($top_products as $product): ?>
                    <div class="carousel-item <?= $is_active ? 'active' : '' ?>">
                        <img src="<?= ('./uploads/') . htmlspecialchars($product['product_img']) ?>"
                            class="d-block w-100" alt="<?= htmlspecialchars($product['product_name']) ?>"
                            style="height: 400px; object-fit: cover;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?= htmlspecialchars($product['product_name']) ?></h5>
                            <!-- Optional: Add more product details or a call-to-action here -->
                        </div>
                    </div>
                    <?php $is_active = false; ?>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#topSellingCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#topSellingCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="product" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">List of Products</h2>
            <div class="row">
                <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <img style="width:auto; height: 300px;"
                            src="<?= ('./uploads/') . htmlspecialchars($product['product_img']) ?>" class="card-img-top"
                            alt="<?= htmlspecialchars($product['product_name']) ?>"/>


                        <div class="card-body text-center">
                            <h5 class="card-title product-title"><?= ($product['product_name']) ?></h5>
                            <p class="card-text product-price">Price: $<?= ($product['product_price']) ?>
                            </p>
                            <form method="POST" action="cart.php" style="display:inline;">
                                <input type="hidden" name="product_id"
                                    value="<?= ($product['product_id']) ?>">
                                <input type="hidden" name="product_name"
                                    value="<?= ($product['product_name']) ?>">
                                <input type="hidden" name="product_price"
                                    value="<?= ($product['product_price']) ?>">
                                <input type="hidden" name="product_img"
                                    value="<?= ($product['product_img']) ?>">

                                <!-- Add data attribute to the button -->
                                <button type="submit" name="add_to_cart" class="btn btn-add-to-cart"
                                    data-logged-in="<?= $is_logged_in ? 'true' : 'false' ?>">Add to Order</button>

                                <a href="product_detail.php?product_id=<?= ($product['product_id']) ?>"
                                    class="btn btn-view-details">View Details</a>
                            </form>
                        </div>


                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include_once 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check all buttons with data-logged-in attribute
        document.querySelectorAll('button[data-logged-in]').forEach(function(button) {
            if (button.getAttribute('data-logged-in') === 'false') {
                button.style.display = 'none'; // Hide the button if not logged in
            }
        });
    });
    </script>

</body>

</html>