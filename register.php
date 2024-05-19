<?php include('db_connect.php'); ?>
<?php include('./header.php'); ?>

<?php
error_reporting(0);

session_start();

// if (isset($_SESSION['username'])) {
//     header("Location: index.php");
// }

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $type = $_POST['type'];

    if ($password == $cpassword) {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO users (firstname, lastname, email, password, type)
					VALUES ('$firstname','$lastname', '$email', '$password', '$type')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('Wow! User Registration Completed.')</script>";
                header("location:login.php");
                $username = "";
                $email = "";
                $_POST['password'] = "";
                $_POST['cpassword'] = "";
            } else {
                echo "<script>alert('Woops! Something Wrong Went.')</script>";
            }
        } else {
            echo "<script>alert('Woops! Email Already Exists.')</script>";
        }
    } else {
        echo "<script>alert('Password Not Matched.')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Register</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>

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
</style>

<body>


    <main id="main" class="shadow-lg">

        <div class="align-self-center col-lg">
            <div id="login-center" class="justify-content-center">
                <div class="card shadow-lg justify-content-center col-md-4 my-5 mx-auto">

                    <div class="card-body text-center my-2">
                        <h3>Create Account</h3>
                        <form action="" id="manage_user" method="post">
                            <div class="form-group mb-3">
                                <input type="text" class="form-control rounded-pill" name="firstname"
                                    aria-describedby="emailHelp" placeholder="Firstname"
                                    value="<?php echo $firstname; ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <input type="text" class="form-control rounded-pill" name="lastname"
                                    aria-describedby="emailHelp" placeholder="Lastname" value="<?php echo $lastname; ?>"
                                    required>
                            </div>
                            <div class="form-group mb-3">
                                <input type="email" class="form-control rounded-pill" name="email"
                                    placeholder="Enter your email address..." aria-describedby="emailHelp"
                                    value="<?php echo $email; ?>" required>
                                <small id="#msg"></small>
                            </div>
                            <div class="form-group row mb-3">
                                <select name="type" id="type" class=" custom-select rounded-pill">
                                     <option value="">
                                        Select User
                                    </option>
                                    <option value="3">
                                        Mahasiswa
                                    </option>
                                    <option value="2">
                                        Staff/Karyawan
                                    </option>
                                    <option value="4">Dosen
                                    </option>
                                    <option value="5">Mitra
                                    </option>
                                    <option value="6">Alumni
                                    </option>
                                </select>
                                <div class="col-sm-6 mb-3 mt-2 mb-sm-0">

                                    <input type="password" class="form-control rounded-pill" name="password"
                                        placeholder="Enter your password" value="<?php echo $_POST['password']; ?>"
                                        required>
                                    <small></i></small>
                                </div>
                                <div class="col-sm-6 mt-2 ">
                                    <input type="password" class="form-control rounded-pill" name="cpassword"
                                        placeholder="Confirm password" value="<?php echo $_POST['cpassword']; ?>"
                                        required>
                                    <small id="pass_match" data-status=''></small>
                                </div>
                            </div>
                            <hr>
                            <button name="submit" class=" btn btn-block rounded-pill btn-primary">Register</button>
                        </form>
                        <div class="text-center">
                            <a class="small" href="./login.php">Have Account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>