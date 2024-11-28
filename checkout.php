<?php include('./common/header.php'); ?>
<?php
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    // TOTAL
    $sql = "SELECT SUM(products.price * cart.qty) as total FROM cart INNER JOIN products ON products.id = cart.productid WHERE cart.user=:user";
    $query = $db->prepare($sql);
    $query->bindParam(':user', $user, PDO::PARAM_STR);
    $query->execute();
    $total = $query->fetch(PDO::FETCH_OBJ);
    // FECTH PRODUCTS
    $sql = "SELECT cart.id,products.title,products.price,products.img FROM cart INNER JOIN products ON products.id = cart.productid WHERE cart.user=:user";
    $query = $db->prepare($sql);
    $query->bindParam(':user', $user, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    //INSERT ORDER
    if (isset($_POST['orderplace'])) {
        $address = $_POST['address'];
        $payment = $_POST['payment'];
        $sql = "INSERT INTO orders(user, address, payment_mode) VALUES(:user,:address, :payment)";
        $query = $db->prepare($sql);
        $query->bindParam(':user', $user, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':payment', $payment, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $db->lastInsertId();
        if ($lastInsertId) {
            foreach ($results as $item) {
                $sqlitem = "INSERT INTO orderitems (oid,ptitle,price, qty, pid) VALUES (:orderid,:title,:price, :qty, :pid)";
                $stmtitem = $db->prepare($sqlitem);
                $stmtitem->bindParam("orderid", $lastInsertId, PDO::PARAM_STR);
                $stmtitem->bindParam("title", $item->title, PDO::PARAM_STR);
                $stmtitem->bindParam("price", $item->price, PDO::PARAM_INT);
                $stmtitem->bindParam("qty", $item->qty, PDO::PARAM_INT);
                $stmtitem->bindParam("pid", $item->pid, PDO::PARAM_INT);
                $stmtitem->execute();
            }
            //CLEAR CART
            $sql = "DELETE FROM cart WHERE user = (:user)";
            $query = $db->prepare($sql);
            $query->bindParam(':user', $user, PDO::PARAM_STR);
            $query->execute();
            
            echo "<script>alert('Order Placed')</script>";
            echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
        } else {
            echo "<script>alert('Please Fill All Valid Details')</script>";
        }
    }
}
?>

        <?php if (strlen(isset($_SESSION['login']) == 0)) { ?>
            <div class="container mt-5 p-5">
                <h3 class="p-5 m-5 text-center">Please Login To Check Cart</h3>
            </div>
        <?php } else { ?>
            <form class="" method="post">
            <div style="background-color: #e5e4e2; height:100vh;">
            <div class="container mt-5 p-5">
                <div class="clearfix">
                    <h3 class="py-4 float-left">My Cart</h3>
                    <h3 class="py-4 float-right">Total : <?php echo CURRENCY; ?> <?php echo $total->total; ?></h3>
                </div>
                <div class="row d-flex justify-content-md-center border-0">
                    <div class="col-12">
                     
                            <p class="h3 my-5">Shipping Address</p>
                            <textarea name="address" type="text" rows="7" class="form-control" placeholder="Please Enter Complete Address" required></textarea>
                
                    </div>
                    <div class="col-12">
                            <p class="h3 my-5">Payment Method</p>
                            <select class="form-control" name="payment">
                                <option>Cash on delivery</option>
                            </select>
                    </div>
                </div>
            </div>
            <div class="text-center">
            <input class="btn btn-warning btn-lg border-0  align-items-center" type="submit" value="Place Order" name="orderplace">
            </div>
            </div>
            </form>
        <?php } ?>
    </section>