<aside class="sidebar">
    <ul class="sidebar-nav">
        <li class="nav-item active"><a href="<?php echo URLROOT; ?>/CustomerController/dashboard"><i class="fas fa-chart-line"></i> Dashboard</a></li>
        <li class="nav-item"><a href="<?php echo URLROOT; ?>/Pages/menu"><i class="fas fa-utensils"></i> Explore Menu</a></li>
        <li class="nav-item"><a href="<?php echo URLROOT; ?>/OrderController/orderHistory"><i class="fas fa-file-invoice"></i> Order History</a></li>
       
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-cog"></i>Profile Settings
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item text-black" href="<?php echo URLROOT; ?>/UserController/profile">View Profile</a></li>
                <li><a class="dropdown-item text-black" href="<?php echo URLROOT; ?>/UserController/editProfile">Edit Profile</a></li>
                <li><a class="dropdown-item text-black" href="<?php echo URLROOT; ?>/UserController/changePassword">Change Password</a></li>
               
                 <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-black" href="<?php echo URLROOT; ?>/auth/logout">Logout</a></li>
            </ul>
        </li>
        <style>
            /* General Dropdown Container */
.dropdown-menu {
    --bs-dropdown-min-width: 220px;
    border-radius: 1rem;
    padding: 0.75rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: none;
    transition: all 0.3s ease-in-out;
    background-color: var(--card-bg);
}

/* Dropdown Toggler Button */
.nav-link.dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--text-dark);
    transition: color 0.3s ease, transform 0.2s ease;
}

.nav-link.dropdown-toggle i {
    font-size: 1.25rem;
    color: var(--primary-color);
}

.nav-link.dropdown-toggle:hover {
    color: var(--primary-color);
    transform: translateY(-2px);
}

/* Individual Dropdown Items */
.dropdown-item {
    font-size: 1rem;
    font-weight: 500;
    padding: 0.75rem 1rem;
    margin-bottom: 0.5rem;
    border-radius: 0.75rem;
    transition: all 0.2s ease;
    color: var(--text-dark) !important;
}

/* Hover and Focus States for Dropdown Items */
.dropdown-item:hover,
.dropdown-item:focus {
    background-color: var(--bg-light);
    color: var(--primary-color) !important;
    transform: translateX(5px);
}

/* Divider Line */
.dropdown-divider {
    margin: 0.5rem 0;
    border-top: 1px solid var(--border-color);
}


        </style>
        
    </ul>
</aside>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>