<?php
include('../Share/Services/session.php');
include('../Share/stafffunctions.php');
$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM brand ORDER BY brandname');
$stmt->execute();
$recently_added_brand = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['edit'])) {
    $brandid = $_GET['edit'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM brand WHERE brandid=$brandid");

    if (count($record) == 1) {
        $n = mysqli_fetch_array($record);
        $brandname = $n['brandname'];
    }
}
if (isset($_GET['del'])) {
    $brandid = $_GET['del'];
    mysqli_query($db, "DELETE FROM brand WHERE brandid=$brandid");
    $_SESSION['message'] = "Brand deleted!";
    header('location: allbrand.php');
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
                    <li>
                        <a href="allproduct.php"><i class="icon-chevron-right"></i>All products</a>
                    </li>
                    <li class="active">
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
                                        <a href="addbrand.php"><button class="btn btn-success">Add New <i class="icon-plus icon-white"></i></button></a>
                                    </div>
                                </div>
                            </div>

                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <td>Brand</td>
                                        <td></td>
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
                                                    <img src="../img/<?= $brand['brandimage'] ?>" width="50" height="50" alt="<?= $brand['brandname'] ?>">
                                                    <?= $brand['brandname'] ?>
                                                </td>
                                                <td>
                                                    <a href="allbrand.php?del=<?php echo $brand['brandid']; ?>" class="fas fa-trash-alt"></a>
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

    <script src="vendors/jquery-1.9.1.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="vendors/datatables/js/jquery.dataTables.min.js"></script>


    <script src="assets/scripts.js"></script>
    <script src="assets/DT_bootstrap.js"></script>
    <script>
        $(function() {

        });
    </script>