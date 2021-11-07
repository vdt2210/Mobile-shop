<?php
include('../Share/Services/session.php');
include('../Share/stafffunctions.php');
$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT *, brand.brandname FROM products INNER JOIN brand ON products.brandid = brand.brandid ORDER BY Date_added DESC');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['edit'])) {
    $proid = $_GET['edit'];
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
if (isset($_GET['del'])) {
    $proid = $_GET['del'];
    mysqli_query($db, "DELETE FROM products WHERE proid=$proid");
    $_SESSION['message'] = "Address deleted!";
    header('location: allproduct.php');
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
                    <li>
                        <a href="welcome.php"><i class="icon-chevron-right"></i>Dashboard</a>
                    </li>
                    <li class="active">
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
            <div class="span9" id="content">
                <div class="row-fluid">
                    <!-- block -->
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">All products</div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <div class="table-toolbar">
                                    <div class="btn-group">
                                        <a href="addproduct.php"><button class="btn btn-success">Add New <i class="icon-plus icon-white"></i></button></a>
                                    </div>
                                </div>
                            </div>

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <td>Product</td>
                                        <td>Description</td>
                                        <td>Price</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($recently_added_products)) : ?>
                                        <tr>
                                            <td colspan="4" style="text-align:center;">No product added yet!</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($recently_added_products as $product) : ?>
                                            <tr>
                                                <td>
                                                    <img src="../img/<?= $product['proimage'] ?>" width="60" height="60" alt="<?= $product['proname'] ?>">
                                                    <?= $product['brandname'] ?> <?= $product['proname'] ?>
                                                </td>
                                                <td class="descr"><?= $product['descr'] ?></td>
                                                <td class="price">
                                                    &dollar;<?= $product['price'] ?>
                                                    <?php if ($product['rrp'] > 0) : ?>
                                                        <br><del>&dollar;<?= $product['rrp'] ?></del>
                                                    <?php endif ?>
                                                </td>
                                                <td style="text-align:center">
                                                    <a href="editproduct.php?proid=<?php echo $product['proid']; ?>" class="fas fa-edit"></a>
                                                    <a href="allproduct.php?del=<?php echo $product['proid']; ?>" class="fas fa-trash-alt"></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /block -->
            </div>
        </div>
    </div>
    <!-- <div class="container-fluid">
    <div class="row-fluid">
            <div class="block">
                <a href="welcome.php" class="fas fa-arrow-circle-left"></a>
                <input type="text" id="myInput" onkeyup="searchFunction()" placeholder="Search.." title="Type in a name">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Product</td>
                                <td>Description</td>
                                <td>Price</td>
                                <td>Quantity</td>
                                <td>&nbsp;</td>
                            </tr>
                        </thead>
                        <tbody id="stafftable">
                            <?php if (empty($recently_added_products)) : ?>
                            <tr>
                                <td colspan="4" style="text-align:center;">No product added yet!</td>
                            </tr>
                            <?php else : ?>
                            <?php foreach ($recently_added_products as $product) : ?>
                            <tr>
                                <td>
                                    <a href="index.php?page=product&proid=<?= $product['proid'] ?>" class="product">
                                        <img src="../img/<?= $product['proimage'] ?>" width="50" height="50" alt="<?= $product['proname'] ?>">
                                        <?= $product['brandname'] ?> <?= $product['proname'] ?>
                                    </a>
                                </td>
                                <td class="descr"><?= $product['descr'] ?></td>
                                <td class="price">
                                &dollar;<?= $product['price'] ?>
                                <?php if ($product['rrp'] > 0) : ?>
                                    <br><del>&dollar;<?= $product['rrp'] ?></del>
                                <?php endif ?>
                                </td>
                                <td class="quantity"><?= $product['quantity'] ?></td>
                                <td style="text-align:center">
                                    <a href="staffproduct.php?edit=<?php echo $product['proid']; ?>" class="fas fa-edit"></a>
                                    <a href="staffproduct.php?del=<?php echo $product['proid']; ?>" class="fas fa-trash-alt"></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                        <tr>
                            <td><a href="addproduct.php" class="fas fa-plus">Add</a></td>
                        </tr>
                </div>
            </div>
        </div>
    </div>
</div> -->
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