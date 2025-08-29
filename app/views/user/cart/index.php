<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<div class="container my-5">
    <h2 class="text-center mb-4 fw-bold">Your Shopping Cart</h2>
    
    <?php if (isset($data['cart']) && !empty($data['cart'])) : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($data['cart'] as $item) : 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td>
                                <img src="<?php echo URLROOT; ?>/img/products/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 50px; height: 50px; object-fit: cover;">
                                <?php echo htmlspecialchars($item['name']); ?>
                            </td>
                            <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>$<?php echo number_format($subtotal, 2); ?></td>
                            <td>
                                <form action="<?php echo URLROOT; ?>/CartController/removeFromCart" method="POST" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <th colspan="2">$<?php echo number_format($total, 2); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="d-flex justify-content-end">
            <a href="<?php echo URLROOT; ?>/CartController/checkout" class="btn btn-warning btn-lg">Proceed to Checkout</a>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            Your cart is currently empty.
        </div>
    <?php endif; ?>
</div>

<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>