<?php require_once APPROOT . '/views/user/inc/header.php'; ?>
<?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>

 <div class="container my-5">
     <h2 class="text-center mb-4 fw-bold">Checkout</h2>
     <div class="row">
         <div class="col-md-7">
             <div class="card shadow mb-4">
                 <div class="card-header py-3">
                     <h6 class="m-0 font-weight-bold text-primary">Shipping Details</h6>
                 </div>
                 <div class="card-body">
                     <form action="<?php echo URLROOT; ?>/CartController/placeOrder" method="POST">
                         <div class="mb-3">
                             <label for="name" class="form-label">Full Name</label>
                             <input type="text" class="form-control" id="name" name="name" required value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>">
                         </div>
                         <div class="mb-3">
                             <label for="email" class="form-label">Email</label>
                             <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : ''; ?>">
                         </div>
                         <div class="mb-3">
                             <label for="delivery_address" class="form-label">Shipping Address</label>
                             <textarea class="form-control" id="delivery_address" name="delivery_address" rows="3" required ></textarea>
                         </div>
                         <div class="mb-3">
                             <label for="phone_number" class="form-label">Phone Number</label>
                             <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo isset($data['user_phone_number']) ? htmlspecialchars($data['user_phone_number']): ''; ?>">
                         </div>
 
                         <div class="mb-3">
                             <h6 class="font-weight-bold text-primary">Payment Method</h6>
                             <?php if(isset($data['payments']) && is_array($data['payments'])): ?>
                             <?php foreach ($data['payments'] as $payment) : ?>
                             <div class="form-check">
                                 <input class="form-check-input" type="radio" name="payment_method_id" id="payment-<?php echo htmlspecialchars($payment['id']); ?>" value="<?php echo htmlspecialchars($payment['id']); ?>"<?php echo ($payment['id'] == 1 ) ? 'checked' : '' ;?>>
                                 <label class="form-check-label" for="payment-<?php echo htmlspecialchars($payment['id']); ?>">
                                    <?php echo htmlspecialchars($payment['payment_name']); ?>
                                    </label>
                             </div>
                             <?php endforeach; ?>
                             <?php else: ?>
                                <p class="text-danger">No Payments Available.</p>
                             <?php endif;?>
                         </div>
 
                         <hr class="my-4">
                         <button type="submit" class="btn btn-warning btn-lg w-100">Place Order</button>
                     </form>
                 </div>
             </div>
         </div>
 
     <div class="col-md-5">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">Order Summary</h6>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush mb-3">
                <?php if (isset($data['cart']) && is_array($data['cart'])): ?>
                    <?php foreach ($data['cart'] as $item) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="my-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                                <small class="text-muted">Qty: <?php echo htmlspecialchars($item['quantity']); ?> x $<?php echo htmlspecialchars($item['price']); ?></small>
                            </div>
                            <span class="text-muted">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>

            <hr>
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td class="text-right"><strong>Subtotal:</strong></td>
                        <td class="text-right">$<?php echo htmlspecialchars(number_format($data['subtotal'], 2)); ?></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Delivery Fee:</strong></td>
                        <td class="text-right">$<?php echo htmlspecialchars(number_format($data['delivery_fee'], 2)); ?></td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Tax (5%):</strong></td>
                        <td class="text-right">$<?php echo htmlspecialchars(number_format($data['tax_amount'], 2)); ?></td>
                    </tr>
                    <tr class="table-active">
                        <td class="text-right"><strong>Grand Total:</strong></td>
                        <td class="text-right"><strong>$<?php echo htmlspecialchars(number_format($data['grand_total'], 2)); ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
     </div>
 </div>
 <?php require_once APPROOT . '/views/user/inc/footer.php'; ?>