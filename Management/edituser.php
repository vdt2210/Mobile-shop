<?php
include('../Share/Services/session.php');
include('../Share/stafffunctions.php');
$con = mysqli_connect("localhost", "root", "", "mobileshop");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$profileid = $_REQUEST['profile_id'];
$query = "SELECT *, genders.gender, user.cusid FROM userprofile INNER JOIN genders ON userprofile.genderid = genders.id INNER JOIN user ON userprofile.acc_id = user.cusid where profile_id='" . $profileid . "'";
$result = mysqli_query($con, $query) or die(mysqli_error());
$row = mysqli_fetch_assoc($result);

$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare("SELECT * FROM genders WHERE id");
$stmt->execute();
$usergender = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
      $profileid = $_REQUEST['profile_id'];
      $name = $_REQUEST['name'];
      $genderid = $_REQUEST['genderid'];
      $phone = $_REQUEST['phone'];
      $email = $_REQUEST['email'];
      $address = $_REQUEST['address'];
      $password = $_REQUEST['password'];
      $update = "update userprofile, user set
name='" . $name . "', genderid='" . $genderid . "', phone='" . $phone . "', email='" . $email . "', address='" . $address . "', password='" . $password . "' where profile_id='" . $profileid . "'";
      mysqli_query($con, $update) or die(mysqli_error($con));
      $status = "User Updated Successfully. </br></br>
<a href='allusers.php'>View Updated Record</a>";
      echo '<p style="color:#FF0000;">' . $status . '</p>';
    } else {
    ?>
      <div>
        <form name="form" method="post" action="">
          <input type="hidden" name="new" value="1">
          <input name="profile_id" type="hidden" value="<?php echo $row['profile_id']; ?>">
          <p><input type="text" name="name" placeholder="Enter name" required value="<?php echo $row['name']; ?>" /></p>
          <p><select name="genderid" style="width: 220px;">
              <option required value="<?php echo $row['genderid']; ?>">Current: <?php echo $row['gender']; ?></option>
              <?php foreach ($usergender as $genders) : ?>
                <option value="<?= $genders['id'] ?>" <?php if ($genders == "id") echo 'selected="selected"'; ?>><?= $genders['gender'] ?></option>
              <?php endforeach; ?>
            </select></p>
          <p><input type="number" name="phone" placeholder="Enter new phone number" required value="<?php echo $row['phone']; ?>"></p>
          <p><input type="text" name="email" placeholder="Enter new email" required value="<?php echo $row['email']; ?>"></p>
          <p><input type="text" name="address" placeholder="Enter new address" required value="<?php echo $row['address']; ?>"></p>
          <p><input type="password" name="password" placeholder="Enter new password" required value="<?php echo $row['password']; ?>"></p>
          <p><input name="submit" type="submit" value="Update" /></p>
        </form>
      <?php } ?>
      </div>
  </div>
</body>

</html>