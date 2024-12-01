<?php
session_start();
include 'connect.php'; // Bao gồm tập tin kết nối cơ sở dữ liệu
include 'header.php';

// Kiểm tra lỗi PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Khởi tạo kết nối với PDO
$conn = new Connect();
$db_link = $conn->connectToPDO();

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['customer_id'])) {
    header('Location: loginnew.php');
    exit();
}

// Lấy customer_id từ session
$customer_id = $_SESSION['customer_id'];

// Thêm sản phẩm vào giỏ hàng
if (isset($_POST['add_to_cart'])) {
    if (isset($_POST['product_id'], $_POST['product_name'], $_POST['product_price'], $_POST['product_img'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_img = $_POST['product_img'];
        $date = date('Y-m-d H:i:s');

        // Check current stock
        $query = "SELECT quantity FROM product WHERE product_id = ?";
        $stmt = $db_link->prepare($query);
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product && $product['quantity'] > 0) {
            // Check if there's already an item in the cart
            $query = "SELECT COUNT(*) FROM cart WHERE customer_id = ?";
            $stmt = $db_link->prepare($query);
            $stmt->execute([$customer_id]);
            $cart_count = $stmt->fetchColumn();

            if ($cart_count > 0) {
                // If there is already an item in the cart, notify the user
                $_SESSION['message'] = "You can only add 1 Product to your cart.";
            } else {
                // Add product to cart
                $query = "INSERT INTO cart (customer_id, product_id, product_name, product_price, product_img, date, count) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $db_link->prepare($query);
                $stmt->execute([$customer_id, $product_id, $product_name, $product_price, $product_img, $date, 1]);

                // Reduce product quantity in stock
                $new_quantity = $product['quantity'] - 1;
                $update_sql = "UPDATE product SET quantity = ? WHERE product_id = ?";
                $stmt = $db_link->prepare($update_sql);
                $stmt->execute([$new_quantity, $product_id]);

                echo '<script>alert("Product added to cart successfully."); window.location.href="cart.php";</script>';
                exit();
            }
        } else {
            $_SESSION['message'] = "This product is out of stock.";
        }
    } else {
        echo "Please provide all product information.";
    }
}

// Xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['remove'])) {
    $cart_id = $_GET['remove'];

    $query = "DELETE FROM cart WHERE cart_id = ? AND customer_id = ?";
    $stmt = $db_link->prepare($query);
    $stmt->execute([$cart_id, $customer_id]);

    // Hiển thị thông báo trên hộp thoại xóa sản phẩm thành công
    echo '<script>alert("Deleted success!"); window.location.href="cart.php";</script>';
    exit();
}

// Hiển thị giỏ hàng
// Fetch cart items
$query = "SELECT * FROM cart WHERE customer_id = ?";
$stmt = $db_link->prepare($query);
$stmt->execute([$customer_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<br><br><br><br><br>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Roboto', sans-serif;
            color: #333;
        }

        .container {
            margin-top: 50px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h1 {
            color: #5a5a5a;
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .alert-info {
            background-color: #e9f7fc;
            color: #31708f;
            border-color: #bce8f1;
            text-align: center;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border-color: #ffeeba;
            text-align: center;
        }

        .table thead th {
            background-color: #e9ecef;
            color: #495057;
        }

        .table tbody tr td {
            vertical-align: middle;
        }

        .btn-custom {
            background-color: #007bff;
            border-color: #007bff;
            color: #ffffff;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 500;
        }

        .text-danger {
            color: #e74c3c !important;
            font-weight: bold;
        }

        .price,
        .total-price {
            color: #333;
            font-weight: bold;
        }

        .table tbody tr td:last-child {
            text-align: center;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .alert {
            font-size: 1rem;
        }

        .empty-cart {
            text-align: center;
            padding: 50px 0;
            color: #777;
        }

        .empty-cart a {
            color: #007bff;
            text-decoration: none;
        }

        .empty-cart a:hover {
            text-decoration: underline;
        }

        .empty-cart {
            text-align: center;
            padding: 50px 0;
            color: #777;
            font-size: 1.5rem;
            /* Increased font size for the message */
        }

        .empty-cart a {
            color: #007bff;
            text-decoration: none;
            font-size: 1.3rem;
            /* Increased font size for the link */
        }

        .empty-cart a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Your Cart</h1>

        <?php if (isset($_SESSION['message'])) : ?>
            <div class="alert alert-info" role="alert">
                <?= htmlspecialchars($_SESSION['message']) ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (count($cart_items) > 0) : ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item) : ?>
                        <?php
                        // Check current stock
                        $product_query = "SELECT quantity FROM product WHERE product_id = ?";
                        $product_stmt = $db_link->prepare($product_query);
                        $product_stmt->execute([$item['product_id']]);
                        $product = $product_stmt->fetch(PDO::FETCH_ASSOC);
                        $in_stock = $product && $product['quantity'] > 0;
                        ?>
                        <tr>
                            <td><?= ($item['product_name']) ?></td>
                            <td class="price">$<?= number_format($item['product_price']) ?></td>
                            <td class="total-price">$<?= number_format($item['product_price'] * $item['count']) ?></td>
                            <td>
                                <div class="btn-group">
                                    <?php if ($in_stock) : ?>
                                        <a href="cart.php?remove=<?= htmlspecialchars($item['cart_id']) ?>"
                                            class="btn btn-custom">Delete</a>
                                        <a href="checkout.php?product_id=<?= htmlspecialchars($item['product_id']) ?>"
                                            class="btn btn-warning">Check Out</a>
                                    <?php else : ?>
                                        <span class="text-danger">Out of Stock</span>
                                        <br>
                                        <a href="cart.php?remove=<?= htmlspecialchars($item['cart_id']) ?>"
                                            class="btn btn-custom mt-2">Delete</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="alert alert-warning empty-cart" role="alert">
                Your cart is empty! <br><a href="homepage.php">Continue Shopping</a>
            </div>
            <br>
        <?php endif; ?>
        <a href="order_detail.php" class="btn btn-custom">History Orders</a>
    </div>
    <br><br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
include_once 'footer.php';
?>