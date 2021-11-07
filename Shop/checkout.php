<?php
require_once "../Share/Services/dbconfig.php";
function pdo_connect_mysql()
{
  // Update the details below with your MySQL details
  $DATABASE_HOST = 'localhost';
  $DATABASE_USER = 'root';
  $DATABASE_PASS = '';
  $DATABASE_NAME = 'mobileshop';
  try {
    return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
  } catch (PDOException $exception) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to database!');
  }
}
$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT * FROM genders');
$stmt->execute();
$all_genders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$grand_total = 0;
$allItems = "";
$items = array();

$select_stmt = $db->prepare("SELECT CONCAT(proname, '(', cartquantity, ')') AS ItemQty, total_price FROM cart JOIN products ON cart.proid=products.proid");
$select_stmt->execute();
while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
  $grand_total = $grand_total + $row["total_price"];
  $items[] = $row["ItemQty"];
}
$allItems = implode(", ", $items);

?>

<?= template_header() ?>

<div class="container">

  <div class="row justify-content-center">
    <div class="col-lg-6 px-4 pb-4" id="showOrder">

      <h4 class="text-center text-info p-2">Your information</h4>
      <div class="jumbotron p-3 mb-2 text-center">
        <h6 class="load"><b>Product(Quantity): </b> <?php echo $allItems; ?></h6>
        <h5><b>Total amount: </b><?php echo number_format($grand_total, 2) ?> </h5>
      </div>

      <form method="post" id="placeOrder">

        <input type="hidden" name="products" value="<?php echo $allItems ?>">
        <input type="hidden" name="grand_total" value="<?php echo $grand_total ?>">

        <div class="form-group">
          <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
        </div>

        <div class="form-group">
          <select class="form-control" name="gender">
            <?php foreach ($all_genders as $genders) : ?>
              <option value="<?= $genders['id'] ?>" <?php if ($genders == "id") echo 'selected="selected"'; ?>><?= $genders['gender'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <input type="email" name="email" class="form-control" placeholder="Enter your email">
        </div>

        <div class="form-group">
          <input type="tel" name="phone" class="form-control" placeholder="Enter your phone" required>
        </div>

        <div class="form-group">
          <input name="address" class="form-control" placeholder="Enter your address" required></input>
        </div>

        <h6 class="text ">Select payment</h6>
        <div class="form-group">
          <select name="pmode" class="form-control">
            <option value="cod">Cash On Delivery (COD)</option>
            <option value="internetbanking">Internet Banking</option>
            <option value="crecard">Debit/credit Card</option>
          </select>
        </div>

        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-danger btn-block" value="Confirm">
        </div>
      </form>
    </div>
  </div>
</div>
<?= template_footer() ?>