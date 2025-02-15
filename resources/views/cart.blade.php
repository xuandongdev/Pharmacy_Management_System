<?php
session_start();

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xử lý thêm sản phẩm vào giỏ hàng
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'price' => $price,
            'quantity' => $quantity
        ];
    }
    header("Location: cart.php");
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
    header("Location: cart.php");
}

// Xử lý cập nhật số lượng sản phẩm
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $product_id => $quantity) {
        $_SESSION['cart'][$product_id]['quantity'] = max(1, intval($quantity));
    }
    header("Location: cart.php");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng | Pharmacity</title>
    <link rel="stylesheet" href="">

</head>
<body>

    <div class="cart-container">
        <h2>🛒 Giỏ hàng của bạn</h2>

        <?php if (empty($_SESSION['cart'])) : ?>
            <p>Giỏ hàng của bạn đang trống. <a href="index.php">Tiếp tục mua sắm</a></p>
        <?php else : ?>
            <form method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['cart'] as $product_id => $product) : 
                            $subtotal = $product['price'] * $product['quantity'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</td>
                            <td>
                                <input type="number" name="quantities[<?php echo $product_id; ?>]" value="<?php echo $product['quantity']; ?>" min="1">
                            </td>
                            <td><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</td>
                            <td>
                                <button type="submit" name="remove_from_cart" value="1">🗑 Xóa</button>
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="cart-summary">
                    <p><strong>Tổng tiền:</strong> <?php echo number_format($total, 0, ',', '.'); ?> đ</p>
                    <button type="submit" name="update_cart">🔄 Cập nhật giỏ hàng</button>
                    <a href="checkout.php" class="checkout-btn">💳 Thanh toán</a>
                </div>
            </form>
        <?php endif; ?>
    </div>

</body>
</html>
