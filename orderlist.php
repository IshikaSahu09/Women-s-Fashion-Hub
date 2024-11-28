<?php include('./common/header.php'); ?>
<?php
if (isset($_SESSION['user'])) {
  // $user = $_SESSION['user'];

  if (isset($_GET['rem'])) {
    $productid = $_GET['rem'];
    $sql = "update orders set status = 2 where id = (:productid)";
    $query = $db->prepare($sql);
    $query->bindParam(':productid', $productid, PDO::PARAM_STR);
    $query->execute();
  }

  // FECTH PRODUCTS
  $sql = "SELECT * FROM orders WHERE user=:user order by id desc";
  $query = $db->prepare($sql);
  $query->bindParam(':user', $user, PDO::PARAM_STR);
  $query->execute();
  $itemCount = $query->rowCount();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
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
<!-- cart preview -->
<div class="container my-5 pt-5 ">
  <div class="row ">
    <table class="table table-bordered" id="productTable">
      <thead>
        <tr class="text-center">
          <th>Order ID</th>
          <th>Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>

        <?php
        if ($query->rowCount() > 0) {
          foreach ($results as $result) {       ?>
            <tr class="text-center">
              <td><?php echo $result->id; ?></td>
              <td><?php echo $result->created_at; ?></td>

              <td>
                <?php
                switch ($result->status) {
                  case 0:
                    echo  '<span class="text-danger">Pending</span>';
                    break;
                  case 1:
                    echo  '<span class="text-success">Completed</span>';
                    break;
                  case 2:
                    echo  '<span class="text-warning">Cancel by user</span>';
                    break;
                  case 3:
                    echo  '<span class="text-warning">Cancel by admin</span>';
                    break;
                }
                ?>
              </td>
              <td><a href="orderlist.php?rem=<?php echo $result->id; ?>" class="btn btn-danger">Cancel</a>
                <a href="vieworder.php?id=<?php echo $result->id; ?>" class="btn btn-success">View</a>
              </td>
            </tr>
          <?php } ?>
        <?php
        } else { ?>
          <tr>
            <th class="text-center text-danger" colspan="5">No item added</th>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<!-- footer -->
<?php include('./common/footer.php'); ?>
</body>

</html>