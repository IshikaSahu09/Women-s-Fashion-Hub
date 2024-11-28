<?php
session_start();
error_reporting(1);
include('./config.php');

$user = $_SESSION['user'];
$sql = "SELECT cart.id,products.title,products.price,products.img FROM cart INNER JOIN products ON products.id = cart.productid WHERE cart.user=:user order by id DESC";
$query = $db->prepare($sql);
$query->bindParam(':user', $user, PDO::PARAM_STR);
$query->execute();
$itemCount = $query->rowCount();
$cart_item = $query->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Women's Fashion Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://unpkg.com/bs-brain@2.0.3/components/testimonials/testimonial-3/assets/css/testimonial-3.css" />
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
    <!-- nav bar -->
    <nav class="navbar navbar-expand-lg  bg-white sticky-top navbar-light " >
        <div class="container">
            <a class="navbar-brand" href="./index.php"><img src="images/logo.png" alt="logo" width="100"
                    height="80" class="img-fluid" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

                <ul class="navbar-nav ms-auto ">
                    <li class="nav-item">
                        <a class="nav-link mx-2 text-uppercase active" aria-current="page" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2 text-uppercase" href="./about.php">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link mx-2 text-uppercase" href="./contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2 text-uppercase" href="./faq.php">FAQ's</a>
                    </li>
                    <?php if($user): ?>
                        <li class="nav-item">
                        <a class="nav-link mx-2 text-uppercase" href="./orderlist.php">Order List</a>
                    </li>
                   <?php endif; ?>
                </ul>
                <ul class="navbar-nav ">
                    <li class="nav-item">
                        <a class="nav-link mx-2 text-uppercase" href="./cart.php"><i
                                class="fa fa-shopping-cart me-1"></i>
                                <span class="ps-2 text-success text-bold text-lg"><?= count($cart_item );?></span>
                            </a>
                    </li>
       
                    <li class="nav-item">
                        <?php echo $user ? '<a href="logout.php" class="btn btn-danger border-0">Logout</a>' : '<a href="login.php" class="btn btn-success border-0">Login</a>'; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>