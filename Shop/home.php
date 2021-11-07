<?php
$stmt = $pdo->prepare('SELECT *, brand.brandname FROM products INNER JOIN brand ON products.brandid = brand.brandid ORDER BY Date_added DESC LIMIT 8');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt1 = $pdo->prepare('SELECT *, brand.brandname FROM products INNER JOIN brand ON products.brandid = brand.brandid WHERE rrp > 0 ORDER BY rrp LIMIT 8');
$stmt1->execute();
$sale_products = $stmt1->fetchAll(PDO::FETCH_ASSOC);

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

<!-- slider section -->
<section class="slider_section ">
  <div id="customCarousel1" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="container-fluid ">
          <div class="row">
            <div class="col-md-6">
              <div class="detail-box">
                <h1>
                  New iPhone 12 Pro
                </h1>
                <p>
                  Aenean scelerisque felis ut orci condimentum laoreet. Integer nisi nisl, convallis et augue sit amet, lobortis semper quam.
                </p>
                <div class="btn-box">
                  <a href="" class="btn1">
                    Contact Us
                  </a>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="img-box">
                <img src="../img/iphone-12-pro-wallpapers.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item ">
        <div class="container-fluid ">
          <div class="row">
            <div class="col-md-6">
              <div class="detail-box">
                <h1>
                  Samsung
                </h1>
                <p>
                  Aenean scelerisque felis ut orci condimentum laoreet. Integer nisi nisl, convallis et augue sit amet, lobortis semper quam.
                </p>
                <div class="btn-box">
                  <a href="" class="btn1">
                    Contact Us
                  </a>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="img-box">
                <img src="../img/cac-benh-samsung.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item ">
        <div class="container-fluid ">
          <div class="row">
            <div class="col-md-6">
              <div class="detail-box">
                <h1>
                  iPhone 12
                </h1>
                <p>
                  Aenean scelerisque felis ut orci condimentum laoreet. Integer nisi nisl, convallis et augue sit amet, lobortis semper quam.
                </p>
                <div class="btn-box">
                  <a href="" class="btn1">
                    Contact Us
                  </a>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="img-box">
                <img src="../img/iPhone-12-PNG-Pic.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <ol class="carousel-indicators">
      <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
      <li data-target="#customCarousel1" data-slide-to="1"></li>
      <li data-target="#customCarousel1" data-slide-to="2"></li>
    </ol>
  </div>
</section>
<!-- end slider section -->
</div>
<section class="shop_section layout_padding">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>
        Latest products
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
                    &dollar;<?= $product['price'] ?>
                    <?php if ($product['rrp'] > 0) : ?>
                      <del>&dollar;<?= $product['rrp'] ?></del>
                    <?php endif; ?>
                  </span>
                </h6>
              </div>
              <div class="new">
                <span>
                  New
                </span>
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

<section class="shop_section layout_padding">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>
        Sale products
      </h2>
    </div>
    <div class="row">
      <?php foreach ($sale_products as $product) : ?>
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
                    &dollar;<?= $product['price'] ?>
                    <?php if ($product['rrp'] > 0) : ?>
                      <del>&dollar;<?= $product['rrp'] ?></del>
                    <?php endif; ?>
                  </span>
                </h6>
              </div>
              <div class="new">
                <span>
                  %
                </span>
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
    <div class="btn-box">
      <a href="saleuserproduct.php">
        View All
      </a>
    </div>
  </div>
</section>
<?= template_footer() ?>