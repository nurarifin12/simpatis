<?php

$conn = new mysqli('localhost', 'root', '', 'survey_db') or die("Could not connect to mysql" . mysqli_error($con));

// ambil data dari form input
$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$email = $_POST['email'];
$role = $_POST['type'];
$password = $_POST['password'];
$cpass = $_POST['cpass'];


// Periksa apakah password dan konfirmasi password cocok
if ($password != $cpass) {
    echo "Password dan konfirmasi password tidak cocok. Silakan coba lagi.";
} else {
    // Periksa apakah email sudah ada dalam database
    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($result->num_rows > 0) {
        echo "email sudah digunakan. Silakan coba lagi.";
    } else {
        // Tambahkan user baru ke database
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users(firstname, lastname, email, password, type) VALUES ('$firstName','$lastName', '$email', '$hashed_password', '$role',)";
        if ($conn->query($query) === true) {
            echo "Pendaftaran berhasil. Silakan login.";
            header('Location: login.php');
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    }
}
