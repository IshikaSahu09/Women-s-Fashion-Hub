<?php include ('./common/header.php'); ?>
<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $sql = "INSERT INTO users(name, email, mobile, password) VALUES(:name,:email, :mobile, :password)";
    $query = $db->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $db->lastInsertId();
    if ($lastInsertId) {
        echo "<script>alert('Thanks For Register, Continue Your Shopping')</script>";
        echo "<script type='text/javascript'> document.location = 'login.php'; </script>";
    } else {
        echo "<script>alert('Please Fill All Valid Details')</script>";
    }
}

?>
<!-- login form -->
<section class=" py-3 py-md-5 py-xl-5" style="background-color: #FBFCF8;">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-12 col-md-6 col-xl-6">
                <div class="d-flex justify-content-center">
                    <div class="col-12 col-xl-9 text-center"> 
                        <img class="img-fluid rounded mb-2" loading="lazy"
                            src="https://www.zarmoney.com/hs-fs/hubfs/features/Tokyo/user-role-based-security.png?width=1200&height=1200&name=user-role-based-security.png"
                            width="600" alt="login">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-6">
                <div class="card rounded-4">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <h3>Sign Up</h3>
                                    <p>Already have an account? <a href="./Login.html"
                                            class="text-primary text-darker">Sign in</a></p>
                                </div>
                            </div>
                        </div>
                        <form method="post">
                            <div class="row gy-3 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="name" id="username"
                                            placeholder="Enter Name" required>
                                        <label for="username" class="form-label">Name</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Enter Email" required>
                                        <label for="email" class="form-label">Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="mobile" id="number"
                                            placeholder="Enter Number" required>
                                        <label for="number" class="form-label">Phone</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" name="password" id="password"
                                            value="" placeholder="Enter Password" required>
                                        <label for="password" class="form-label">Password</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-lg" name="submit" type="submit">Sign
                                            Up</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- footer -->
<?php include ('./common/footer.php'); ?>
</body>

</html>