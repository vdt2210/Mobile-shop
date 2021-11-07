<?php
include('../Share/Services/session.php');
include('../Share/stafffunctions.php');

$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT *, brand.brandname FROM products INNER JOIN brand ON products.brandid = brand.brandid ORDER BY Date_added DESC LIMIT 5');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt1 = $pdo->prepare('SELECT * FROM brand ORDER BY brandname LIMIT 5');
$stmt1->execute();
$recently_added_brand = $stmt1->fetchAll(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare('SELECT *, users.userid, orders.products, orderstatus.staid FROM orders INNER JOIN users ON orders.userid = users.userid INNER JOIN orderstatus ON orders.orderstatus = orderstatus.staid ORDER BY orderdate DESC LIMIT 5');
$stmt2->execute();
$allorders = $stmt2->fetchAll(PDO::FETCH_ASSOC);

$usersql = "SELECT *, genders.gender FROM users INNER JOIN genders ON users.gender = genders.id ORDER BY username LIMIT 5;";
$stmt3 = $pdo->prepare($usersql);
$stmt3->execute();
$user_acc = $stmt3->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['editpro'])) {
    $proid = $_GET['editpro'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM products WHERE proid=$proid");

    if (count($record) == 1) {
        $n = mysqli_fetch_array($record);
        $proname = $n['proname'];
        $brandid = $n['brandid'];
        $descr = $n['descr'];
        $price = $n['price'];
        $rrp = $n['rrp'];
    }
}
if (isset($_GET['delpro'])) {
    $proid = $_GET['delpro'];
    mysqli_query($db, "DELETE FROM products WHERE proid=$proid");
    $_SESSION['message'] = "Product deleted!";
    header('location: welcome.php');
}

if (isset($_GET['editbrand'])) {
    $brandid = $_GET['editbrand'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM brand WHERE brandid=$brandid");

    if (count($record) == 1) {
        $n = mysqli_fetch_array($record);
        $brandname = $n['brandname'];
        $brandimage = $n['brandimage'];
    }
}
if (isset($_GET['delbrand'])) {
    $brandid = $_GET['delbrand'];
    mysqli_query($db, "DELETE FROM brand WHERE brandid=$brandid");
    $_SESSION['message'] = "Brand deleted!";
    header('location: welcome.php');
}

if (isset($_GET['editorder'])) {
    $orderid = $_GET['editorder'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM orders WHERE orderid=$orderid");

    if (count($record) == 1) {
        $n = mysqli_fetch_array($record);
        $orderstatus = $n['orderstatus'];
    }
}

if (isset($_GET['delorder'])) {
    $orderid = $_GET['delorder'];
    mysqli_query($db, "DELETE FROM orders WHERE orderid=$orderid");
    $_SESSION['message'] = "Order deleted!";
    header('location: welcome.php');
}

if (isset($_GET['deluser'])) {
    $profileid = $_GET['deluser'];
    mysqli_query($db, "DELETE FROM users WHERE userid=$userid");
    $_SESSION['message'] = "User deleted!";
    header('location: welcome.php');
}
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
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span3" id="sidebar">
                <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                    <li class="active">
                        <a href="welcome.php"><i class="icon-chevron-right"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="allproduct.php"><i class="icon-chevron-right"></i>All products</a>
                    </li>
                    <li>
                        <a href="allbrand.php"><i class="icon-chevron-right"></i>All brands</a>
                    </li>
                    <li>
                        <a href="allorders.php"><i class="icon-chevron-right"></i>All orders</a>
                    </li>
                    <li>
                        <a href="allusers.php"><i class="icon-chevron-right"></i>All users</a>
                    </li>
                </ul>
            </div>
            <!--/span-->
            <div class="span9" id="content">
                <div class="row-fluid">
                    <!-- block -->
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">Statistics</div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span3">
                                <div class="chart" data-percent="73">73%</div>
                                <div class="chart-bottom-heading"><span class="label label-info">Visitors</span>

                                </div>
                            </div>
                            <div class="span3">
                                <div class="chart" data-percent="53">53%</div>
                                <div class="chart-bottom-heading"><span class="label label-info">Page Views</span>

                                </div>
                            </div>
                            <div class="span3">
                                <div class="chart" data-percent="83">83%</div>
                                <div class="chart-bottom-heading"><span class="label label-info">Users</span>

                                </div>
                            </div>
                            <div class="span3">
                                <div class="chart" data-percent="13">13%</div>
                                <div class="chart-bottom-heading"><span class="label label-info">Orders</span>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /block -->
                </div>
                <div class="row-fluid">
                    <div class="span6">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Products</div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="stafftable">
                                        <?php if (empty($recently_added_products)) : ?>
                                            <tr>
                                                <td colspan="3" style="text-align:center;">No product added yet!</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($recently_added_products as $product) : ?>
                                                <tr>
                                                    <td>
                                                        <img src="../img/<?= $product['proimage'] ?>" width="40" height="40" alt="<?= $product['proname'] ?>"><?= $product['proname'] ?>
                                                    </td>
                                                    <td class="price">
                                                        &dollar;<?= $product['price'] ?>
                                                        <?php if ($product['rrp'] > 0) : ?>
                                                            <br><del>&dollar;<?= $product['rrp'] ?></del>
                                                        <?php endif ?>
                                                    </td>
                                                    <td style="text-align:center">
                                                        <a href="../Shop/index.php?page=product&proid=<?php echo $product['proid']; ?>" class="fas fa-info-circle"></a>
                                                        <a href="editproduct.php?proid=<?php echo $product['proid']; ?>" class="fas fa-edit"></a>
                                                        <a href="welcome.php?delpro=<?php echo $product['proid']; ?>" class="fas fa-trash-alt"></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Brands</div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</td>
                                            <th>Brand</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($recently_added_brand)) : ?>
                                            <tr>
                                                <td colspan="2" style="text-align:center;">No brand added yet!</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($recently_added_brand as $brand) : ?>
                                                <tr>
                                                    <td>
                                                        <?= $brand['brandid'] ?>
                                                    </td>
                                                    <td>
                                                        <img src="../img/<?= $brand['brandimage'] ?>" width="40" height="40" alt="<?= $brand['brandname'] ?>">
                                                        <?= $brand['brandname'] ?>
                                                    </td>
                                                    <td style="text-align:right">
                                                        <a href="welcome.php?delbrand=<?php echo $brand['brandid']; ?>" class="fas fa-trash-alt"></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span6">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Orders</div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Order date</th>
                                            <th>Product (quantity)</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($allorders)) : ?>
                                            <tr>
                                                <td colspan="6" style="text-align:center;">Don't have order yet!</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($allorders as $order) : ?>
                                                <tr>
                                                    <td><?= $order['orderdate'] ?></td>
                                                    <td><?= $order['products'] ?></td>
                                                    <td><?= $order['username'] ?></td>
                                                    <td><?= $order['phone'] ?></td>
                                                    <td><?= $order['status'] ?></td>
                                                    <td style="text-align:right">
                                                        <a href="editorder.php?orderid=<?php echo $order['orderid']; ?>" class="fas fa-edit"></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                    <div class="span6">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Users</div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($user_acc)) : ?>
                                            <tr>
                                                <td colspan="5" style="text-align:center;">No customer added yet!</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($user_acc as $user) : ?>
                                                <tr>
                                                    <td>
                                                        <?= $user['userid'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $user['username'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $user['gender'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $user['phone'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $user['address'] ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>
            </div>
            <script src="../Style/vendors/jquery-1.9.1.min.js"></script>
            <script src="../Style/bootstrap/js/bootstrap.min.js"></script>
            <script src="../Style/vendors/easypiechart/jquery.easy-pie-chart.js"></script>
            <script src="../Style/assets/scripts.js"></script>
            <script>
                $(function() {
                    // Easy pie charts
                    $('.chart').easyPieChart({
                        animate: 1000
                    });
                });
            </script>
</body>

</html>