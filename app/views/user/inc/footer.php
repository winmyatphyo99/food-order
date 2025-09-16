
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<footer class="main-footer">
    <div class="container">
        <div class="row g-4 justify-content-between">
            <div class="col-lg-3 col-md-6 footer-widget">
                <h5 class="fw-bold">Foodie Express</h5>
                <p>
                    Your culinary companion for delicious recipes and food inspiration. We're committed to bringing you a world of flavor, one dish at a time.
                </p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 footer-widget">
                <h5 class="fw-bold">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= URLROOT; ?>/Pages/about">About Us</a></li>
                    <li><a href="<?= URLROOT; ?>/Pages/menu">Full Menu</a></li>
                    <li><a href="#">How It Works</a></li>
                    <li><a href="#">Support & FAQs</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 footer-widget">
                <h5 class="fw-bold">Partner With Us</h5>
                <ul class="list-unstyled">
                    <li><a href="#">For Restaurants</a></li>
                    <li><a href="#">For Drivers</a></li>
                    <li><a href="#">Careers</a></li>
                </ul>
            </div>

            <div class="col-lg-5 col-md-12 footer-widget">
                <h5 class="fw-bold">Stay Connected</h5>
                <p>Subscribe to our newsletter for the latest updates and special offers.</p>
                <div class="footer-newsletter d-flex">
                    <input type="email" class="form-control" placeholder="Enter your email...">
                    <button type="submit">Subscribe</button>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p>&copy; <?= date('Y'); ?> Foodie Express. All Rights Reserved.</p>
        </div>
    </div>
</footer>