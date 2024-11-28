<?php include('./common/header.php') ?>
<?php

$sql = "SELECT * FROM contact order by id DESC";
$query = $db->prepare($sql);
$query->execute();
$itemCount = $query->rowCount();
$products = $query->fetchAll(PDO::FETCH_OBJ);

if (isset($_GET['rem'])) {
    $productid = $_GET['rem'];
    $sql = "DELETE FROM contact WHERE id = (:productid)";
    $query = $db->prepare($sql);
    $query->bindParam(':productid', $productid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>alert('contact deleted successfully ')</script>";
    echo "<script type='text/javascript'> document.location = 'contactlist.php'; </script>";
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Contact</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Contact List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                   
                    <tbody>
                        <?php if (count($products)) : ?>
                            <?php foreach ($products as $item) : ?>

                                <tr>

                                    <td><?= $item->name ?></td>
                                    <td><?= $item->email ?></td>
                                    <td><?= $item->contact ?></td>
                                    <td><?= $item->message ?></td>
                                    <td><?= $item->created_at ?></td>
                                    <td>
                                        <a href="?rem=<?= $item->id; ?>" class="btn btn-danger"> Delete</a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        <?php endif; ?>


                    </tbody>
                </table>
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
            <span>Copyright &copy; Ayushi</span>
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
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<script>
    $(document).ready(function() {
        $("#btnExport").click(function() {
            let table = document.getElementsByTagName("table");
            TableToExcel.convert(table[0], {
                name: `order_list.xlsx`,
                sheet: {
                    name: 'orders'
                }
            });
        });
    });
</script>
</body>

</html>