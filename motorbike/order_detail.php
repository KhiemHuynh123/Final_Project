<?php
session_start();
include 'connect.php';

// Initialize database connection
$conn = new Connect();
$db_link = $conn->connectToPDO();

// Ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header('Location: homepage.php');
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Handle submission of feedback
if (isset($_POST['feedback'])) {
    $feedback = $_POST['feedback'];
    $order_id = $_POST['order_id'];
    $feedback_date = date('Y-m-d'); // Get the current date

    // Get product_id from the order
    $query = "SELECT product_id FROM `order` WHERE order_id = ?";
    $stmt = $db_link->prepare($query);
    $stmt->execute([$order_id]);
    $product_id = $stmt->fetchColumn();

    // Insert feedback into the database
    $query = "INSERT INTO feedback (order_id, customer_id, product_id, content, feedback_date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db_link->prepare($query);
    $stmt->execute([$order_id, $customer_id, $product_id, $feedback, $feedback_date]);

    // Set a session variable to show the thank you message
    $_SESSION['feedback_success'] = true;

    // Redirect to the order detail page
    header('Location: order_detail.php');
    exit();
}

// Fetch orders for the logged-in customer
$query = "SELECT o.order_id, o.product_id, o.payment, o.order_date, o.quantity, o.order_status,
                 p.product_name, p.product_img, p.product_price,
                 f.content AS feedback_content
          FROM `order` o
          JOIN product p ON o.product_id = p.product_id
          LEFT JOIN feedback f ON o.order_id = f.order_id
          WHERE o.customer_id = ?";
$stmt = $db_link->prepare($query);
$stmt->execute([$customer_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 20px;
            font-family: Arial, sans-serif;
        }

        .order-table th,
        .order-table td {
            text-align: center;
        }

        .order-table img {
            max-width: 100px;
            height: auto;
        }

        .feedback-form {
            margin-top: 10px;
        }

        .feedback-form textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .feedback-form .btn-sm {
            margin-right: 5px;
        }

        .thank-you {
            margin-top: 10px;
            padding: 15px;
            background-color: #dff0d8;
            border: 1px solid #d6e9c6;
            border-radius: 5px;
            color: #3c763d;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="my-4">Orders History</h2>
            <a href="cart.php" class="btn btn-primary">Back to Cart</a>
        </div>

        <?php
        if (isset($_SESSION['feedback_success']) && $_SESSION['feedback_success']) {
            echo '<div class="thank-you">Thank you for your Feedback, have a great day!</div>';
            unset($_SESSION['feedback_success']); // Clear the session variable after displaying the message
        }
        ?>

        <?php if ($orders): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered order-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Product Name</th>
                            <th>Product Image</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Payment Method</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                <td><img src="uploads/<?php echo htmlspecialchars($order['product_img']); ?>"
                                        alt="<?php echo htmlspecialchars($order['product_name']); ?>" width="100"></td>
                                <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                                <td>$<?php echo number_format($order['product_price']); ?></td>
                                <td><?php echo htmlspecialchars($order['payment']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                                <td>
                                    <?php if ($order['order_status'] == 'Pending'): ?>
                                        <form action="cancel_order.php" method="POST" onsubmit="return confirmCancel()">
                                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Cancel Order</button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>Cannot Cancel</button>
                                    <?php endif; ?>
                                </td>

                                <script>
                                    function confirmCancel() {
                                        return confirm("Are you sure you want to cancel this order?");
                                    }
                                </script>
                                <td>
                                    <?php if ($order['order_status'] == 'Completed' && !isset($order['feedback_content'])): ?>
                                        <button class="btn btn-primary btn-sm"
                                            onclick="showFeedbackForm(<?php echo $order['order_id']; ?>)">Leave Feedback</button>
                                        <div id="feedback-form-<?php echo $order['order_id']; ?>" class="feedback-form mt-2"
                                            style="display: none;">
                                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="feedback" rows="3"
                                                        placeholder="Enter your feedback"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-success btn-sm">Submit Feedback</button>
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    onclick="hideFeedbackForm(<?php echo $order['order_id']; ?>)">Cancel</button>
                                            </form>
                                        </div>
                                    <?php elseif (isset($order['feedback_content'])): ?>
                                        <span class="text-success">Feedback given</span>
                                    <?php else: ?>
                                        <span class="text-muted">Not eligible for feedback</span>
                                    <?php endif; ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                You have no orders yet.
            </div>
        <?php endif; ?>
    </div>

    <script>
        function showFeedbackForm(orderId) {
            var feedbackForm = document.getElementById('feedback-form-' + orderId);
            feedbackForm.style.display = 'block';
        }

        function hideFeedbackForm(orderId) {
            var feedbackForm = document.getElementById('feedback-form-' + orderId);
            feedbackForm.style.display = 'none';
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>