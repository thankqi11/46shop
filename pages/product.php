<?php
require_once __DIR__ . '/../includes/config.php';


$product_id = isset($_GET['id']) ? intval($_GET['id']) : 1;


$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if (!$product) {
    header('Location: 404.php');
    exit();
}

include '../includes/header.php'; 
?>

<main class="main-content">
  <?php include '../includes/sidebar.php'; ?>

  <section class="product-details">
    <div class="product-media-container">*Hình ảnh sản phẩm <?php echo htmlspecialchars($product['name']); ?></div>
    <div class="product-info">
      <h1 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h1>

      <div class="size-selection">
        <p>Size:</p>
        <div class="size-options">
          <?php
          $sizes = explode(',', $product['size_options']); 
          foreach ($sizes as $size) {
              echo '<span class="size-option">' . htmlspecialchars(trim($size)) . '</span>';
          }
          ?>
        </div>
      </div>
      <div class="quantity-selector">...</div>
      <div class="action-buttons">...</div>

      <h2 class="details-heading">Chi tiết sản phẩm</h2>
      <div class="details-content">
        <p><?php echo nl2br(htmlspecialchars($product['details'])); ?></p>
      </div>
    </div>
  </section>
</main>

<?php 
// footer.php chứa đóng </main>, </body>, và </html>
include '../includes/footer.php'; 
?>