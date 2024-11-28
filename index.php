<?php include ('./common/header.php'); ?>
<?php
error_reporting(0);
include ('config.php');
$msg = '';
if (isset($_GET['add'])) {
    if (isset($_SESSION['user'])) {
        $productid = $_GET['add'];
        $user = $_SESSION['user'];
        $sql = "INSERT INTO cart(productid,user, qty) VALUES(:productid,:user, 1)";
        $query = $db->prepare($sql);
        $query->bindParam(':productid', $productid, PDO::PARAM_STR);
        $query->bindParam(':user', $user, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $db->lastInsertId();
        if ($lastInsertId) {
            $msg = '<div id="msg" class="alert alert-success"><strong>Product Added To Cart</strong></div>';
        } else {
            $msg = '<div id="msg" class="alert alert-danger"><strong>Unable To Add</strong></div>';
        }
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    } else {
        echo "<script type='text/javascript'> document.location = 'login.php'; </script>";
    }
} else {
}
?>
<!-- header section -->
<div id="carouselExample" class="carousel slide">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/sl1.jpeg" class="d-block " alt="banner1">
        </div>
        <div class="carousel-item">
            <img src="images/sl2.jpg" class="d-block " alt="banner2">
        </div>
        <div class="carousel-item">
            <img src="images/slide12.jpg" class="d-block" alt="banner3">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!-- features -->
<div class="container p-3 my-5">
    <div class="row py-4">
        <div class="col-md-3 feature-box border p-3">
            <i class="fa-solid fa-bag-shopping"></i>
            <p><span class="text-darker fs-5">Free Shipping</span><br>
                When you spend Rs500+</p>
        </div>
        <div class="col-md-3 feature-box border p-3">
            <i class="fas fa-shipping-fast"></i>
            <p><span class="text-darker fs-5">Quick Delivery</span><br>
                Within 7 days</p>
        </div>
        <div class="col-md-3 feature-box border p-3">
            <i class="fas fa-headset"></i>
            <p><span class="text-darker fs-5">24/7 Support</span><br>
                Ready to help our clients
            </p>
        </div>
        <div class="col-md-3 feature-box border p-3">
            <i class="fas fa-money-bill-wave"></i>
            <p><span class="text-darker fs-5">Secure Payments</span><br>
                We are officially registered</p>
        </div>
    </div>
</div>
<!-- categories card -->
<div class="container-fluid my-5">
    <h3 class="text-center pb-3">Categories</h3>
    <div class="row row-cols-1 row-cols-md-4 g-4 py-5">
        <div class="col">
            <a href="./index.php" class="text-decoration-none text-dark">
                <div class="card categoreis ">
                    <img src="images/cat1.png" class="card-img-top categories_img" alt="Women's Category">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h5 class="card-title text-center fs-4">All</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="./index.php?id=saree" class="text-decoration-none text-dark">
                <div class="card categoreis ">
                    <img src="images/saree2.jpg" class="card-img-top categories_img" alt="Women's Category">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h5 class="card-title text-center fs-4">Saree</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="./index.php?id=western" class="text-decoration-none text-dark">
                <div class="card categoreis ">
                    <img src="images/westerncat.png" class="card-img-top categories_img" alt="Men's Category">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h5 class="card-title text-center fs-4">Western Wear </h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col ">
            <a href="./index.php?id=kurta" class="text-decoration-none text-dark">
                <div class="card categoreis ">
                    <img src="images/Kurti1.jpg" class="card-img-top categories_img" alt="Sneakers Category">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h5 class="card-title text-center fs-4">Kurti</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- product -->
<div class="container-fluid my-5 mb-5">
    <h3 class="text-center pb-5 mb-5">Products</h3>
    <div class="row">

        <?php
        // FECTH PRODUCTS
        $sql = "SELECT * from products ORDER BY RAND()";
        $query = $db->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($_GET['id'] == 'saree') {
            $sql = "SELECT * from products where category = 'saree' ORDER BY id DESC";
            $query = $db->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
        }

        if ($_GET['id'] == 'western') {
            $sql = "SELECT * from products where category = 'western' ORDER BY id DESC";
            $query = $db->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
        }

        if ($_GET['id'] == 'kurta') {
            $sql = "SELECT * from products where category = 'kurta' ORDER BY id DESC";
            $query = $db->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
        }
        if ($query->rowCount() > 0) {
            foreach ($results as $result) { ?>
                <div class="col-md-3 my-2">
                    <div class="card">
                        <img src="./img/products/<?php echo $result->img; ?>" alt="<?php echo $result->title; ?>"
                            title="<?php echo $result->title; ?>" height="400">

                        <div class="card-footer border-top border-gray-300">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0"><?php echo $result->title; ?></p>
                                <span class="h6 mb-0 text-gray"><?php echo CURRENCY ?>         <?php echo $result->price; ?></span>
                            </div>
                            <div class="d-flex justify-content-between  mt-2">
                                <div class="d-flex align-items-left">
                                    <span class="star fas fa-star text-warning me-1"></span>
                                    <span class="star fas fa-star text-warning me-1"></span>
                                    <span class="star fas fa-star text-warning me-1"></span>
                                    <span class="star fas fa-star text-warning me-1"></span>
                                    <span class="star fas fa-star text-warning"></span>
                                </div>
                                <div class="d-flex align-items-right">
                                    <a class="btn btn-sm btn-outline-dark" href="index.php?add=<?php echo $result->id; ?>">
                                        <span class="fa fa-cart-plus"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>
    </div>
</div>
<!-- new arrival and mega sale -->
<div class="container-fluid my-5 pt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card rounded-0 p-4" style="background-color:#F5F5F5;">
                <div class="p-3">
                    <p>NEW ARRIVALS
                    </p>
                </div>
                <div class="row ps-3 mt-5">
                    <div class="col-md-6">
                        <h1 class="">WESTERN WEAR COLLECTION</h1>
                        <p>Elegant, chic styles to elevate your wardrobe</p>

                        <a class="btn rounded-0 btn-dark mt-4">SHOP NOW</a>
                    </div>
                    <div class="col-md-6">
                        <img src="images/new1.png" alt="newarrivals" width="400">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card rounded-0 p-4" style="background-color:#F5F5F5;">
                <div class="p-3">
                    <p>SUMMER SALE
                    <p></p>
                    </p>
                </div>
                <div class="row ps-3 mt-5">
                    <div class="col-md-6">
                        <h1 class=""><span class="text-danger display-4 ">50%</span>OFF
                            FOR SUMMER</h1>

                        <p>Stay comfy, cool, and stretched for ultimate comfort.</p>
                        <a class="btn rounded-0 btn-dark mt-4">SHOP NOW</a>
                    </div>
                    <div class="col-md-6">
                        <img src="images/new2.png" alt="newarrivals" width="350" height="400">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  featured products -->
    <div class="container-fluid my-5">
        <h3 class="text-center pt-5 pb-5">Featured Products</h3>
        <div class="row my-5 pb-5">
            <div class="col-md-3">
                <div class="card">
                    <img src="https://radcity.net/wp-content/uploads/2016/11/Sarees-Designs.jpg" alt="black watch"
                        height="400px">
                    <div class="card-footer border-top border-gray-300">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Party Wear Saree</p>
                            <span class="h6 mb-0 text-gray">Rs499.00</span>
                        </div>
                        <div class="d-flex justify-content-between  mt-2">
                            <div class="d-flex align-items-left">
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning"></span>
                            </div>
                            <div class="d-flex align-items-right">
                                <a class="btn btn-sm btn-outline-dark" href="#">
                                    <span class="fa fa-cart-plus"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="https://n4.sdlcdn.com/imgs/i/4/a/Salwar-Studio-Beige-Synthetic-Dress-SDL514445019-1-5763a.jpg"
                        alt="black watch" height="400px">
                    <div class="card-footer border-top border-gray-300">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Suit</p>
                            <span class="h6 mb-0 text-gray">Rs699.00</span>
                        </div>
                        <div class="d-flex justify-content-between  mt-2">
                            <div class="d-flex align-items-left">
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning"></span>
                            </div>
                            <div class="d-flex align-items-right">
                                <a class="btn btn-sm btn-outline-dark" href="#">
                                    <span class="fa fa-cart-plus"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="http://www.careyfashion.com/wp-content/uploads/2016/12/cropped-jeans-7.jpg"
                        alt="black watch" height="400px">
                    <div class="card-footer border-top border-gray-300">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Jeans</p>
                            <span class="h6 mb-0 text-gray">Rs599.00</span>
                        </div>
                        <div class="d-flex justify-content-between  mt-2">
                            <div class="d-flex align-items-left">
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning"></span>
                            </div>
                            <div class="d-flex align-items-right">
                                <a class="btn btn-sm btn-outline-dark" href="#">
                                    <span class="fa fa-cart-plus"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="https://i.pinimg.com/originals/5b/32/b3/5b32b3ce11bfb99890d8fa185dbc124b.jpg"
                        alt="black watch" height="400px">
                    <div class="card-footer border-top border-gray-300">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Summer Dress</p>
                            <span class="h6 mb-0 text-gray">Rs599.00</span>
                        </div>
                        <div class="d-flex justify-content-between  mt-2">
                            <div class="d-flex align-items-left">
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning"></span>
                            </div>
                            <div class="d-flex align-items-right">
                                <a class="btn btn-sm btn-outline-dark" href="#">
                                    <span class="fa fa-cart-plus"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-5 pb-5">
            <div class="col-md-3">
                <div class="card">
                    <img src="https://avatars.mds.yandex.net/i?id=87049549b0c9c888ba9ed69c1b62ea4978adf47b-9225702-images-thumbs&ref=rim&n=33&w=250&h=250"
                        alt="black watch" height="400px">
                    <div class="card-footer border-top border-gray-300">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Western Wear</p>
                            <span class="h6 mb-0 text-gray">Rs999.00</span>
                        </div>
                        <div class="d-flex justify-content-between  mt-2">
                            <div class="d-flex align-items-left">
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning"></span>
                            </div>
                            <div class="d-flex align-items-right">
                                <a class="btn btn-sm btn-outline-dark" href="#">
                                    <span class="fa fa-cart-plus"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="https://avatars.mds.yandex.net/i?id=069080d173fb0be7e621d3cea07c14cab624e227-10639710-images-thumbs&n=13"
                        alt="black watch" height="400px">
                    <div class="card-footer border-top border-gray-300">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Top</p>
                            <span class="h6 mb-0 text-gray">Rs499.00</span>
                        </div>
                        <div class="d-flex justify-content-between  mt-2">
                            <div class="d-flex align-items-left">
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning"></span>
                            </div>
                            <div class="d-flex align-items-right">
                                <a class="btn btn-sm btn-outline-dark" href="#">
                                    <span class="fa fa-cart-plus"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="https://i.pinimg.com/originals/94/dd/15/94dd1549c723230954310f9d7a3406b7.jpg"
                        alt="black watch" height="400px">
                    <div class="card-footer border-top border-gray-300">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Party Waer Suit</p>
                            <span class="h6 mb-0 text-gray">Rs599.00</span>
                        </div>
                        <div class="d-flex justify-content-between  mt-2">
                            <div class="d-flex align-items-left">
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning"></span>
                            </div>
                            <div class="d-flex align-items-right">
                                <a class="btn btn-sm btn-outline-dark" href="#">
                                    <span class="fa fa-cart-plus"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="https://i.pinimg.com/736x/84/d0/27/84d02701c073ccc99a172bce600f01dd.jpg" alt="black watch"
                        height="400px">
                    <div class="card-footer border-top border-gray-300">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0">Saree</p>
                            <span class="h6 mb-0 text-gray">Rs599.00</span>
                        </div>
                        <div class="d-flex justify-content-between  mt-2">
                            <div class="d-flex align-items-left">
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning me-1"></span>
                                <span class="star fas fa-star text-warning"></span>
                            </div>
                            <div class="d-flex align-items-right">
                                <a class="btn btn-sm btn-outline-dark" href="#">
                                    <span class="fa fa-cart-plus"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- shoping video -->
<?php include ('./common/testimonialvideo.php'); ?>
<!-- our team -->
<?php include ('./common/experts.php'); ?>

<!-- attached bg section -->
<div class="my-5">
    <div class="mt-5 pt-5">
        <div class="bg-image">
            <h4 class="content display-4 text-darker">
                "Every outfit blossoms with the essence of elegance, weaving tales of timeless grace."
            </h4>
        </div>
    </div>
</div>
<!-- Testimonial 3 - Bootstrap Brain Component -->
<?php include ('./common/feedback.php'); ?>

<!-- footer -->
<?php include ('./common/footer.php'); ?>
</body>

</html>