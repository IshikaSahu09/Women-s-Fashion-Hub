<?php include('./common/header.php'); ?>
<?php
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $sql = "SELECT id,name,email FROM users WHERE email=:email and password=:password";
    $query = $db->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetch(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        $_SESSION['login'] = $results->name;
        $_SESSION['user'] = $results->id;
        echo "<script>alert('Login Success, Continue Your Shopping')</script>";
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
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
                                src="images/log1.png" width="600" alt="login">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-6">
                    <div class="card rounded-4">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <h3>Sign in</h3>
                                        <p>Don't have an account? <a href="./register.php" class="text-primary text-darker">Sign
                                                up</a></p>
                                    </div>
                                </div>
                            </div>
                            <form method="post">
                                <div class="row gy-3 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="name@example.com" required>
                                            <label for="email" class="form-label">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password" id="password"
                                                value="" placeholder="Password" required>
                                            <label for="password" class="form-label">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn btn-primary btn-lg" name="submit" type="submit">Sign in</button>
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
        <?php include('./common/footer.php');?>
</body>

</html>