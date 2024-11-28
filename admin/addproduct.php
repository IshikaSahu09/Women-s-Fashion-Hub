<?php include('./common/header.php') ?>
<?php

$sql = "SELECT * FROM products order by id DESC";
$query = $db->prepare($sql);
$query->execute();
$itemCount = $query->rowCount();
$products = $query->fetchAll(PDO::FETCH_OBJ);

if (isset($_GET['rem'])) {
    $productid = $_GET['rem'];
    $sql = "DELETE FROM products WHERE id = (:productid)";
    $query = $db->prepare($sql);
    $query->bindParam(':productid', $productid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>alert('product deleted successfully ')</script>";
    echo "<script type='text/javascript'> document.location = 'addproduct.php'; </script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 5000000) { // 5MB limit
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    $fileExtension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else { // If everything is ok, try to upload file
        $targetDirectory = "../img/products/";
        $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $qty = $_POST['qty'];
            $file = $_FILES['file']['name'];
            $sql = "INSERT INTO products (title, price, category, qty, img) VALUES(:name, :price, :category, :qty ,:file)";
            $query = $db->prepare($sql);
            $query->bindParam(':name', $name, PDO::PARAM_STR);
            $query->bindParam(':price', $price, PDO::PARAM_STR);
            $query->bindParam(':category', $category, PDO::PARAM_STR);
            $query->bindParam(':file', $file, PDO::PARAM_STR);
            $query->bindParam(':qty', $qty, PDO::PARAM_STR);

            $query->execute();

            $lastInsertId = $db->lastInsertId();
            if ($lastInsertId) {
                echo "<script>alert('product added successfully ')</script>";
                echo "<script type='text/javascript'> document.location = 'addproduct.php'; </script>";
            } else {
                echo "<script>alert('Please Fill All Valid Details')</script>";
            }


            // echo "The file ". htmlspecialchars(basename($_FILES["file"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}




?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Product</h1>
    </div>


    <!-- Content Row -->
    <form method="POST" enctype="multipart/form-data">
        <div class="row my-5">
            <div class="col-sm-3">
                <input type="text" placeholder="Product Name" name="name" class="form-control" required />
            </div>
            <div class="col-sm-3">
                <input type="text" placeholder="Product Price" name="price" class="form-control" required />
            </div>
            <div class="col-sm-3">
                <select name="category" class="form-control" required>
                    <option>saree</option>
                    <option>western</option>
                    <option>kurta</option>
                </select>
            </div>
            <div class="col-sm-3">
                <input type="number" name="qty" placeholder="Quantity" class="form-control" required />
            </div>
            <div class="col-sm-3 mt-4">
                <input type="file" name="file" class="form-control" required />
            </div>
            <div class="col-sm-3 mt-4 offset-sm-6">
                <button class="btn btn-primary col-sm-12" name="submit" type="submit">Add </button>
            </div>
        </div>
    </form>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Start date</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>

                            <th>Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Start date</th>
                            <th>Delete</th>

                        </tr>
                    </tfoot>
                    <tbody>
                        <?php if (count($products)) : ?>
                            <?php foreach ($products as $item) : ?>

                                <tr>
                                    <td><img src="../img/products/<?= $item->img ?>" height="50" /></td>
                                    <td><?= $item->title ?></td>
                                    <td><?= $item->qty ?></td>
                                    <td><?= $item->price ?></td>
                                    <td><?= $item->category ?></td>
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