<?php require_once("../header/header.php"); ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["register"])) {
    function validated_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    try {
        $username   = validated_input($_POST['username']);
        $email      = validated_input($_POST['email']);
        $password   = validated_input($_POST['password']);

        if (empty($username)) {
            throw new Exception('The username field is empty!');
        }

        if (empty($email)) {
            throw new Exception('The email field is empty!');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email is Invalid!');
        }

        if (empty($password)) {
            throw new Exception('The password field is empty!');
        }

        $filePath = "C:/laragon/www/PHP/File Operations/CRUD_OPERATION/database/db.txt";

        if (file_exists($filePath) && is_writable($filePath)) {
            $data = json_decode(file_get_contents($filePath), true) ?? [];

            foreach ($data as $item) {
                if ($item['email'] == $email) {
                    throw new Exception('Email Already Exists!');
                }
            }

            // Generate a unique ID by finding the maximum ID in the existing data
            $maxId = 0;
            foreach ($data as $item) {
                if ($item['id'] > $maxId) {
                    $maxId = $item['id'];
                }
            }

            $id = $maxId + 1;

            $registerData = [
                'id' => $id,
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ];

            array_push($data, $registerData);
            file_put_contents($filePath, json_encode($data));
            $_SESSION['success'] = "Successfully registered.";
            header("location:" . BASE_URL . "/login/index.php");
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

?>


<section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="mx-1 mx-md-4">
                                    <?php if (isset($errorMessage)) :  ?>
                                        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                                    <?php endif; ?>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="text" name="username" id="form3Example1c" class="form-control" />
                                            <label class="form-label" for="form3Example1c">Your Userame</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="email" name="email" id="form3Example3c" class="form-control" />
                                            <label class="form-label" for="form3Example3c">Your Email</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="password" name="password" id="form3Example4c" class="form-control" />
                                            <label class="form-label" for="form3Example4c">Password</label>
                                        </div>
                                    </div>

                                    <!-- <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="password" id="form3Example4cd" class="form-control" />
                                            <label class="form-label" for="form3Example4cd">Repeat your password</label>
                                        </div>
                                    </div> -->

                                    <div class="form-check d-flex justify-content-center mb-5">
                                        <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" />
                                        <label class="form-check-label" for="form2Example3">
                                            I agree all statements in <a href="#!">Terms of service</a>
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">

                                        <button type="submit" name="register" class="btn btn-primary btn-lg">Register</button>
                                    </div>

                                </form>

                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp" class="img-fluid" alt="Sample image">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once("../header/footer.php"); ?>