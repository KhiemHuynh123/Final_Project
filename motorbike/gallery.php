<?php
session_start();
include_once 'header.php';
?>
<br><br><br><br><br>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motorbike Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .gallery-title {
            text-align: center;
            font-size: 36px;
            margin-top: 30px;
            margin-bottom: 50px;
            color: #333;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
            cursor: pointer;
        }
        .card {
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .video-container {
            margin-top: 50px;
            text-align: center;
        }
        video {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="gallery-title">Motorbike Gallery</h1>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <img src="uploads/gallery7.jpg" class="card-img-top" alt="BMW" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this)">
                    <div class="card-body"></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <img src="uploads/gallery8.jpg" class="card-img-top" alt="BMW" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this)">
                    <div class="card-body"></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <img src="uploads/gallery1.jpg" class="card-img-top" alt="Kawasaki" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this)">
                    <div class="card-body"></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <img src="uploads/gallery3.jpg" class="card-img-top" alt="Ducati" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this)">
                    <div class="card-body"></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <img src="uploads/gallery4.jpg" class="card-img-top" alt="Ducati" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this)">
                    <div class="card-body"></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <img src="uploads/gallery5.jpg" class="card-img-top" alt="Ducati" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this)">
                    <div class="card-body"></div>
                </div>
            </div>
        </div>

        <!-- Video Section -->
        <div class="video-container">
            <h2 class="gallery-title">Motorbike Showcase Video</h2>
            <video controls>
                <source src="assets/video/login.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" id="modalImage" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showImage(element) {
            document.getElementById('modalImage').src = element.src;
        }
    </script>
</body>
</html>
<?php
include_once 'footer.php';
?>