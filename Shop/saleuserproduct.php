<?php
include('functions.php');
$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT * FROM products INNER JOIN brand ON products.brandid = brand.brandid WHERE rrp != 0 ORDER BY rrp DESC');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?=template_header()?>
<section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Sale products
        </h2>
      </div>
      <div class="row">
        <?php foreach ($recently_added_products as $product): ?>
        <div class="col-sm-6 col-xl-3">
          <div class="box">
            <a href="index.php?page=product&proid=<?=$product['proid']?>">
              <div class="img-box">
                <img src="../img/<?=$product['proimage']?>" width="300" height="300" alt="<?=$product['proname']?>">
              </div>
              <div class="detail-box">
                <h6>
                  <?=$product['brandname']?> <?=$product['proname']?>
                </h6>
              </div>
              <div class="detail-box">
                <h6>
                  Price:
                  <span>
                    <?php if ($product['rrp'] == 0):?>
                        &dollar;<?=$product['price']?>
                    <?php elseif ($product['rrp'] > 0): ?>
                        <div class="new">
                            <span>
                            %
                            </span>
                        </div>
                        &dollar;<?=$product['price']?>
                        <del>&dollar;<?=$product['rrp']?></del>
                    <?php endif; ?>
                  </span>
                </h6>
              </div>
              
            </a>
            <a href="cart.php?proid=<?=$product['proid']?>" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i>Add to cart</a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?=template_footer()?>