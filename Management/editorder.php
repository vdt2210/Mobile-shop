<?php
include('../Share/Services/session.php');
include('../Share/stafffunctions.php');
$con = mysqli_connect("localhost", "root", "", "mobileshop");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$orderid = $_REQUEST['orderid'];
$query = "SELECT *, orderstatus.status FROM orders INNER JOIN orderstatus ON orders.orderstatus = orderstatus.staid INNER JOIN users ON orders.userid = users.userid WHERE orderid='" . $orderid . "'";
$result = mysqli_query($con, $query) or die(mysqli_error());
$row = mysqli_fetch_assoc($result);

$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare("SELECT * FROM orderstatus");
$stmt->execute();
$or_status = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            $orderid = $_REQUEST['orderid'];
            $staid = $_REQUEST['orderstatus'];
            $update = "UPDATE orders SET orderstatus='" . $staid . "' WHERE orderid='" . $orderid . "'";
            mysqli_query($con, $update) or die(mysqli_error($con));
            $status = "Product Updated Successfully. </br></br>
<a href='allorders.php'>View Updated Record</a>";
            echo '<p style="color:#FF0000;">' . $status . '</p>';
        } else {
        ?>
            <div>
                <form name="form" method="post" action="">
                    <input type="hidden" name="new" value="1">
                    <p><input name="orderid" value="<?php echo $row['orderid']; ?>" readonly></p>
                    <p><input value="<?php echo $row['username']; ?>" readonly></p>
                    <p><input value="<?php echo $row['phone']; ?>" readonly></p>
                    <p><input value="<?php echo $row['email']; ?>" readonly></p>
                    <p><input value="<?php echo $row['address']; ?>" readonly></p>
                    <p><input value="<?php echo $row['payment_mode']; ?>" readonly></p>
                    <p><input value="<?php echo $row['paid_amount']; ?>" readonly></p>
                    <p><select name="orderstatus" style="width: 220px;">
                            <option required value="<?php echo $row['staid']; ?>">Current: <?php echo $row['status']; ?></option>
                            <?php foreach ($or_status as $orderstatus) : ?>
                                <option value="<?= $orderstatus['staid'] ?>" <?php if ($orderstatus == "staid") echo 'selected="selected"'; ?>><?= $orderstatus['status'] ?></option>
                            <?php endforeach; ?>
                        </select></p>
                    <p><input value="<?php echo $row['orderdate']; ?>" readonly></p>
                    <p><input name="submit" type="submit" value="Update" /></p>
                </form>
            <?php } ?>
            </div>
    </div>
</body>

</html>