<?php
include('../Share/Services/session.php');
include('../Share/stafffunctions.php');
$db = mysqli_connect("localhost", "root", "", "mobileshop");
if ($db->connect_error) {
  die("Can't connect:" . $conn->connect_error);
  exit();
}

$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT * FROM brand ORDER BY brandname');
$stmt->execute();
$recently_added_brand = $stmt->fetchAll(PDO::FETCH_ASSOC);

$msg = "";
$brandid = "";
$proname = "";
$descr = "";
$price = "";
$rrp = "";

if (isset($_POST['upload'])) {
  $proimage = $_FILES['proimage']['name'];
  $target = "../img/" . basename($proimage);
  if (isset($_POST["brandid"])) {
    $brandid = $_POST['brandid'];
  }
  if (isset($_POST["proname"])) {
    $proname = $_POST['proname'];
  }
  if (isset($_POST["descr"])) {
    $descr = $_POST['descr'];
  }
  if (isset($_POST["price"])) {
    $price = $_POST['price'];
  }
  if (isset($_POST["rrp"])) {
    $rrp = $_POST['rrp'];
  }

  $sql = "INSERT INTO products (brandid, proname, descr, price, rrp, proimage)
  VALUES ('$brandid', '$proname', '$descr', '$price', '$rrp', '$proimage')";
  mysqli_query($db, $sql);

  if (move_uploaded_file($_FILES['proimage']['tmp_name'], $target)) {
    echo '<script type="text/javascript">';
    echo 'alert("Add product successfull!!!")';
    echo '</script>';
  } else {
    echo '<script type="text/javascript">';
    echo 'alert("Add product failed!!!")';
    echo '</script>';
  }
}
$result = mysqli_query($db, "SELECT * FROM products");
?>
<?= template_header() ?>
<!DOCTYPE html>
<html>

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
  <div style="text-align:center">
    <form method="POST" action="addproduct.php" enctype="multipart/form-data">
      <input type="hidden" name="size" value="1000000">
      <div>
        <table style="margin-left:auto; margin-right:auto">
          <h1 style="font-size:30px">Add product</h1>
          <tr>
            <th style="text-align:left">Brand:</th>
            <td>
              <select name="brandid" style="width: 220px;">
                <option value="0">Please Select Option</option>
                <?php foreach ($recently_added_brand as $brand) : ?>
                  <option value="<?= $brand['brandid'] ?>" <?php if ($brand == "brandid") echo 'selected="selected"'; ?>><?= $brand['brandname'] ?></option>
                <?php endforeach; ?>
              </select>
            </td>
          </tr>
          <tr>
            <th style="text-align:left">Product name:</th>
            <td><input type="text" name="proname" value="" required></td>
          </tr>

          <tr>
            <th style="text-align:left">Description:</th>
            <td><input type="text" name="descr" value=""></td>
          </tr>

          <tr>
            <th style="text-align:left">Current price:</th>
            <td><input type="number" name="price" min="1" value="" required></td>
          </tr>

          <tr>
            <th style="text-align:left">Old price:</th>
            <td><input type="number" name="rrp" min="0" value="0"></td>
          </tr>

          <tr>
            <th style="text-align:left">Image:</th>
            <td><input type="file" name="proimage" required></td>
          </tr>
        </table>
      </div>
      <div>
        <a href="javascript:history.back()">Go back</a>
        <button type="submit" name="upload">Add product</button>
      </div>
    </form>
  </div>
</body>

</html>