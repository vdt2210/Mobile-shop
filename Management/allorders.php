<?php
include('../Share/Services/session.php');
include('../Share/stafffunctions.php');
$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT *, users.userid, orders.products, orderstatus.staid FROM orders INNER JOIN users ON orders.userid = users.userid INNER JOIN orderstatus ON orders.orderstatus = orderstatus.staid ORDER BY orderdate DESC LIMIT 5');
$stmt->execute();
$allorders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['delorder'])) {
    $orderid = $_GET['delorder'];
    mysqli_query($db, "DELETE FROM orders WHERE orderid=$orderid");
    $_SESSION['message'] = "Order deleted!";
    header('location: allorders.php');
}
?>
<?= template_header() ?>
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
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span3" id="sidebar">
                <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                    <li>
                        <a href="welcome.php"><i class="icon-chevron-right"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="allproduct.php"><i class="icon-chevron-right"></i>All products</a>
                    </li>
                    <li>
                        <a href="allbrand.php"><i class="icon-chevron-right"></i>All brands</a>
                    </li>
                    <li class="active">
                        <a href="allorders.php"><i class="icon-chevron-right"></i>All orders</a>
                    </li>
                    <li>
                        <a href="allusers.php"><i class="icon-chevron-right"></i>All users</a>
                    </li>
                </ul>
            </div>
            <div class="span9" id="content">
                <div class="row-fluid">
                    <!-- block -->
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">All orders</div>
                        </div>
                        <div class="block-content collapse in">
                            <table class="table table-striped" id="example">
                                <thead>
                                    <tr>
                                        <th>Order date</th>
                                        <th>Product (quantity)</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Payment type</th>
                                        <th>Subtotal</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($allorders)) : ?>
                                        <tr>
                                            <td colspan="9" style="text-align:center;">Don't have order yet!</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($allorders as $order) : ?>
                                            <tr>
                                                <td><?= $order['orderdate'] ?></td>
                                                <td><?= $order['products'] ?></td>
                                                <td><?= $order['username'] ?></td>
                                                <td><?= $order['phone'] ?></td>
                                                <td><?= $order['email'] ?></td>
                                                <td><?= $order['address'] ?></td>
                                                <td><?= $order['payment_mode'] ?></td>
                                                <td><?= $order['paid_amount'] ?></td>
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
            </div>
        </div>
        <script src="vendors/jquery-1.9.1.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="vendors/datatables/js/jquery.dataTables.min.js"></script>


        <script src="assets/scripts.js"></script>
        <script src="assets/DT_bootstrap.js"></script>
        <script>
            $(function() {

            });
        </script>
</body>

</html>