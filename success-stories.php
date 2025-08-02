<?php
$page_title = "Success Stories - Thirumangalyam Matrimony";
include('includes/header.php');
?>

<!-- Page Header -->
<div class="bg-primary text-white py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Success Stories</h1>
        <p class="lead">Real couples, real love stories</p>
    </div>
</div>

<!-- Success Stories -->
<div class="container my-5">
    <div class="row g-4">
        <!-- Story 1 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="images/couple1.jpg" class="card-img-top" alt="Happy Couple" style="height: 250px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title text-primary">Rajesh & Priya</h5>
                    <p class="card-text">"We found each other through Thirumangalyam and couldn't be happier. The platform made it easy to connect with like-minded people."</p>
                    <div class="text-muted small">
                        <i class="fas fa-calendar"></i> Married: June 2023
                    </div>
                </div>
            </div>
        </div>

        <!-- Story 2 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="images/couple2.jpg" class="card-img-top" alt="Happy Couple" style="height: 250px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title text-primary">Arun & Meera</h5>
                    <p class="card-text">"Thanks to Thirumangalyam, we found our perfect match. The detailed profiles helped us understand each other better."</p>
                    <div class="text-muted small">
                        <i class="fas fa-calendar"></i> Married: March 2023
                    </div>
                </div>
            </div>
        </div>

        <!-- Story 3 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="images/couple3.jpg" class="card-img-top" alt="Happy Couple" style="height: 250px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title text-primary">Suresh & Kavitha</h5>
                    <p class="card-text">"Our families are so grateful to Thirumangalyam for bringing us together. It's been a wonderful journey."</p>
                    <div class="text-muted small">
                        <i class="fas fa-calendar"></i> Married: December 2022
                    </div>
                </div>
            </div>
        </div>

        <!-- Story 4 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="images/couple4.jpg" class="card-img-top" alt="Happy Couple" style="height: 250px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title text-primary">Vikram & Anjali</h5>
                    <p class="card-text">"The advanced search features helped us find exactly what we were looking for. We're blessed to have found each other."</p>
                    <div class="text-muted small">
                        <i class="fas fa-calendar"></i> Married: September 2023
                    </div>
                </div>
            </div>
        </div>

        <!-- Story 5 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="images/couple5.jpg" class="card-img-top" alt="Happy Couple" style="height: 250px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title text-primary">Karthik & Divya</h5>
                    <p class="card-text">"From the first conversation to our wedding day, everything felt perfect. Thank you Thirumangalyam for making it possible."</p>
                    <div class="text-muted small">
                        <i class="fas fa-calendar"></i> Married: January 2024
                    </div>
                </div>
            </div>
        </div>

        <!-- Story 6 -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="images/couple6.jpg" class="card-img-top" alt="Happy Couple" style="height: 250px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title text-primary">Ravi & Lakshmi</h5>
                    <p class="card-text">"We appreciate the genuine profiles and the supportive team. Our love story began here and continues beautifully."</p>
                    <div class="text-muted small">
                        <i class="fas fa-calendar"></i> Married: April 2024
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<section class="bg-light py-5">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-4">Ready to Write Your Success Story?</h2>
        <p class="lead mb-4">Join thousands of happy couples who found their perfect match through Thirumangalyam Matrimony</p>
        <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="register.php" class="btn btn-primary btn-lg me-3">Register Now</a>
        <a href="search.php" class="btn btn-outline-primary btn-lg">Browse Profiles</a>
        <?php else: ?>
        <a href="search.php" class="btn btn-primary btn-lg me-3">Find Your Match</a>
        <a href="profiles.php" class="btn btn-outline-primary btn-lg">Browse Profiles</a>
        <?php endif; ?>
    </div>
</section>

<?php include('includes/footer.php'); ?>