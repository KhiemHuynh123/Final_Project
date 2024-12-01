<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | GearShift Motorbikes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="assets/images/faviconn.ico" type="image/x-icon">
    <style>
        /* Custom styles for About Us page */
        .about-section {
            padding: 60px 0;
        }
        .about-section h2 {
            margin-bottom: 30px;
        }
        .team-member {
            text-align: center;
        }
        .team-member img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
        }
        .team-member h4 {
            margin-top: 15px;
        }
        .testimonial {
            background-color: #f9f9f9;
            padding: 40px 0;
        }
        .testimonial .carousel-item {
            text-align: center;
        }
        .testimonial .carousel-item img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <!-- About Us Section -->
    <section class="about-section">
        <div class="container">
            <h2 class="text-center">About Us</h2>
            <div class="row">
                <div class="col-lg-6">
                    <h3>Welcome to GearShift</h3>
                    <p>
                        At GearShift, we are passionate about delivering the best high-performance motorbikes to enthusiasts and riders across the country. With a commitment to excellence, we provide an extensive range of top-quality bikes, accessories, and services to meet all your motorcycling needs.
                    </p>
                    <p>
                        Our experienced team is dedicated to offering personalized services and expert advice, ensuring that you find the perfect bike that fits your lifestyle and preferences. Whether you’re a seasoned rider or a beginner, our goal is to enhance your riding experience with the best products and exceptional customer support.
                    </p>
                </div>
                <div class="col-lg-6">
                    <img src="assets/images/about_us.jpg" alt="About Us" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section py-5">
        <div class="container">
            <h2 class="text-center mb-4">Meet Our Team</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="assets/images/team_member1.jpg" alt="Team Member 1">
                        <h4>John Doe</h4>
                        <p>CEO & Founder</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="assets/images/team_member2.jpg" alt="Team Member 2">
                        <h4>Jane Smith</h4>
                        <p>Lead Mechanic</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="assets/images/team_member3.jpg" alt="Team Member 3">
                        <h4>Emily Johnson</h4>
                        <p>Customer Service Manager</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonial py-5">
        <div class="container">
            <h2 class="text-center mb-4">What Our Customers Say</h2>
            <div id="testimonialCarousel" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="assets/images/customer1.jpg" alt="Customer 1">
                        <p class="mt-3">"GearShift has provided me with an exceptional buying experience. Their staff are knowledgeable and truly passionate about motorbikes. Highly recommend!"</p>
                        <footer class="blockquote-footer">Michael Brown</footer>
                    </div>
                    <div class="carousel-item">
                        <img src="assets/images/customer2.jpg" alt="Customer 2">
                        <p class="mt-3">"The selection of bikes at GearShift is unmatched. I found exactly what I was looking for, and the customer service was top-notch."</p>
                        <footer class="blockquote-footer">Sarah Wilson</footer>
                    </div>
                    <div class="carousel-item">
                        <img src="assets/images/customer3.jpg" alt="Customer 3">
                        <p class="mt-3">"From the moment I walked into GearShift, I felt welcomed and valued. Their expertise and support made my bike purchase a breeze."</p>
                        <footer class="blockquote-footer">David Lee</footer>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
