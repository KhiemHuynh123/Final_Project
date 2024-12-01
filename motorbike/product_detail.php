<?php
include 'connect.php'; // Include the database connection file
session_start();

// Code for homepage
// Initialize the PDO connection
$conn = new Connect();
$db_link = $conn->connectToPDO();

// Get the product ID from the URL parameter
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Query to retrieve the product details
$query = "SELECT * FROM product WHERE product_id = ?";
$stmt = $db_link->prepare($query);
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Query to retrieve the product images
$query = "SELECT product_img FROM product WHERE product_id = ?";
$stmt = $db_link->prepare($query);
$stmt->execute([$product_id]);
$product_images = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query to retrieve the product video URL
$query = "SELECT product_video_url FROM product WHERE product_id = ?";
$stmt = $db_link->prepare($query);
$stmt->execute([$product_id]);
$product_video_url = $stmt->fetchColumn();

// Convert video URL to embed format if it's a YouTube URL
if (!empty($product_video_url) && strpos($product_video_url, 'watch?v=') !== false) {
    $product_video_url = str_replace('watch?v=', 'embed/', $product_video_url);
}

// Query to retrieve feedback for the product
$query = "
    SELECT f.*, c.customer_name 
    FROM feedback f
    JOIN customer c ON f.customer_id = c.customer_id
    WHERE f.product_id = ?
    ORDER BY f.feedback_id DESC
";
$stmt = $db_link->prepare($query);
$stmt->execute([$product_id]);
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/detail.css">
</head>
<style>
p {
    font-size: 20px;
    color: darkblue;
    font-weight: 200px;
}

h2 {
    font-size: 30px;
}

.btn-add-to-order {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 25px;
    padding: 10px 20px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.btn-add-to-order:hover {
    background-color: #0056b3;
}

.alert-info {
    background-color: #e9f7fc;
    color: #31708f;
    border-color: #bce8f1;
    text-align: center;
}
</style>

<body>
    <?php include_once 'header.php'; ?>
    <br><br><br><br><br><br><br>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div id="productCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (!empty($product_images)) { ?>
                        <?php foreach ($product_images as $key => $image) { ?>
                        <div class="carousel-item <?= $key === 0 ? 'active' : '' ?>">
                            <img src="<?= 'uploads/' . htmlspecialchars($image['product_img']) ?>" alt="Product Image"
                                class="d-block w-100 img-fluid">
                            <br><br><br>

                            <!-- Move form inside the carousel item -->
                            <?php if (isset($_SESSION['customer_id'])) : ?>
                            <form method="POST" action="cart.php">
                                <input type="hidden" name="product_id"
                                    value="<?= htmlspecialchars($product['product_id']) ?>">
                                <input type="hidden" name="product_name"
                                    value="<?= htmlspecialchars($product['product_name']) ?>">
                                <input type="hidden" name="product_price"
                                    value="<?= htmlspecialchars($product['product_price']) ?>">
                                <input type="hidden" name="product_img"
                                    value="<?= htmlspecialchars($image['product_img']) ?>">
                                <button type="submit" name="add_to_cart" class="btn btn-add-to-order">Add to
                                    Order</button>
                            </form>
                            <?php else : ?>
                            <p class="alert-info">Please <a href="loginnew.php">login</a> to add this product to your
                                cart.</p>
                            <?php endif; ?>
                        </div>
                        <?php } ?>
                        <?php } else { ?>
                        <div class="carousel-item active">
                            <img src="default.jpg" alt="No image available" class="d-block w-100 img-fluid">
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <?php if ($product) { ?>
                <h1 class="mb-3"><?= htmlspecialchars($product['product_name']) ?></h1>
                <p class="text-success h4">Price: $<?= number_format($product['product_price']) ?></p>
                <p class="mt-4"><?= htmlspecialchars($product['product_description']) ?></p>
                <h1>Introduction about product</h1>
                <?php if (!empty($product_video_url)) { ?>
                <div class="mt-4">
                    <iframe width="100%" height="315" src="<?= htmlspecialchars($product_video_url) ?>" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
                <?php } else { ?>
                <p class="mt-4">No video available.</p>
                <?php } ?>
                <?php } else { ?>
                <p>Product details not found.</p>
                <?php } ?>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Customer Feedback</h2>
                <?php if (!empty($feedbacks)) { ?>
                <div class="list-group">
                    <?php foreach ($feedbacks as $feedback) { ?>
                    <div class="list-group-item">
                        <p class="mb-1"><?= nl2br(htmlspecialchars($feedback['content'])) ?></p>
                        <small>By Customer Name: <?= htmlspecialchars($feedback['customer_name']) ?>
                    </div>
                    <?php } ?>
                </div>
                <?php } else { ?>
                <p>No feedback available for this product.</p>
                <?php } ?>
            </div>
        </div>
    </div>
    <br><br>
</body>
<br><br><br>
<?php include_once 'footer.php'; ?>

</html>