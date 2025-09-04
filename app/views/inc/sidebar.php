<aside class="sidebar">
    <ul class="sidebar-nav">
        <li class="nav-item active"><a href="<?php echo URLROOT; ?>/AdminController/dashboard"><i class="fas fa-chart-line"></i> Dashboard</a></li>
        <li class="nav-item"><a href="<?php echo URLROOT; ?>/CategoryController/index"><i class="fas fa-utensils"></i> Manage Category</a></li>
        <li class="nav-item"><a href="<?php echo URLROOT; ?>/ProductController/index"><i class="fas fa-file-invoice"></i> Manage Products</a></li>
        <li class="nav-item"><a href="<?php echo URLROOT; ?>/OrderController/index"><i class="fas fa-users"></i> Manage Orders</a></li>
        <li class="nav-item"><a href="<?php echo URLROOT; ?>/AdminController/pending"><i class="fas fa-users"></i> Pending Orders</a></li>
        <li class="nav-item"><a href="<?php echo URLROOT; ?>/AdminController/completed"><i class="fas fa-users"></i> Confirm Orders</a></li>
        <li class="nav-item"><a href="<?php echo URLROOT; ?>/InvoiceController/index"><i class="fas fa-receipt"></i> View Invoices</a></li>
        <li class="nav-item"><a href="<?php echo URLROOT; ?>/UserController/index"><i class="fas fa-receipt"></i> Customer Lists</a></li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-cog"></i> Settings
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item text-black" href="<?php echo URLROOT; ?>/AdminController/profile">View Profile</a></li>
                <li><a class="dropdown-item text-black" href="<?php echo URLROOT; ?>/AdminController/editProfile">Edit Profile</a></li>
               
                 <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-black" href="<?php echo URLROOT; ?>/auth/logout">Logout</a></li>
            </ul>
        </li>
    </ul>
</aside>
<style>
/* Custom CSS to center the dropdown menu */
.sidebar .nav-item .dropdown-menu {
  left: 20% !important;
  transform: translateX(-50%);
}
.dropdown-menu .dropdown-item:hover,
.dropdown-menu .dropdown-item:focus {
  background-color: #f8f9fa; /* Light grey background on hover */
  color: #000; /* Darken the text color on hover */
}</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>