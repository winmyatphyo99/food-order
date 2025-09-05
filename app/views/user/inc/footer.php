<footer style="background-color: var(--light-bg); color: var(--dark-text); padding-top: 3rem; padding-bottom: 2rem; border-top: 1px solid var(--border-color);">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4 mb-3">
                <h5 class="fw-bold mb-3" style="color: var(--primary-color);">Foodie Express</h5>
                <p style="color: var(--dark-text);">Your go-to app for delicious meals delivered fast. We connect you with the best restaurants in your city.</p>
                <div class="social-icons mt-4">
                    <a href="#" class="me-3" style="color: var(--primary-color);"><i class="fab fa-facebook-f fa-lg"></i></a>
                    <a href="#" class="me-3" style="color: var(--primary-color);"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="me-3" style="color: var(--primary-color);"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="me-3" style="color: var(--primary-color);"><i class="fab fa-linkedin-in fa-lg"></i></a>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <h5 class="fw-bold mb-3" style="color: var(--primary-color);">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="<?= URLROOT; ?>/Pages/about" style="color: var(--dark-text);">About Us</a></li>
                    <li class="mb-2"><a href="<?= URLROOT; ?>/Pages/menu" style="color: var(--dark-text);">Menu</a></li>
                    <li class="mb-2"><a href="#" style="color: var(--dark-text);">Careers</a></li>
                    <li class="mb-2"><a href="#" style="color: var(--dark-text);">FAQs</a></li>
                </ul>
            </div>

            <div class="col-md-3 mb-3">
                <h5 class="fw-bold mb-3" style="color: var(--primary-color);">Contact Us</h5>
                <p style="color: var(--dark-text);"><i class="fas fa-map-marker-alt me-2"></i> 123 Foodie Blvd, Flavor City</p>
                <p style="color: var(--dark-text);"><i class="fas fa-envelope me-2"></i> support@foodieexpress.com</p>
                <p style="color: var(--dark-text);"><i class="fas fa-phone me-2"></i> +1 (123) 456-7890</p>
            </div>

            <div class="col-md-3 mb-3">
                <h5 class="fw-bold mb-3" style="color: var(--primary-color);">Stay Updated</h5>
                <p style="color: var(--dark-text);">Subscribe to our newsletter for exclusive offers!</p>
                <form>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Enter your email" aria-label="Email for newsletter">
                        <button class="btn" style="background-color: var(--accent-color); color: white;" type="submit">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
        <hr style="border-top: 1px solid var(--border-color);">
        <div class="text-center" style="color: var(--secondary-text);">
            &copy; <?= date('Y'); ?> Foodie Express. All Rights Reserved.
        </div>
    </div>
</footer>
</body>
<script src="<?php echo URLROOT; ?>/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>