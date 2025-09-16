
<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<div class="contact-page-container">
    <section class="contact-header">
        <div>
            <h1>Contact Us</h1>
            <p>Whether you have a question about reservation, prices, or any other details, please contact us using the form below.</p>
        </div>
        <img src="<?= URLROOT; ?>/img/Grilled Salmon.jpg" alt="Contact">
    </section>

    <section id="contact" class="contact-section">
        <div class="container">
            <?php if (!empty($data['success'])): ?>
                <div class="alert alert-success text-center"><?= $data['success']; ?></div>
            <?php endif; ?>
            <?php if (!empty($data['errors']['general'])): ?>
                <div class="alert alert-danger text-center"><?= $data['errors']['general']; ?></div>
            <?php endif; ?>
            <div class="row justify-content-center">
                <div class="col-md-5 d-flex flex-column align-items-start">
                    <h4>Contact Us</h4>
                    <p>Delicious dishes meet at our restaurant. Explore our menu, or reserve your new favorite items. Come and visit us today!</p>
                    <h5 class="mt-4">Opening Hours</h5>
                    <p>Mon: Fri: 7:00am - 6:00pm</p>
                    <p>Sat: 7:00am - 4:00pm</p>
                    <p>Sun: 8:00am - 6:00pm</p>
                    <div>
                        <a href="#" class="me-2"><i class="fab fa-facebook-f fa-2x"></i></a>
                        <a href="#"><i class="fab fa-instagram fa-2x"></i></a>
                    </div>
                </div>
                <div class="col-md-7">
                    <h4>Send Us a Message</h4>
                    <form method="POST" action="<?= URLROOT; ?>/ContactController/send">
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" value="<?= $data['old']['name'] ?? ''; ?>">
                            <small class="text-danger"><?= $data['errors']['name'] ?? ''; ?></small>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?= $data['old']['email'] ?? ''; ?>">
                            <small class="text-danger"><?= $data['errors']['email'] ?? ''; ?></small>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="subject" class="form-control" placeholder="Subject" value="<?= $data['old']['subject'] ?? ''; ?>">
                            <small class="text-danger"><?= $data['errors']['subject'] ?? ''; ?></small>
                        </div>
                        <div class="mb-3">
                            <textarea name="message" class="form-control" rows="5" placeholder="Your Message"><?= $data['old']['message'] ?? ''; ?></textarea>
                            <small class="text-danger"><?= $data['errors']['message'] ?? ''; ?></small>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="contact_submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>