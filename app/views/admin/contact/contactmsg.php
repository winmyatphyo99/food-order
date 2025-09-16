<?php require_once APPROOT . '/views/inc/header.php'; ?>

<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php'; ?>

    <main class="main-content">
       <?php require_once APPROOT . '/views/inc/admin_logo.php'; ?>

        <div class="content-area">
            <div class="container-fluid my-5">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <h4 class="mb-3 mb-md-0 text-dark fw-bold"><i class="fas fa-envelope me-2 text-primary"></i> Contact Messages</h4>
                </div>

                <?php require APPROOT . '/views/components/auth_message.php'; ?>

                <div class="card shadow-lg rounded-4 border-0">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <?php if (!empty($data['messages'])): ?>
                                <table class="table table-hover align-middle">
                                    <thead class="text-uppercase text-muted">
                                        <tr>
                                            <th scope="col" style="width: 5%;">ID</th>
                                            <th scope="col" style="width: 15%;">Name</th>
                                            <th scope="col" style="width: 20%;">Email</th>
                                            <th scope="col" style="width: 15%;">Subject</th>
                                            <th scope="col" style="width: 30%;">Message</th>
                                            <th scope="col" style="width: 15%;">Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['messages'] as $msg): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($msg['id']); ?></td>
                                                <td><?= htmlspecialchars($msg['name']); ?></td>
                                                <td><?= htmlspecialchars($msg['email']); ?></td>
                                                <td><?= htmlspecialchars($msg['subject']); ?></td>
                                                <td>
                                                    <p class="text-truncate mb-0" style="max-width: 400px;"><?= htmlspecialchars($msg['message']); ?></p>
                                                </td>
                                                <td><?= htmlspecialchars($msg['created_at']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="alert alert-info text-center py-5 rounded-4 border-0" role="alert">
                                    <i class="fas fa-info-circle me-2"></i> No messages found.
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if (isset($data['pagination']) && $data['pagination']['totalPages'] > 1): ?>
                            <nav aria-label="Contact Messages Page Navigation" class="mt-4">
                                <ul class="pagination justify-content-center">
                                    <?php
                                    $currentPage = $data['pagination']['currentPage'];
                                    $totalPages = $data['pagination']['totalPages'];
                                    $urlRoot = URLROOT . '/AdminContactController/index';
                                    ?>
                                    
                                    <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?= $urlRoot; ?>?page=<?= $currentPage - 1; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?= ($i == $currentPage) ? 'active' : ''; ?>">
                                            <a class="page-link" href="<?= $urlRoot; ?>?page=<?= $i; ?>">
                                                <?= $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?= $urlRoot; ?>?page=<?= $currentPage + 1; ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>
