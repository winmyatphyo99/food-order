<!DOCTYPE html>
<html lang="my">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?> | <?php echo isset($data['title']) ? $data['title'] : ''; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/main.css">
    <style>
        /* Custom properties for consistency */
        :root {
            --primary-color: #0d6efd;
            --text-dark: #333;
            --text-muted: #666;
            --bg-white: #fff;
            --border-color: #dee2e6;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        /* Navbar Enhancements */
        .navbar {
            transition: box-shadow 0.3s ease, background-color 0.3s ease;
        }

        .navbar-brand {
            font-size: 2rem;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--primary-color);
        }

        .navbar .nav-link {
            font-weight: 500;
            font-size: 1.2rem;
            color: var(--text-dark) !important;
            position: relative;
            transition: color 0.3s ease, transform 0.2s ease;
            padding: 0.5rem 1rem !important;
        }
        .navbar-nav { margin-right: 2rem;
}

        .navbar .nav-link:hover {
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }

        /* Add a subtle underline animation on hover */
        .navbar .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }

        .navbar .nav-link:hover::after,
        .navbar .nav-link.active::after {
            width: calc(100% - 2rem);
        }

        /* Dropdown Menu Styling */
        .navbar .dropdown-menu {
            border-radius: 0.75rem;
            box-shadow: 0 8px 30px var(--shadow-color);
            border: 1px solid var(--border-color);
            padding: 0.5rem;
            animation: fadeInScale 0.3s ease-out;
        }

        /* Dropdown Item Styling */
        .navbar .dropdown-item {
            font-weight: 500;
            color: var(--text-dark);
            border-radius: 0.5rem;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .navbar .dropdown-item:hover {
            background-color: #f8f9fa;
            color: var(--primary-color);
        }

        .navbar .dropdown-divider {
            margin: 0.5rem 0;
            border-top: 1px solid var(--border-color);
        }

        /* Dropdown Profile Image */
        .navbar .dropdown-toggle img {
            border: 2px solid transparent;
            transition: border-color 0.2s ease, transform 0.2s ease;
        }

        .navbar .dropdown-toggle:hover img {
            border-color: var(--primary-color);
            transform: scale(1.05);
        }

        /* Cart Badge */
        .navbar .badge {
            animation: pulse 1.5s infinite;
            border-radius: 50% !important;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Keyframe Animations */
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
            }
        }

    .header-btn {
    background: transparent;  /* or your desired color */
    color: var(--text-secondary);
    border: 1px solid var(--text-light);
    width: auto;              /* remove full width */
    margin-top: 0;            /* reset margin */
    padding: 6px 18px;        /* adjust padding */
}

.header-btn:hover {
    background: var(--accent-color);
    color: var(--text-primary);
}

    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-4 sticky-top">
        <div class="container-fluid px-0">
            <a class="navbar-brand fw-bold text-primary ms-5" href="<?php echo URLROOT; ?>">🍴 Food Order System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto  align-items-lg-center gap-2">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a class="nav-link" href="<?php echo URLROOT; ?>/CustomerController/dashboard">Dashboard</a>
                        <a class="nav-link" href="<?php echo URLROOT; ?>/Pages/menu">Menu</a>
                        <a class="nav-link" href="<?php echo URLROOT; ?>/Pages/menuCategory">Category</a>
                        <a class="nav-link" href="<?php echo URLROOT; ?>/OrderController/orderHistory">My Orders</a>
                        <li class="nav-item">
                            <a href="<?php echo URLROOT; ?>/CartController/viewCart"
                                class="nav-link position-relative d-flex align-items-center me-2">
                                <i class="fas fa-shopping-cart me-1"></i> Your Cart
                                <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                                    <span
                                        class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                                        <?php echo count($_SESSION['cart']); ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item dropdown">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?php
                                $profileImagePath = isset($_SESSION['profile_image'])
                                    ? URLROOT . '/uploads/profile/' . $_SESSION['profile_image']
                                    : URLROOT . '/uploads/profile/default_profile.jpg';
                                ?>
                                <img src="<?php echo $profileImagePath; ?>" alt="Profile"
                                    class="rounded-circle profile-logo me-2"
                                    style="width:35px; height:35px; object-fit:cover;">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/UserController/profile">My
                                        Profile</a></li>
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/UserController/editProfile">Edit
                                        Profile</a></li>
                                <li><a class="dropdown-item"
                                        href="<?php echo URLROOT; ?>/UserController/changePassword">Change Password</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger"
                                        href="<?php echo URLROOT; ?>/auth/logout">Logout</a></li>
                            </ul>
                        <?php else: ?>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                                    <a class="nav-link" href="<?php echo URLROOT; ?>/Pages/home">Home</a>
                                    <a class="nav-link" href="<?php echo URLROOT; ?>/Pages/menu">Menu</a>
                                    
                                    <a class="nav-link" href="<?php echo URLROOT; ?>/Pages/about">About</a>

                                    <a class="nav-link" href="<?php echo URLROOT; ?>/ContactController/send">Contact</a>
                                    
                                    <a class="btn  btn-outline-primary btn header-btn" style="font-size: 1.1rem;" href="<?php echo URLROOT; ?>/auth/register">Register/Login</a>
                                    

                                </ul>
                            </div>

                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
