<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db_connect.php';
include './header.php';


$name = $email = $contact = $address = $type = null;


$type_arr = [
    1 => 'Admin',
    2 => 'Staf/Karyawan',
    3 => 'Mahasiswa',
    4 => 'Dosen',
    5 => 'Mitra',
    6 => 'Alumni'
];


if (isset($_GET['id'])) {
    $user_id = $_GET['id'];


    if (!ctype_digit($user_id) || $user_id <= 0) {
        echo "Invalid user ID.";
        exit;
    }
} elseif (isset($_SESSION['login_id'])) {

    $user_id = $_SESSION['login_id'];
} else {

    echo "User ID not provided or set in session.";
    exit;
}


$qry = $conn->query("SELECT *, concat(lastname, ' ', firstname, ' ', middlename) as name FROM users WHERE id = $user_id");

if ($qry) {
    $row = $qry->fetch_assoc();

    if ($row) {
        foreach ($row as $k => $v) {
            $$k = $v;
        }
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "Error executing the query.";
    exit;
}


if (isset($_SESSION['login_id']) && $_SESSION['login_id'] != $user_id) {
    $query = $conn->query("SELECT * FROM users WHERE id = {$_SESSION['login_id']}");

    if ($query) {
        $user_data = $query->fetch_assoc();

        $name = $user_data['firstname'] . ' ' . $user_data['middlename'] . ' ' . $user_data['lastname'];
        $email = $user_data['email'];
        $contact = $user_data['contact'];
        $address = $user_data['address'];
        $type = $user_data['type'];
        $date = $user_data['date_created'];
    } else {
        echo "Error retrieving additional user data.";
        exit;
    }
}
?>


<div class="container-fluid">
    <table class="table" id="list">
        <tr>
            <th>Name:</th>
            <td><b><?php echo ucwords($name) ?></b></td>
        </tr>
        <tr>
            <th>Email:</th>
            <td><b><?php echo $email ?></b></td>
        </tr>
        <tr>
            <th>User Role:</th>
            <td><b><?php echo $type_arr[$type] ?></b></td>
        </tr>
         <tr>
                <th>Date created</th>
                <td><b><?php echo $date ?></b></td>
            </tr>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#list').dataTable();
    });
</script>