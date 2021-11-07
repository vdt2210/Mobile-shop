<?php
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['proid'])) {
  // Prepare statement and execute, prevents SQL injection
  $stmt = $pdo->prepare('SELECT *, brand.brandname FROM products INNER JOIN brand ON products.brandid = brand.brandid WHERE proid = ?');
  $stmt->execute([$_GET['proid']]);
  // Fetch the product from the database and return the result as an Array
  $product = $stmt->fetch(PDO::FETCH_ASSOC);
  // Check if the product exists (array is not empty)
  if (!$product) {
    // Simple error to display if the id for the product doesn't exists (array is empty)
    exit('Product does not exist!');
  }
} else {
  // Simple error to display if the id wasn't specified
  exit('Product does not exist!');
}
$stmt = $pdo->prepare('SELECT *, brand.brandname FROM products INNER JOIN brand ON products.brandid = brand.brandid ORDER BY Date_added DESC LIMIT 8');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<?= template_header() ?>

<div style="display:<?php if (isset($_SESSION["showAlert"])) {
                      echo $_SESSION["showAlert"];
                    } else {
                      echo "none";
                    }
                    unset($_SESSION["showAlert"]) ?>" class="alert alert-success alert-dismissible mt-2">

  <button type="button" class="close" data-dismiss="alert">&times;</button>

  <strong><?php if (isset($_SESSION["message"])) {
            echo $_SESSION["message"];
          }
          unset($_SESSION["showAlert"]); ?></strong>
</div>

<div class="container bootstrap snippets bootdey">
  <div class="row">
    <div class="col-sm-6 push-bit">
      <img src="../img/<?= $product['proimage'] ?>" width="300" height="300" alt="<?= $product['proname'] ?>">
    </div>
    <div class="col-sm-6 push-bit">
      <div class="clearfix">
        <div class="pull-right">
          <span class="price">
            &dollar;<?= $product['price'] ?>
            <?php if ($product['rrp'] > 0) : ?>
              <span class="rrp" style="text-decoration:line-through">&dollar;<?= $product['rrp'] ?></span>
            <?php endif; ?>
          </span>
        </div>
        <span class="h4">
          <strong class="text-success"><?= $product['brandname'] ?> <?= $product['proname'] ?></strong><br />
        </span>
      </div>
      <hr />
      <?php if ($product['descr'] < 0) : ?>
        <p>No information</p>
      <?php elseif ($product['descr'] > 0) : ?>
        <?= $product['descr'] ?>
      <?php endif; ?>
      <hr />
      <!-- <a href="cart.php?proid=<?= $product['proid'] ?>" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i>Add to cart</a> -->
      <form class="form-submit" style="text-align:right">
        <input type="hidden" class="pid" value="<?= $product['proid'] ?>">
        <input type="hidden" class="pname" value="<?= $product['proname'] ?>">
        <input type="hidden" class="pprice" value="<?= $product['price'] ?>">
        <input type="hidden" class="pimage" value="<?= $product['proimage'] ?>">
        <button id="addItem" class="btn btn-success btn-md"><i class="fa fa-shopping-cart"></i> Add to cart</button>
      </form>
    </div>
  </div>
</div>
<section class="shop_section layout_padding">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>
        Suggestion products
      </h2>
    </div>
    <div class="row">
      <?php foreach ($recently_added_products as $product) : ?>
        <div class="col-sm-6 col-xl-3">
          <div class="box">
            <a href="index.php?page=product&proid=<?= $product['proid'] ?>">
              <div class="img-box">
                <img src="../img/<?= $product['proimage'] ?>" width="300" height="300" alt="<?= $product['proname'] ?>">
              </div>
              <div class="detail-box">
                <h6>
                  <?= $product['brandname'] ?> <?= $product['proname'] ?>
                </h6>
              </div>
              <div class="detail-box">
                <h6>
                  Price:
                  <span>
                    <?php if ($product['rrp'] == 0) : ?>
                      &dollar;<?= $product['price'] ?>
                    <?php elseif ($product['rrp'] > 0) : ?>
                      <div class="new">
                        <span>
                          %
                        </span>
                      </div>
                      &dollar;<?= $product['price'] ?>
                      <del>&dollar;<?= $product['rrp'] ?></del>
                    <?php endif; ?>
                  </span>
                </h6>
              </div>
            </a>
            <form class="form-submit" style="text-align:center">
              <input type="hidden" class="pid" value="<?= $product['proid'] ?>">
              <input type="hidden" class="pname" value="<?= $product['proname'] ?>">
              <input type="hidden" class="pprice" value="<?= $product['price'] ?>">
              <input type="hidden" class="pimage" value="<?= $product['proimage'] ?>">
              <button id="addItem" class="btn btn-md"><i class="fa fa-shopping-cart"></i> Add to cart</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?= template_footer() ?>