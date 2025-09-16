<?php require_once APPROOT . '/views/inc/header.php'; ?>
<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php'; ?>
    
    <main class="main-content">
        <?php require_once APPROOT . '/views/inc/admin_logo.php'; ?>

        <div class="content-area">
            <div class="container my-5">
                <h3 class="mb-4">My Account</h3>
                
                <div class="card shadow-sm p-4 mx-auto" style="max-width:600px;">
                    
                    <div class="tab-content" id="myProfileTabContent">
                        
                        <div class="tab-pane fade show active" id="view-profile" role="tabpanel" aria-labelledby="view-profile-tab">
                            <h5 class="card-title text-center mt-4 mb-4">Profile Information</h5>
                            <div class="text-center mb-4">
                                <img src="<?php 
                                    echo !empty($data['user']->profile_image) 
                                        ? URLROOT . '/uploads/profile/' . htmlspecialchars($data['user']->profile_image) 
                                        : URLROOT . '/uploads/profile/default_profile.jpg';
                                ?>" 
                                alt="Profile" class="rounded-circle border shadow-sm" 
                                style="width:120px; height:120px; object-fit:cover;">
                                <h5 class="mt-3"><?php echo htmlspecialchars($data['user']->name); ?></h5>
                                <small class="text-muted"><?php echo htmlspecialchars($data['user']->email); ?></small>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="text-end" style="width: 30%;">Name:</th>
                                            <td><?php echo htmlspecialchars($data['user']->name); ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-end">Email:</th>
                                            <td><?php echo htmlspecialchars($data['user']->email); ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-end">Phone:</th>
                                            <td><?php echo htmlspecialchars($data['user']->phone_number); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>