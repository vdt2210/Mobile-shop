<?php
include('../Share/Services/session.php');
include('../Share/stafffunctions.php');
$username = "root";
$password = "";
$server   = "localhost";
$dbname   = "mobileshop";

$db = new mysqli($server, $username, $password, $dbname);

if ($db->connect_error) {
  die("Can't connect:" . $conn->connect_error);
  exit();
}

$msg = "";
$brandname = "";

if (isset($_POST['upload'])) {
  $brandimage = $_FILES['brandimage']['name'];
  $target = "./img/" . basename($brandimage);
  if (isset($_POST["brandname"])) {
    $brandname = $_POST['brandname'];
  }

  $sql = "INSERT INTO brand (brandname, brandimage)
    VALUES ('$brandname', '$brandimage')";
  mysqli_query($db, $sql);

  // if ($db->query($sql) === TRUE) {
  //     $success = "Add product successfull!!!";
  // } else {
  //     $success = "ERROR: " . $sql . "<br>" . $connect->error;
  // }
  if (move_uploaded_file($_FILES['brandimage']['tmp_name'], $target)) {
    echo '<script type="text/javascript">';
    echo 'alert("Add brand successfull!!!")';
    echo '</script>';
  } else {
    echo '<script type="text/javascript">';
    echo 'alert("Add brand failed!!!")';
    echo '</script>';
  }
}
$result = mysqli_query($db, "SELECT * FROM brand");
?>
<?= template_header() ?>
<html>
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

<body>
  <div style="text-align:center">
    <form method="POST" action="addbrand.php" enctype="multipart/form-data">
      <input type="hidden" name="size" value="1000000">
      <div>
        <table style="margin-left:auto; margin-right:auto">
          <h1 style="font-size:30px">Add brand</h1>
          <tr>
            <th style="text-align:left">Brand name:</th>
            <td><input type="text" name="brandname" value="" required></td>
          </tr>
          <tr>
            <th style="text-align:left">Image:</th>
            <td><input type="file" name="brandimage" required></td>
          </tr>
        </table>
      </div>
      <div>
        <a href="javascript:history.back()">Go back</a>
        <button type="submit" name="upload">Add brand</button>
      </div>
    </form>
  </div>
</body>

</html>