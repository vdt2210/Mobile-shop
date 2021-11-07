<?php
include('../Share/Services/session.php');
include('../Share/stafffunctions.php');
$con = mysqli_connect("localhost", "root", "", "mobileshop");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$proid = $_REQUEST['proid'];
$query = "SELECT *, brand.brandname FROM products INNER JOIN brand ON products.brandid = brand.brandid WHERE proid='" . $proid . "'";
$result = mysqli_query($con, $query) or die(mysqli_error());
$row = mysqli_fetch_assoc($result);

$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare("SELECT * FROM brand");
$stmt->execute();
$allbrands = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header() ?>

<body>
  <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <a class="brand" href="welcome.php">Admin Panel</a>
        <div class="nav-collapse collapse">
          <ul class="nav pull-right">
            <li class="dropdown">
              <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i>Hello <?php echo $login_session; ?> <i class="caret"></i>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a tabindex="-1" href="logout.php">Logout</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!--/.nav-collapse -->
      </div>
    </div>
  </div>
  <div class="form" style="text-align:center">
    <?php
    $status = "";
    if (isset($_POST['new']) && $_POST['new'] == 1) {
      $proid = $_REQUEST['proid'];
      $brandid = $_REQUEST['brandid'];
      $proname = $_REQUEST['proname'];
      $descr = $_REQUEST['descr'];
      $price = $_REQUEST['price'];
      $rrp = $_REQUEST['rrp'];
      $proimage = $_REQUEST['proimage'];
      $update = "UPDATE products SET brandid='" . $brandid . "', proname='" . $proname . "', descr='" . $descr . "', price='" . $price . "', rrp='" . $rrp . "', proimage='" . $proimage . "' where proid='" . $proid . "'";
      mysqli_query($con, $update) or die(mysqli_error($con));
      $status = "Product Updated Successfully. </br></br>
<a href='allproduct.php'>View Updated Record</a>";
      echo '<p style="color:#FF0000;">' . $status . '</p>';
    } else {
    ?>
      <div>
        <form name="form" method="post" action="">
          <input type="hidden" name="new" value="1">
          <input name="proid" type="hidden" value="<?php echo $row['proid']; ?>">
          <p><select name="brandid" style="width: 220px;">
              <option required value="<?php echo $row['brandid']; ?>">Current: <?php echo $row['brandname']; ?></option>
              <?php foreach ($allbrands as $brand) : ?>
                <option value="<?= $brand['brandid'] ?>" <?php if ($brand == "brandid") echo 'selected="selected"'; ?>><?= $brand['brandname'] ?></option>
              <?php endforeach; ?>
            </select></p>
          <p><input type="text" name="proname" placeholder="Enter new product name" required value="<?php echo $row['proname']; ?>"></p>
          <p><input type="text" name="descr" placeholder="Enter new description" value="<?php echo $row['descr']; ?>"></p>
          <p><input type="number" name="price" placeholder="Enter new price" min=1 required value="<?php echo $row['price']; ?>"></p>
          <p><input type="number" name="rrp" placeholder="Enter new rrp" required value="<?php echo $row['rrp']; ?>"></p>
          <p><img src="../img/<?php echo $row['proimage']; ?>" hight=300 width=300></p>
          <p><input type="file" name="proimage"></p>
          <p><input type="text" name="proimage" style="display:none" value="<?php echo $row['proimage']; ?>"></p>
          <p><input name="submit" type="submit" value="Update" /></p>
        </form>
      <?php } ?>
      </div>
  </div>
</body>

</html>