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
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
     <!-- Header -->
    <!-- Banner trên cùng -->
    <div class="top-banner">
        <img src="../images/header+footer/pharmacity-baner.png" alt="Banner quảng cáo">
    </div>

    <!-- Header chính -->
    <header class="header">
        <div class="header-top">
            <div class="left">
                <i class="fas fa-qrcode"></i> Tải ứng dụng
            </div>
            <div class="right">
                <span>Tiếng Việt 🇻🇳</span> |
                <span>Hotline <strong>1800 6821</strong></span> |
                <span>Doanh nghiệp</span> |
                <span class="new-tag">NEW</span> Deal hot tháng 2 🔥 |
                <span class="new-tag">NEW</span> Tra cứu đơn hàng
            </div>
        </div>

        <!-- Thanh tìm kiếm -->
        <div class="header-main">
            <div class="logo">
                <img src="../images/header+footer/pharmacity-logo.png" alt="Pharmacity Logo">
            </div>
            <div class="search-box">    
                <input type="text" placeholder="Tên thuốc, triệu chứng, vitamin và thực phẩm chức năng">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="icons">
                <i class="fas fa-shopping-cart"></i>
                <button class="login-btn">Đăng nhập/ Đăng ký</button>
            </div>
        </div>

        <!-- Thanh menu -->
        <nav class="nav">
            <button class="menu-btn"><i class="fas fa-bars"></i> Danh mục</button>
            <ul>
                <li>Thuốc</li>
                <li>Tra cứu bệnh</li>
                <li>Thực phẩm chức năng</li>
                <li>Mẹ và bé</li>
                <li>Doanh nghiệp <span class="new-tag">NEW</span></li>
                <li class="hot">Nhãn hàng Pharmacity</li>
                <li>Chăm sóc cá nhân</li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <header class="header">
            <img src="https://www.pharmacity.vn/wp-content/themes/pharmacity/images/logo.svg" class="logo" alt="Pharmacity">
            <div class="cart-steps">
                <div class="step active">
                    <div class="step-number">1</div>
                    Giỏ hàng
                </div>
                <div style="margin: 0 10px">›</div>
                <div class="step">
                    <div class="step-number">2</div>
                    Thanh toán
                </div>
            </div>
        </header>

        <div class="main-content">
            <div class="cart-items">
                <div class="cart-header">
                    <h3>Giỏ hàng của bạn (2 sản phẩm)</h3>
                    <div class="price-header">Thành tiền</div>
                </div>

                <!-- Item 1 -->
                <div class="cart-item">
                    <i class="fas fa-times remove-btn"></i>
                    <img src="../images/Medicines/Viên uống Pharmacity Vitamin C 1000mg + Zinc & Rosehip hỗ trợ sức đề kháng (60 viên).avif" class="product-image" alt="Product">
                    <div class="product-info">
                        <h4 class="product-title">Viên uống Vitamin C 1000mg Hộp 100 Viên</h4>
                        <div class="product-sku">Mã SP: PC12345</div>
                        <div class="price-container">
                            <div class="quantity-control">
                                <button class="qty-btn">-</button>
                                <input type="number" class="qty-input" value="1" min="1">
                                <button class="qty-btn">+</button>
                            </div>
                            <div class="product-price">150.000đ</div>
                        </div>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="cart-item">
                    <i class="fas fa-times remove-btn"></i>
                    <img src="../images/Medicines/Nước Rửa Tay Khô 70ml.avif" class="product-image" alt="Product">
                    <div class="product-info">
                        <h4 class="product-title">Nước Rửa Tay Khô 70ml</h4>
                        <div class="product-sku">Mã SP: PC67890</div>
                        <div class="price-container">
                            <div class="quantity-control">
                                <button class="qty-btn">-</button>
                                <input type="number" class="qty-input" value="2" min="1">
                                <button class="qty-btn">+</button>
                            </div>
                            <div class="product-price">90.000đ</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-summary">
                <h3 class="summary-title">Tóm tắt đơn hàng</h3>
                
                <div class="promo-section">
                    <i class="fas fa-tag"></i>
                    Nhập mã giảm giá
                </div>

                <div class="summary-row">
                    <span>Tạm tính:</span>
                    <span>240.000đ</span>
                </div>
                
                <div class="summary-row">
                    <span>Giảm giá:</span>
                    <span>-0đ</span>
                </div>
                
                <div class="summary-row">
                    <span>Phí vận chuyển:</span>
                    <span>30.000đ</span>
                </div>
                
                <div class="summary-row total-row">
                    <span>Tổng cộng:</span>
                    <span style="color: var(--primary-color)">270.000đ</span>
                </div>

                <button class="checkout-btn">TIẾN HÀNH THANH TOÁN</button>

                <div style="margin-top: 20px; font-size: 12px; color: #666; text-align: center">
                    <i class="fas fa-lock"></i> Thanh toán an toàn & bảo mật
                </div>
            </div>
        </div>
    </div>
     <!-- Footer -->
     <footer class="pharmacity-footer">
        <div class="footer-content">
            <div class="footer-column">
                <h4>Về Pharmacity</h4>
                <ul class="footer-links">
                    <li class="footer-link"><a href="#">Giới thiệu</a></li>
                    <li class="footer-link"><a href="#">Tuyển dụng</a></li>
                    <li class="footer-link"><a href="#">Hệ thống cửa hàng</a></li>
                    <li class="footer-link"><a href="#">Tin tức</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Chính sách</h4>
                <ul class="footer-links">
                    <li class="footer-link"><a href="#">Bảo mật thông tin</a></li>
                    <li class="footer-link"><a href="#">Chính sách vận chuyển</a></li>
                    <li class="footer-link"><a href="#">Chính sách đổi trả</a></li>
                    <li class="footer-link"><a href="#">Điều khoản sử dụng</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Hỗ trợ</h4>
                <ul class="footer-links">
                    <li class="footer-link"><a href="#">Câu hỏi thường gặp</a></li>
                    <li class="footer-link"><a href="#">Hướng dẫn đặt hàng</a></li>
                    <li class="footer-link"><a href="#">Liên hệ: 1800 6821</a></li>
                    <li class="footer-link"><a href="#">Email: cskh@pharmacity.vn</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Kết nối với chúng tôi</h4>
                <div class="social-media">
                    <a href="../images/header+footer/face-logo.png"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                </div>
                
                <div class="payment-methods">
                    <img src="../images/header+footer/VISA.png" alt="Visa">
                    <img src="../images/header+footer/MASTERCARD.png" alt="Mastercard">
                    <img src="../images/header+footer/MOMO.png" alt="Momo">
                    <img src="../images/header+footer/ZALO.png" alt="ZaloPay">
                    <img src="../images/header+footer/COD.png" alt="ZaloPay">
                    <img src="../images/header+footer/JCB.png" alt="ZaloPay">
                    <img src="../images/header+footer/NAPAS.png" alt="ZaloPay">
                    <img src="../images/header+footer/PAY.png" alt="ZaloPay">
                </div>
            </div>
        </div>

        <div class="copyright">
            © 2023 Công ty Cổ phần Pharmacity. GPKD số 0104134543 do Sở KHĐT TP. Hà Nội cấp ngày 12/09/2019
        </div>
    </footer>
</body>
</html>
