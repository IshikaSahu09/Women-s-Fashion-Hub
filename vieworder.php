<?php include('./common/header.php'); ?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM orderitems inner join orders on orderitems.oid = orders.id inner join users on users.id = orders.user  where oid=$id  ";
    $query = $db->prepare($sql);
    $query->execute();
    $itemCount = $query->rowCount();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
}
?>

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container" style="height:100vh">

                    <!-- Page Heading -->
                    <div class="card shadow mb-4" id="pageprint">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Order Detials</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="invoice-title">
                                        <h2>Invoice</h2>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <address>
                                                <strong>Billed To:</strong><br>
                                                <?= $results[0]->name; ?><br>
                                                <?= $results[0]->email; ?><br>
                                                <?= $results[0]->mobile; ?><br>
                                            </address>
                                        </div>
                                        <div class="col-sm-6 text-right">
                                            <address>
                                                <strong>Shipped To:</strong><br>
                                                <?= $results[0]->address; ?><br>
                                            </address>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><strong>Order summary</strong></h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <td><strong>Item</strong></td>
                                                            <td class="text-center"><strong>Price</strong></td>
                                                            <td class="text-center"><strong>Quantity</strong></td>
                                                            <td class="text-right"><strong>Totals</strong></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <!-- foreach ($order->lineItems as $line) or some such thing here -->

                                                        <?php if (count($results)) : ?>
                                                            <?php $price = 0;
                                                            foreach ($results as $item) : ?>

                                                                <tr>
                                                                    <td><?= $item->ptitle; ?></td>
                                                                    <td class="text-center"><?= $item->price; ?></td>
                                                                    <td class="text-center">1</td>
                                                                    <td class="text-right"><?= $item->price * 1; ?></td>
                                                                </tr>
                                                            <?php $price += $item->price;
                                                            endforeach; ?>
                                                        <?php endif; ?>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center"><strong>Total</strong></td>
                                                            <td class="no-line text-right"><?= $price; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; AYUSHI</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
</body>

</html>