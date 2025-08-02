<!-- Footer -->
<footer class="site-footer mt-5">
    <div class="footer-container">
        <div class="container">
            <div class="row">
                <!-- Company Info -->
                <div class="col-md-3 mb-4">
                    <h5 class="text-white mb-3">Thirumangalyam Matrimony</h5>
                    <p class="text-white-50">Your trusted partner in finding the perfect life companion. We believe in creating meaningful connections that last a lifetime.</p>
                    <div class="social-links">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-md-2 mb-4">
                    <h6 class="text-white mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white-50 text-decoration-none">Home</a></li>
                        <li><a href="about.php" class="text-white-50 text-decoration-none">About Us</a></li>
                        <li><a href="profiles.php" class="text-white-50 text-decoration-none">Profiles</a></li>
                        <li><a href="search.php" class="text-white-50 text-decoration-none">Search</a></li>
                        <li><a href="contact.php" class="text-white-50 text-decoration-none">Contact</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="col-md-2 mb-4">
                    <h6 class="text-white mb-3">Services</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none">Matrimony Services</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Profile Verification</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Premium Membership</a></li>
                        <li><a href="success-stories.php" class="text-white-50 text-decoration-none">Success Stories</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="col-md-2 mb-4">
                    <h6 class="text-white mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none">Help Center</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Privacy Policy</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Terms of Service</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">FAQ</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-md-3 mb-4">
                    <h6 class="text-white mb-3">Contact Info</h6>
                    <div class="text-white-50">
                        <p><i class="fas fa-map-marker-alt me-2"></i> 123 Main Street, City, State 12345</p>
                        <p><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</p>
                        <p><i class="fas fa-envelope me-2"></i> info@thirumangalyam.com</p>
                        <p><i class="fas fa-clock me-2"></i> Mon - Fri: 9:00 AM - 6:00 PM</p>
                    </div>
                </div>
            </div>

            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

            <!-- Copyright -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="text-white-50 mb-0">
                        &copy; <?php echo date('Y'); ?> Thirumangalyam Matrimony. All rights reserved. 
                        Powered by <a href="#" class="text-white text-decoration-none">TKS IT Solution</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript -->
<script>
// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
});
</script>

</body>
</html>