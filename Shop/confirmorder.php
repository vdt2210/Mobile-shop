<?php
// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['confirmorder'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['confirmorder'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['confirmorder'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=confirmorder');
    exit;
}
// Send the user to the place order page if they click the Place Order button, also the cart should not be empty
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
$username = "root";
$password = "";
$server   = "localhost";
$dbname   = "mobileshop";

$connect = new mysqli($server, $username, $password, $dbname);
if ($connect->connect_error) {
    die("Can't connect:" . $conn->connect_error);
    exit();
}
$proid = "";
$orderquantity = "";
$subtotal = "";
$cusname = "";
$cusaddress = "";
$cusemail = "";
$cusphone = "";
$cusnote = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["proid"])) { $proid = $_POST['proid']; }
    if(isset($_POST["orderquantity"])) { $orderquantity = $_POST['orderquantity']; }
    if(isset($_POST["subtotal"])) { $subtotal = $_POST['subtotal']; }
    if(isset($_POST["cusname"])) { $cusname = $_POST['cusname']; }
    if(isset($_POST["cusaddress"])) { $cusaddress = $_POST['cusaddress']; }
    if(isset($_POST["cusemail"])) { $cusemail = $_POST['cusemail']; }
    if(isset($_POST["cusphone"])) { $cusphone = $_POST['cusphone']; }
    if(isset($_POST["cusnote"])) { $cusnote = $_POST['cusnote']; }

    $sql = "INSERT INTO orders (proid, orderquantity, subtotal, cusname, cusaddress, cusemail, cusphone, cusnote)
    VALUES ('$proid', '$orderquantity', '$subtotal', '$cusname', '$cusaddress', '$cusemail', '$cusphone', '$cusnote')";

    if ($connect->query($sql) === TRUE) {
        $success = "Add product successfull!!!";
    } else {
        $success = "ERROR: " . $sql . "<br>" . $connect->error;
    }
}
    header('Location: index.php?page=placeorder');
}
// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT *, brand.brandname FROM products INNER JOIN brand ON products.brandid = brand.brandid WHERE proid IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the products
    $stmt->execute(array_keys($products_in_cart));
    // Fetch the products from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Calculate the subtotal
    foreach ($products as $product) {
        $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['proid']];
    }
}
?>
<?=template_header()?>

        <div class="product-content-right">
                        <div class="woocommerce">
                            <form method="post" action="#">
                                <table cellspacing="0" class="shop_table cart">
                                    <thead>
                                        <tr>
                                            <th class="product-name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (empty($products)): ?>
                                    <tr>
                                        <td colspan="5" style="text-align:center;">You have no products added in your cart</td>
                                    </tr>
                                    <?php else: ?>
                                    <?php foreach ($products as $product): ?>
                                        <tr class="cart_item">
                                            <td class="product-name">
                                                <img src="../img/<?=$product['proimage']?>" width="50" height="50" alt="<?=$product['proname']?>">
                                                <?=$product['proname']?>
                                            </td>

                                            <td class="product-price">
                                                <span class="amount">&dollar;<?=$product['price']?></span> 
                                            </td>

                                            <td class="product-quantity">
                                                <span value="<?=$products_in_cart[$product['proid']]?>"><?=$products_in_cart[$product['proid']]?></span>
                                            </td>

                                            <td class="product-subtotal">
                                                <span class="amount">&dollar;<?=$product['price'] * $products_in_cart[$product['proid']]?></span> 
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                        <tr>
                                            <th>Order total:
                                            <span class="amount"> &dollar;<?=$subtotal?></span></th>
                                            <input class"amount" value="<?=$subtotal?>" style="display: none">
                                            <td class="actions" colspan="6" style="text-align: right">
                                                <input type="submit" value="Place Order" name="placeorder" class="checkout-button button alt wc-forward">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>

                            <div class="cart-collaterals">
                            <div class="cart_totals ">
                                <h2>Cart Totals</h2>
                                <table cellspacing="0">
                                    <tbody>
                                        <tr class="cart-subtotal">
                                            <th>Order total</th>
                                            <td><span class="amount">&dollar;<?=$subtotal?></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <input class="" type="radio"
                                    value="Bank payment" name="bankpayment">Bank payment
                                <input class="" type="radio"
                                    value="COD" name="COD">COD
                            </div>
                        </div>                        
                    </div>  
        <table>
            <h1>Customer information</h1>
            <input type="text" name="cusname" value="" placeholder="Full name" required>
            <input type="text" name="cusaddress" value="" placeholder="Address" required>
            <input type="text" name="cusemail" value="" placeholder="Email">
            <input type="number" name="cusphone" value="" placeholder="Phone number" required>
            <textarea rows="4" cols="50" type="text" name="cusnote" value="" placeholder="Note"></textarea>
            <div class="row">
					<div class="inline-block">
						<div>
							<input class="" type="radio" checked="checked"
								value="Direct bank transfer" name="direct-bank-transfer">Direct
							bank transfer
						</div>

						<div class="info-label">Specify your order number when you make
							the bank transfer. Your order will be shippied after the amount
							is credited to us.</div>
					</div>
				</div>
        </table>
        <div class="buttons">            
            <input type="submit" value="Place Order" name="placeorder">
        </div>
    </form>
</div>

<?=template_footer()?>