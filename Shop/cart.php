<?php
session_start();
include('functions.php');
?>

<?= template_header() ?>

<div style="display:<?php if (isset($_SESSION["showAlert"])) {
                      echo $_SESSION["showAlert"];
                    } else {
                      echo "none";
                    }
                    unset($_SESSION["showAlert"]) ?>" class="alert alert-success alert-dismissible mt-2">

  <button type="button" class="close" data-dismiss="alert">&times;</button>

  <strong><?php if (isset($_SESSION["message"])) {
            echo $_SESSION["message"];
          }
          unset($_SESSION["showAlert"]); ?></strong>

</div>

<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col"> </th>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col" class="text-center">Quantity</th>
              <th scope="col" class="text-right">Total Price</th>
              <th scope="col" class="text-right">
                <a href="action.php?clear=all" onClick="return confirm('Are you sure to clear you cart?');" class="btn btn-sm btn-danger">Empty Cart</a>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
            require_once "../Share/Services/dbconfig.php";
            $select_stmt = $db->prepare("SELECT * FROM cart INNER JOIN products ON cart.proid=products.proid");
            $select_stmt->execute();
            $grand_total = 0;
            while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <tr>
                <td><img src="../img/<?php echo $row["proimage"]; ?>" width="50" height="50" /> </td>

                <td><?php echo $row["proname"]; ?></td>

                <td><?php echo number_format($row["price"], 2); ?></td>

                <td><input type="number" class="form-control itemQty" value="<?php echo $row['cartquantity']; ?>" style="width:75px;"></td>

                <td class="text-right"><?php echo number_format($row["total_price"], 2); ?></td>

                <td class="text-right">
                  <a href="action.php?remove=<?php echo $row["cartid"]; ?>" onClick="return confirm('Are you sure want to remove this item?');" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                </td>

                <input type="hidden" class="pid" value="<?php echo $row["cartid"]; ?>">
                <input type="hidden" class="pprice" value="<?php echo $row["price"]; ?>">

                <?php $grand_total += $row["total_price"]; ?>
              </tr>
            <?php
            }
            ?>

            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td><strong>Total</strong></td>
              <td class="text-right"><strong><?php echo number_format($grand_total, 2); ?></strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col mb-2">
      <div class="row">
        <div class="col-sm-12  col-md-6">
          <a href="index.php" class="btn btn-block btn-light"><i class="fa fa-shopping-cart"></i> Continue Shopping</a>
        </div>
        <div class="col-sm-12 col-md-6 text-right">
          <a href="checkout.php" class="btn btn-md btn-block btn-success text-uppercase <?= ($grand_total > 1) ? "" : "disabled"; ?>"> Checkout </a>
        </div>
      </div>
    </div>
  </div>

</div>

<?= template_footer() ?>