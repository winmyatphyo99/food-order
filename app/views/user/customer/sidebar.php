
<style>/* Sidebar Navigation */
    .sidebar {
        width: 250px;
        background-color: #2c3e50; /* Darker, professional color */
        color: #ecf0f1;
        padding: 2rem 1.5rem;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        position: fixed; /* Keep sidebar in place */
        height: 100%;
        overflow-y: auto;
    }

    .sidebar-brand {
        text-align: center;
        margin-bottom: 2rem;
    }

    .sidebar-brand h4 {
        color: #fff;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .sidebar-menu a {
        display: block;
        color: #bdc3c7;
        padding: 0.75rem 0;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease, background-color 0.3s ease;
        border-radius: 5px;
        padding-left: 1rem;
        margin-bottom: 0.5rem;
    }

    .sidebar-menu a:hover,
    .sidebar-menu a.active {
        color: #fff;
        background-color: #34495e;
    }

    .sidebar-menu a i {
        margin-right: 10px;
    }
</style>
<div class="sidebar">
        <div class="sidebar-brand">
            <h4>Food Order System</h4>
        </div>
        <ul class="sidebar-menu list-unstyled">
            <li>
                <a href="<?php echo URLROOT; ?>/user/dashboard" class="active">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?php echo URLROOT; ?>/Pages/menu">
                    <i class="fas fa-utensils"></i> Explore Menu
                </a>
            </li>
            <li>
                <a href="<?php echo URLROOT; ?>/OrderController/orderHistory">
                    <i class="fas fa-receipt"></i> Order History
                </a>
            </li>
            <li>
                <a href="<?php echo URLROOT; ?>/UserController/profile">
                    <i class="fas fa-cog"></i> Profile Settings
                </a>
            </li>
        </ul>
    </div>