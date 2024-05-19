<?php include('./header.php'); ?>
<?php include 'db_connect.php' ?>

<?php

$user_id = $_SESSION['login_id'];
$query = $conn->query("SELECT * FROM users WHERE id = $user_id");

if ($query) {
    $user_data = $query->fetch_assoc();

    $name = $user_data['firstname'] . ' ' . $user_data['lastname'];
    $email = $user_data['email'];
    $contact = $user_data['contact'];
    $address = $user_data['address'];
    $type = $user_data['type'];
    $date = $user_data['date_created'];

    $type_arr = [
        1 => 'Admin',
        2 => 'Staf/Karyawan',
        3 => 'Mahasiswa',
        4 => 'Dosen',
        5 => 'Mitra',
        6 => 'Alumni'
    ];

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand fixed-top navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>
    <ul class="navbar-nav ml-auto">

        <li class="nav-item">

            <span class="brand-text text-dark text-bold"><?php echo ucwords($name) ?></span> /
            <span><?php echo $type_arr[$type] ?></span>
            <img class="img-profile rounded-circle" src="assets/default.jpg" width="30px">

            <!-- Dropdown - User Information -->
        </li>
    </ul>


</nav>
<?php
} else {
    echo "Error retrieving user data.";
}
?>
<!-- /.navbar -->