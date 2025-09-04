<header class="top-header">
    <div class="header-left">
        <a href="#" class="logo-link">Admin Dashboard</a>
    </div>

    <div class="header-right">
         <span>
            Welcome,
            <strong>
                <?php
                if (isset($_SESSION['user_name'])) {
                    echo htmlspecialchars($_SESSION['user_name']);
                } else {
                    echo 'Guest';
                }
                ?>!
            </strong>
        </span>
        <?php if (isset($_SESSION['user_id'])) : ?>
            <img src="<?php
                        echo !empty($_SESSION['profile_image'])
                            ? URLROOT . '/uploads/profile/' . htmlspecialchars($_SESSION['profile_image'])
                            : URLROOT . '/uploads/profile/default_profile.jpg';
                        ?>"
                alt="Admin Profile" class="rounded-circle"
                style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">

        <?php endif; ?>

       

        <a href="<?php echo URLROOT; ?>/auth/logout" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</header>