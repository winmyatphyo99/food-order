<aside class="sidebar">
    <ul class="sidebar-nav">
        <li class="nav-item active"><a href="<?php echo URLROOT; ?>/CustomerController/dashboard"><i class="fas fa-chart-line"></i> Dashboard</a></li>
        <li class="nav-item"><a href="<?php echo URLROOT; ?>/Pages/menu"><i class="fas fa-utensils"></i> Explore Menu</a></li>
        <li class="nav-item"><a href="<?php echo URLROOT; ?>/OrderController/orderHistory"><i class="fas fa-file-invoice"></i> Order History</a></li>
        <li class="nav-item"><a href="<?php echo URLROOT; ?>/UserController/profile"> <i class="fas fa-cog"></i> Profile Settings</a></li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-cog"></i> Settings
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item text-black" href="<?php echo URLROOT; ?>/UserController/profile">View Profile</a></li>
                <li><a class="dropdown-item text-black" href="<?php echo URLROOT; ?>/UserController/editProfile">Edit Profile</a></li>
                <li><a class="dropdown-item text-black" href="<?php echo URLROOT; ?>/UserController/changePassword">Change Password</a></li>
               
                 <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-black" href="<?php echo URLROOT; ?>/auth/logout">Logout</a></li>
            </ul>
        </li>
        
    </ul>
</aside>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>