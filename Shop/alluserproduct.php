<?php
include('functions.php');
$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT *, brand.brandname FROM products INNER JOIN brand ON products.brandid = brand.brandid ORDER BY Date_added DESC');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare('SELECT * FROM brand');
$stmt2->execute();
$brands = $stmt2->fetchAll(PDO::FETCH_ASSOC);

$stmt3 = $pdo->prepare('SELECT * FROM products');
$stmt3->execute();
$products = $stmt3->fetch(PDO::FETCH_ASSOC);
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

<section class="shop_section layout_padding">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>
        All products
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