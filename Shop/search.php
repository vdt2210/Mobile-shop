<?= template_header() ?>

<?php

$con = new PDO("mysql:host=localhost;dbname=mobileshop", 'root', '');

if (isset($_POST["submit"])) {
	$str = $_POST["search"];
	$sth = $con->prepare("SELECT *, brand.brandname FROM products INNER JOIN brand ON products.brandid = brand.brandid WHERE proname LIKE '%$str%'");
	$sth->setFetchMode(PDO::FETCH_OBJ);
	$sth->execute();

	$sth2 = $con->prepare("SELECT *, brand.brandname FROM products INNER JOIN brand ON products.brandid = brand.brandid WHERE brandname LIKE '%$str%'");
	$sth2->setFetchMode(PDO::FETCH_OBJ);
	$sth2->execute();

	if ($row = $sth->fetch()) {
?>
		<section class="shop_section layout_padding">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-xl-3">
						<div class="box">
							<a href="index.php?page=product&proid=<?= $row->proid ?>">
								<div class="img-box">
									<img src="../img/<?= $row->proimage ?>" width="300" height="300" alt="<?= $row->proname ?>">
								</div>
								<div class="detail-box">
									<h6>
										<?php echo $row->brandname; ?> <?php echo $row->proname; ?>
									</h6>
								</div>
								<div class="detail-box">
									<h6>
										Price:
										<span>
											&dollar;<?= $row->price ?>
											<?php if ($row->rrp > 0) : ?>
												<del>&dollar;<?= $row->rrp ?></del>
											<?php endif; ?>
										</span>
									</h6>
								</div>
							</a>
							<a href="cart.php?proid=<?= $row->proid ?>" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i>Add to cart</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php
	} elseif ($row = $sth2->fetch()) {
	?>
		<section class="shop_section layout_padding">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-xl-3">
						<div class="box">
							<a href="index.php?page=product&proid=<?= $row->proid ?>">
								<div class="img-box">
									<img src="../img/<?= $row->proimage ?>" width="300" height="300" alt="<?= $row->proname ?>">
								</div>
								<div class="detail-box">
									<h6>
										<?php echo $row->brandname; ?> <?php echo $row->proname; ?>
									</h6>
								</div>
								<div class="detail-box">
									<h6>
										Price:
										<span>
											&dollar;<?= $row->price ?>
											<?php if ($row->rrp > 0) : ?>
												<del>&dollar;<?= $row->rrp ?></del>
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
				</div>
			</div>
		</section>
	<?php
	} else {
		echo "Not found any products.";
	?>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
	}
}
?>

<?= template_footer() ?>