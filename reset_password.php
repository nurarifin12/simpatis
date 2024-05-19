<?php
session_start();
include('./db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>


    <?php include('./header.php'); ?>
</head>

<style>
    body {
        width: 100%;
        height: calc(100%);
        position: fixed;
        top: 0;
        left: 0
            /*background: #007bff;*/
    }

    main#main {
        width: 100%;
        height: calc(100%);
        display: flex;
    }

    span {
        color: blue;
    }

    h3 {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $newPassword = md5($_POST['new_password']);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "UPDATE users SET password = '$newPassword' WHERE email = '$email'";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Password updated successfully.</p>";
        } else {
            echo "Error updating password: " . $conn->error;
        }

        $conn->close();
    }
    ?>

    <main id="main" class="shadow-lg">
        <div class="align-self-center col-lg">
            <div id="login-center" class=" row justify-content-center">
                <div class="card col-md-4 shadow-lg">
                    <div class="card-body">
                        <!-- <img src="./assets/dist/img/logo.png" alt="" height="50px" class="align-self-center"> -->
                        <h3 class="text-center mb-4">Forgot<span> Password</span></h3>
                        <form method="post" id="login-form" action="">
                            <div class="mb-3">
                                <label for="email" class="control-label text-dark">Email </label>
                                <input type="email" class="form-control rounded-pill" name="email" required>

                            </div>
                            <div class="mb-3">
                                <label for="password" class="control-label text-dark">New Password</label>
                                <input type="password" class="form-control rounded-pill" name="new_password" required>

                            </div>
                            <hr>
                            <input type="submit" class="btn btn-sm btn-danger" value="Reset Password">
                        </form>
                        <div class="text-center">
                            <a class="small" href="login.php">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <!-- Form reset password -->
    <!-- <form method="post" action="">
        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>New Password:</label>
        <input type="password" name="new_password" required><br>

        <input type="submit" value="Reset Password">
    </form> -->
</body>

</html>