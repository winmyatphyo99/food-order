<!DOCTYPE html>
<html lang="my">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo SITENAME; ?> | <?php echo isset($data['title']) ? $data['title'] : ''; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/main.css">
  <style>/* Navbar */
.navbar .nav-link {
  font-weight: 500;
  color: #333 !important;
}
.navbar .nav-link:hover {
  color: #0d6efd !important;
}

/* Category Cards */
.card {
  border-radius: 12px;
  transition: all 0.2s ease-in-out;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

/* Hero Section */
.hero-section {
  background: url('<?php echo URLROOT; ?>/images/hero-food.jpg') center/cover no-repeat;
  height: 80vh;
  position: relative;
}
.hero-section::before {
  content: "";
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.5); /* dark overlay */
}
.hero-section .container {
  position: relative;
  z-index: 2;
}

/* Category Cards */
.category-card {
  border-radius: 15px;
  overflow: hidden;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.category-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 25px rgba(0,0,0,0.15);
}
.category-card img {
  height: 180px;
  object-fit: cover;
}
.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* Call To Action Section */
.cta-section {
  background: linear-gradient(135deg, #ff9800, #f44336);
  border-radius: 20px;
  margin: 60px auto;
  max-width: 1000px;
}


/* Product List Section */

.product-img {
    width: 100%;       /* Make the image take up the full width of its container */
    height: 250px;     /* Set a fixed height for all images */
    object-fit: cover; /* This is the key property! It crops the image to fit the container without distortion */
}

/* Optional: Add a class to the card to ensure consistent spacing */
.product-card {
    display: flex;
    flex-direction: column;
}

.product-card .card-body {
    flex-grow: 1; /* Makes sure the body takes up available space for consistent card height */
}

</style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="<?php echo URLROOT; ?>">🍴 Food Order System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
        <a class="nav-link" href="<?php echo URLROOT; ?>/Pages/home">Home</a>
        <a class="nav-link" href="<?php echo URLROOT; ?>/Pages/menu">Menu</a>
        <a class="nav-link" href="<?php echo URLROOT; ?>/Pages/menuCategory">Category</a>
        <a class="nav-link" href="<?php echo URLROOT; ?>/OrderController/orderHistory">My Orders</a>

        <li class="nav-item">
            <a href="<?php echo URLROOT; ?>/CartController/viewCart" class="nav-link position-relative d-flex align-items-center me-2">
                <i class="fas fa-shopping-cart me-1"></i> Your Cart
                <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) : ?>
                    <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                        <?php echo count($_SESSION['cart']); ?>
                    </span>
                <?php endif; ?>
            </a>
        </li>
        <li class="nav-item dropdown">
            <?php if(isset($_SESSION['user_id'])) : ?>
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   <img src="<?php echo URLROOT . '/uploads/profile/' . $_SESSION['profile_image'] ?? URLROOT . '/uploads/profile/default_profile.jpg'; ?>" 
     alt="Profile" class="rounded-circle me-2" style="width:35px; height:35px; object-fit:cover;">
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/UserController/profile">My Profile</a></li>
                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/UserController/editProfile">Edit Profile</a></li>
                    <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/UserController/changePassword">Change Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?php echo URLROOT; ?>/auth/logout">Logout</a></li>
                </ul>
            <?php else: ?>
                <a class="btn btn-sm btn-outline-primary" href="<?php echo URLROOT; ?>/auth/register">Register</a>
            <?php endif; ?>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>