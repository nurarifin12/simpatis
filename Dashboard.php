<?php include('db_connect.php') ?>
<?php include('./header.php'); ?>
<?php
$user_id = $_SESSION['login_id'];
$query = $conn->query("SELECT * FROM users WHERE id = $user_id");

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

<!-- Info boxes -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php if ($_SESSION['login_type'] == 1) : ?>
        <h2> <b>Selamat datang di SIMPATI</b> </h2>
        <p>SIMPATI merupakan singkatan dari Sistem Informasi Monitoring dan Evaluasi Pendidikan Tinggi</p>

        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM users where type >= 2")->num_rows; ?>
                            <sup style="font-size: 20px"></sup>
                        </h3>

                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="./index.php?page=user_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM users where type = 4")->num_rows; ?>
                            <sup style="font-size: 20px"></sup>
                        </h3>

                        <p>DOSEN</p>
                    </div>
                    <div class="icon">
                        <i class="nav-icon fa fa-regular fa-user"></i>
                    </div>
                    <a href="./index.php?page=user_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM users where type = 3")->num_rows; ?>
                            <sup style="font-size: 20px"></sup>
                        </h3>

                        <p>Mahasiswa</p>
                    </div>
                    <div class="icon">
                        <i class=" fa fa-regular fa-user"></i>
                    </div>
                    <a href="./index.php?page=user_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM users where type = 2")->num_rows; ?>
                            <sup style="font-size: 20px"></sup>
                        </h3>

                        <p>Staf/Karyawan</p>
                    </div>
                    <div class="icon">
                        <i class="nav-icon fa fa-regular fa-user"></i>
                    </div>
                    <a href="./index.php?page=user_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM users where type = 5")->num_rows; ?>
                            <sup style="font-size: 20px"></sup>
                        </h3>

                        <p>Mitra</p>
                    </div>
                    <div class="icon">
                        <i class="nav-icon fa fa-regular fa-user"></i>
                    </div>
                    <a href="./index.php?page=user_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM users where type = 6")->num_rows; ?>
                            <sup style="font-size: 20px"></sup>
                        </h3>

                        <p>Alumni</p>
                    </div>
                    <div class="icon">
                        <i class="nav-icon fa fa-regular fa-user"></i>
                    </div>
                    <a href="./index.php?page=user_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3> <?php echo $conn->query("SELECT * FROM survey_set")->num_rows; ?><sup style="font-size: 20px"></sup></h3>

                        <p>Total Survey</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-poll-h"></i>
                    </div>
                    <a href="./index.php?page=survey_list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
    <?php else : ?>
        <h2 class=" text-primary text-bold">
            Selamat datang <?php echo ucwords($name) ?>! <br>
        </h2>
        <p class=" text-md text-lg">
            SIMPATI - Sistem Informasi Monitoring dan Evaluasi Perguruan Tinggi <br>
            SIMPATI UNUGHA merupakan sistem yang digunakan untuk merancang dan melaksanakan evaluasi manajemen pengelolaan
            perguruan tinggi berbasis instrumen kuesioner atau survei. </p>
        <h2>Panduan survei </h2>
        <p>1. Pilihlah jawaban sesuai dengan kondisi yang ada <br>
            2. Apabila ada isian deskripsi, mohon untuk diisi dalam bentuk narasi singkat yang dapat menjelaskan kondisi
            jawaban dalam pertanyaan <br>
            3. Survei akan memerlukan waktu dalam rentang 1-5 menit dalam pengisian</p>
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                    <div class="inner">
                        <h3>
                            <?php echo $conn->query("SELECT distinct(survey_id) FROM answers  where user_id = {$_SESSION['login_id']}")->num_rows; ?><sup style="font-size: 20px"></sup>
                        </h3>

                        <p>Total Survey Diisi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-poll-h"></i>
                    </div>
                    <a href="./index.php?page=survey_widget" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Ini Bekas Survey -->
            <!-- End -->
        </div>
        <div class="row">
            <?php
            // Ambil user_id dari sesi
            $user_id = $_SESSION['login_id'];

            // Ambil type pengguna dari tabel users
            $user_query = $conn->query("SELECT type FROM users WHERE id = $user_id ");
            $user = $user_query->fetch_assoc();
            $user_type = $user['type'];
            $survey = $conn->query("
            SELECT survey_set.* 
            FROM survey_set 
            LEFT JOIN survey_user ON survey_set.id = survey_user.survey_id
            WHERE survey_set.end_date 
            AND survey_user.user_id = $user_type ");
            // Cek apakah pengguna sudah login dan memiliki type 3

            while ($row = $survey->fetch_assoc()) :
            ?>
                <div class="col-md-3 py-1 px-1 survey-item">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo ucwords($row['title']) ?></h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: block;">
                            <?php echo $row['description'] ?>
                            <div class="row">
                                <hr class="border-primary">
                                <div class="d-flex justify-content-center w-100 text-center">
                                    <?php if (!isset($ans[$row['id']])) : ?>
                                        <a href="index.php?page=answer_survey&id=<?php echo $row['id'] ?>" class="btn btn-sm bg-gradient-primary"><i class="fa fa-pen-square"></i> Take Survey</a>
                                    <?php else : ?>
                                        <a href="index.php?page=answer_survey&id=<?php echo $row['id'] ?>" class="btn btn-sm bg-gradient-primary"><i class="fa fa-pen-square"></i> Take Survey</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endwhile;

            ?>





        </div>
    <?php endif; ?>
</body>

</html>