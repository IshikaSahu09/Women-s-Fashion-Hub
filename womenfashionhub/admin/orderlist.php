<?php include('./common/header.php'); ?>
<?php
if (strlen(isset($_SESSION['admin']) == 0)) {
    echo "<script type='text/javascript'> document.location = 'login.php'; </script>";
}

if (isset($_GET['complete'])) {
    $id = $_GET['id'];
    $sql = "update orders set status = 1 where id = $id";
    $query = $db->prepare($sql);
    $query->execute();
    $itemCount = $query->rowCount();
    if ($itemCount) {
        header("location:dashboard.php");
    } else {
        header("location:dashboard.php");
    }
    echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
}

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
                <div class="container-fluid">

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
                                            <form class="text-center">
                                                <input type="hidden" name="id" value="<?= $results[0]->oid; ?>" />
                                                <button class="btn btn-success" name="complete">Completed</button>
                                            </form>
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
                        <span>Copyright &copy; YASH RAJ SINGH</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <form method="GET" action="dashboard.php">
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" name="logout" type="submit">Logout</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function generatePDF() {
            const element = document.getElementById("pageprint");
            html2pdf().from(element).save('download.pdf');
        }
    </script>
</body>

</html>