<?php
$page_title = "Contact Us - Thirumangalyam Matrimony";
include('includes/header.php');
include('Database/db-connect.php');

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    $query = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Thank you for your message! We'll get back to you soon.";
    } else {
        $_SESSION['error'] = "Sorry, there was an error sending your message. Please try again.";
    }
    
    header('Location: contact.php');
    exit;
}
?>

<!-- Display Messages -->
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Page Header -->
<div class="bg-primary text-white py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Contact Us</h1>
        <p class="lead">We're here to help you find your perfect match</p>
    </div>
</div>

<!-- Contact Information and Form -->
<div class="container my-5">
    <div class="row g-5">
        <!-- Contact Information -->
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title text-primary mb-4">
                        <i class="fas fa-info-circle"></i> Contact Information
                    </h3>
                    
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-center">
                            <div class="contact-icon me-3">
                                <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Address</h5>
                                <p class="text-muted mb-0">123 Main Street, City, State 12345</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-center">
                            <div class="contact-icon me-3">
                                <i class="fas fa-phone fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Phone</h5>
                                <p class="text-muted mb-0">+1 (555) 123-4567</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-center">
                            <div class="contact-icon me-3">
                                <i class="fas fa-envelope fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Email</h5>
                                <p class="text-muted mb-0">info@thirumangalyam.com</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-center">
                            <div class="contact-icon me-3">
                                <i class="fas fa-clock fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Business Hours</h5>
                                <p class="text-muted mb-0">Monday - Friday: 9:00 AM - 6:00 PM<br>
                                Saturday: 10:00 AM - 4:00 PM<br>
                                Sunday: Closed</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Media Links -->
                    <div class="mt-4">
                        <h5 class="mb-3">Follow Us</h5>
                        <div class="d-flex gap-3">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger btn-sm">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title text-primary mb-4">
                        <i class="fas fa-paper-plane"></i> Send Us a Message
                    </h3>
                    
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="invalid-feedback">
                                Please provide your name.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback">
                                Please provide a valid email address.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="6" required placeholder="How can we help you?"></textarea>
                            <div class="invalid-feedback">
                                Please provide your message.
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Map Section -->
<div class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h3 class="display-6 fw-bold">Find Us Here</h3>
                <p class="lead">Visit our office for personalized assistance</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="ratio ratio-21x9">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.186217487598!2d106.69519151479959!3d10.7612942624426!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752cc98fd937c9%3A0xd8633a1386f0da34!2zVGVzdCBPZmZpY2UsIENpdHksIFZpZXRuYW0gVGVzdA!5e0!3m2!1sen!2sus!4v1636707714642!5m2!1sen!2sus" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>