<?php
include('../Share/Services/session.php');
include('../Share/stafffunctions.php');
$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT *, genders.gender FROM users INNER JOIN genders ON users.gender = genders.id ORDER BY userid;');
$stmt->execute();
$user_acc = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['deluser'])) {
    $userid = $_GET['deluser'];
    mysqli_query($db, "DELETE FROM users WHERE userid=$userid");
    $_SESSION['message'] = "User deleted!";
    header('location: allusers.php');
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
                    <li>
                        <a href="allbrand.php"><i class="icon-chevron-right"></i>All brands</a>
                    </li>
                    <li>
                        <a href="allorders.php"><i class="icon-chevron-right"></i>All orders</a>
                    </li>
                    <li class="active">
                        <a href="allusers.php"><i class="icon-chevron-right"></i>All users</a>
                    </li>
                </ul>
            </div>
            <div class="span9" id="content">
                <div class="row-fluid">
                    <!-- block -->
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">All users</div>
                        </div>
                        <div class="block-content collapse in">
                            <table class="table table-striped" id="example">
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
                                            <td colspan="2" style="text-align:center;">No customer added yet!</td>
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