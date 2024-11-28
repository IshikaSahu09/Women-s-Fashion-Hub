<?php include('./common/header.php'); ?>
<?php
if (isset($_SESSION['user'])) {
  // $user = $_SESSION['user'];

  if (isset($_GET['rem'])) {
    $productid = $_GET['rem'];
    $sql = "DELETE FROM cart WHERE id = (:productid)";
    $query = $db->prepare($sql);
    $query->bindParam(':productid', $productid, PDO::PARAM_STR);
    $query->execute();
  }

  if (isset($_GET['update'])) {

    $productid = $_GET['update'];
    $type = $_GET['type'];
    $qty = $_GET['qty'];
    if ($type == 'min') {
      $qty_data =  $qty - 1;
      $sql = "Update cart set qty = " . $qty_data . " WHERE id = (:productid)";
    } else {
      $qty_data =  $qty + 1;
      $sql = "Update cart set qty =" . $qty_data . "  WHERE id = (:productid)";
    }
    $query = $db->prepare($sql);
    $query->bindParam(':productid', $productid, PDO::PARAM_STR);
    $query->execute();

    echo "<script type='text/javascript'> document.location = 'cart.php'; </script>";
  }

  // FECTH PRODUCTS
  $sql = "SELECT cart.id,products.title,products.price,products.img, cart.qty FROM cart INNER JOIN products ON products.id = cart.productid WHERE cart.user=:user";
  $query = $db->prepare($sql);
  $query->bindParam(':user', $user, PDO::PARAM_STR);
  $query->execute();
  $itemCount = $query->rowCount();
  $results = $query->fetchAll(PDO::FETCH_OBJ);

  // TOTAL
  $sql = "SELECT SUM(products.price * cart.qty) as total FROM cart INNER JOIN products ON products.id = cart.productid WHERE cart.user=:user";
  $query = $db->prepare($sql);
  $query->bindParam(':user', $user, PDO::PARAM_STR);
  $query->execute();
  $total = $query->fetch(PDO::FETCH_OBJ);
}
?>
<script>
  function increaseQuantity(button) {
    var row = button.parentNode.parentNode;
    var quantityElement = row.querySelector('.quantity');
    var subtotalElement = row.querySelector('.subtotal');
    var quantity = parseInt(quantityElement.textContent);
    quantity++;
    quantityElement.textContent = quantity;
    subtotalElement.textContent = parseInt(row.cells[1].textContent) * quantity; // Update subtotal
  }

  function decreaseQuantity(button) {
    var row = button.parentNode.parentNode;
    var quantityElement = row.querySelector('.quantity');
    var subtotalElement = row.querySelector('.subtotal');
    var quantity = parseInt(quantityElement.textContent);
    if (quantity > 1) {
      quantity--;
      quantityElement.textContent = quantity;
      subtotalElement.textContent = parseInt(row.cells[1].textContent) * quantity; // Update subtotal
    }
  }
</script>
<!-- attached bg section -->
<!-- cart head -->
<div class="bg-cart">
  <div class="row">
    <h4 class="cart_content display-4 text-dark">
      Cart
    </h4>
  </div>
</div>
<!-- cart preview -->
<div class="container my-5 pt-5 ">
  <div class="row ">
    <table class="table table-bordered" id="productTable">
      <thead>
        <tr class="text-center">
          <th>Product Images</th>
          <th>Product Name</th>
          <th>Product Price</th>
          <th>Quantities</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>

        <?php
        if ($query->rowCount() > 0) {
          foreach ($results as $result) {       ?>
            <tr class="text-center">
              <td><img class="cart-img" src="./img/products/<?php echo $result->img; ?>" height="100" width="100"></td>
              <td><?php echo $result->title; ?></td>
              <td><?php echo CURRENCY; ?> <?php echo $result->price; ?></td>
              <td>
                <div></div>
                <a class="text-decoration-none text-dark" href="cart.php?update=<?php echo $result->id; ?>&qty=<?php echo $result->qty; ?>&type=min">
                <button class="btn btn-outline-warning text-dark me-2">
 - 
                </button>
                </a>
                <span class="quantity"><?php echo $result->qty; ?></span>
                <a class="text-decoration-none text-dark" href="cart.php?update=<?php echo $result->id; ?>&qty=<?php echo $result->qty; ?>&type=pls">
                  <button class="btn btn-outline-warning text-dark ms-2">
                    +
                  </button>
                </a>
              </td>
              <td><a href="cart.php?rem=<?php echo $result->id; ?>">Remove</a></td>
            </tr>
          <?php } ?>
          <tr>
            <th class="text-center">Total</th>
            <td></td>
            <td></td>
            <td class="text-center"><?= $total->total; ?></td>
          </tr>
        <?php

        } else { ?>
          <tr>
            <th class="text-center text-danger" colspan="5">No item added</th>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <div class="text-center my-5 pb-5">
    <a href="checkout.php" class="btn btn-primary btn-lg border-0"><i class="fa fa-shopping-cart mx-3"></i>Checkout</a>
  </div>
</div>

<!-- footer -->
<?php include('./common/footer.php'); ?>
</body>

</html>