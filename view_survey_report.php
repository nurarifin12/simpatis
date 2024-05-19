<?php include 'db_connect.php' ?>
<?php include('./header.php'); ?>
<?php
$qry = $conn->query("SELECT * FROM survey_set where id = " . $_GET['id'])->fetch_array();
foreach ($qry as $k => $v) {
    if ($k == 'title')
        $k = 'stitle';
    $$k = $v;
}
if (isset($_GET['thn'])) {
    $taken = $conn->query("SELECT distinct(user_id) from answers where survey_id ={$id} AND tahun = " . $_GET['thn'])->num_rows;

    $answers = $conn->query("SELECT a.*,q.type from answers a inner join questions q on q.id = a.question_id where a.survey_id ={$id} AND a.tahun = " . $_GET['thn']);
} else {
    $taken = $conn->query("SELECT distinct(user_id) from answers where survey_id ={$id}")->num_rows;
    $answers = $conn->query("SELECT a.*,q.type from answers a inner join questions q on q.id = a.question_id where a.survey_id ={$id}");
}
$ans = array();
// var_dump($_GET['thn']);
// exit();

while ($row = $answers->fetch_assoc()) {
    if ($row['type'] == 'radio_opt') {
        $ans[$row['question_id']][$row['answer']][] = 1;
    }
    if ($row['type'] == 'check_opt') {
        foreach (explode(",", str_replace(array("[", "]"), '', $row['answer'])) as $v) {
            $ans[$row['question_id']][$v][] = 1;
        }
    }
    if ($row['type'] == 'textfield_s') {
        $ans[$row['question_id']][] = $row['answer'];
    }
}

ob_start();

if (isset($_SESSION['login_id']) && isset($_SESSION['login_type'])) {
    $login_type = $_SESSION['login_type'];

    if (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1) { ?>
        <?php if ($ans) { ?>
            <div class="col-lg">
                <a href="./index.php?page=survey_report" data-id="<?php echo $row['id'] ?>" class="badge bg-danger text-light py-3 px-4 my-2 view_user"> Back</a>
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b>Grafik</b></h3>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle mx-5" type="button" data-toggle="dropdown" aria-expanded="false">
                                Tahun
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="./index.php?page=view_survey_report&id=<?= $_GET['id']; ?>&thn=2021">2021</a>
                                <a class="dropdown-item" href="./index.php?page=view_survey_report&id=<?= $_GET['id']; ?>&thn=2022">2022</a>
                                <a class="dropdown-item" href="./index.php?page=view_survey_report&id=<?= $_GET['id']; ?>&thn=2023">2023</a>
                                <a class="dropdown-item" href="./index.php?page=view_survey_report&id=<?= $_GET['id']; ?>&thn=2024">2024</a>
                                <a class="dropdown-item" href="./index.php?page=view_survey_report&id=<?= $_GET['id']; ?>&thn=2025">2025</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 py-2">
                        <div class="">
                            <div class="px-3">
                                <p class="fs-5">Total User Mengisi : <?= $taken; ?></p>
                            </div>
                            <div class="px-3">
                                <p class="fs-5">Data pada tahun : <?= isset($_GET['thn']) ? $_GET['thn'] : 'Semua Tahun'; ?> </p>
                            </div>
                            <div class="small-box">
                                <div class="inner">
                                    <canvas id="grafik_stats"></canvas>
                                </div>
                                <div id="piechart_2d">
                                    <canvas id="doughnut_stats"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><b>Survey Details</b></h3>

                            </div>
                            <div class="card-body p-0 py-2">
                                <div class="container-fluid">
                                    <p>Title: <b><?php echo $stitle ?></b></p>
                                    <p class="mb-0">Description:</p>
                                    <small><?php echo $description; ?></small>
                                    <p>Start: <b><?php echo date("M d, Y", strtotime($start_date)) ?></b></p>
                                    <p>End: <b><?php echo date("M d, Y", strtotime($end_date)) ?></b></p>
                                    <p>Have Taken: <b><?php echo number_format($taken) ?></b></p>


                                </div>
                                <hr class="border-primary">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h3 class="card-title"><b>Survey Report</b></h3>
                                <div class="card-tools">
                                    <button class="btn btn-flat btn-sm bg-gradient-success" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                            <div class="card-body ui-sortable">
                                <?php
                                $question = $conn->query("SELECT * FROM questions where survey_id = $id order by abs(order_by) asc,abs(id) asc");
                                while ($row = $question->fetch_assoc()) :
                                ?>
                                    <div class="callout callout-info">
                                        <h5><?php echo $row['question'] ?></h5>
                                        <div class="col-md-12">
                                            <input type="hidden" name="qid[<?php echo $row['id'] ?>]" value="<?php echo $row['id'] ?>">
                                            <input type="hidden" name="type[<?php echo $row['id'] ?>]" value="<?php echo $row['type'] ?>">

                                            <?php if ($row['type'] != 'textfield_s') : ?>
                                                <ul>
                                                    <?php foreach (json_decode($row['frm_option']) as $k => $v) :
                                                        $prog = ((isset($ans[$row['id']][$k]) ? count($ans[$row['id']][$k]) : 0) / $taken) * 100;
                                                        $prog = round($prog, 2);
                                                    ?>
                                                        <li>
                                                            <div class="d-block w-100">
                                                                <b><?php echo $v ?></b>
                                                            </div>
                                                            <div class="d-flex w-100">
                                                                <span class=""><?php echo isset($ans[$row['id']][$k]) ? count($ans[$row['id']][$k]) : 0 ?>/<?php echo $taken ?></span>
                                                                <div class="mx-1 col-sm-8">
                                                                    <div class=" progress w-100">
                                                                        <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
                                                                            <span class="sr-only"><?php echo $prog ?>%</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <span class="badge badge-info"><?php echo $prog ?>%</span>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else : ?>
                                                <div class="d-block tfield-area w-100 bg-dark">
                                                    <?php if (isset($ans[$row['id']])) : ?>
                                                        <?php foreach ($ans[$row['id']] as $val) : ?>
                                                            <blockquote class="text-dark"><?php echo $val ?></blockquote>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>

            <div class="col-lg">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b>Grafik</b></h3>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle mx-5" type="button" data-toggle="dropdown" aria-expanded="false">
                                Tahun
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="./index.php?page=view_survey_report&id=<?= $_GET['id']; ?>&thn=2021">2021</a>
                                <a class="dropdown-item" href="./index.php?page=view_survey_report&id=<?= $_GET['id']; ?>&thn=2022">2022</a>
                                <a class="dropdown-item" href="./index.php?page=view_survey_report&id=<?= $_GET['id']; ?>&thn=2023">2023</a>
                                <a class="dropdown-item" href="./index.php?page=view_survey_report&id=<?= $_GET['id']; ?>&thn=2024">2024</a>
                                <a class="dropdown-item" href="./index.php?page=view_survey_report&id=<?= $_GET['id']; ?>&thn=2025">2025</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 py-2">
                        <div class="">
                            <div class="px-3">
                                <p class="fs-5">Total User Mengisi : <?= $taken; ?></p>
                            </div>
                            <div class="px-3">
                                <p class="fs-5">Data pada tahun : <?= isset($_GET['thn']) ? $_GET['thn'] : 'Semua Tahun'; ?></p>
                            </div>
                            <div class="">
                                <h4 class="text-center fw-bold">TIDAK ADA DATA</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><b>Survey Details</b></h3>

                            </div>
                            <div class="card-body p-0 py-2">
                                <div class="container-fluid">
                                    <p>Title: <b><?php echo $stitle ?></b></p>
                                    <p class="mb-0">Description:</p>
                                    <small><?php echo $description; ?></small>
                                    <p>Start: <b><?php echo date("M d, Y", strtotime($start_date)) ?></b></p>
                                    <p>End: <b><?php echo date("M d, Y", strtotime($end_date)) ?></b></p>
                                    <p>Have Taken: <b><?php echo number_format($taken) ?></b></p>


                                </div>
                                <hr class="border-primary">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h3 class="card-title"><b>Survey Report</b></h3>
                                <div class="card-tools">
                                    <button class="btn btn-flat btn-sm bg-gradient-success" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                            <div class="card-body ui-sortable">
                                <h6>TIDAK ADA DATA</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
<?php
    } else {
        echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
    }
} else {
    echo "Anda belum login.";
}
?>
<style>
    .tfield-area {
        max-height: 30vh;
        overflow: auto;
    }
</style>
<!-- MENGHITUNG PERSENTASI KESELURUHAN -->
<?php
$hasil = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0]; // Inisialisasi $hasil
$hasilYaNo = [1 => 0, 2 => 0]; // Inisialisasi $hasil
if (isset($_GET['thn'])) {
    $question = $conn->query("SELECT questions.* FROM questions LEFT JOIN answers ON questions.id = answers.question_id  WHERE answers.survey_id = $id AND answers.tahun = " . $_GET['thn'] . " GROUP BY questions.id ORDER BY abs(order_by) ASC, abs(questions.id) ASC");
} else {
    $question = $conn->query("SELECT * FROM questions WHERE survey_id = $id ORDER BY abs(order_by) ASC, abs(id) ASC");
}


while ($row = $question->fetch_assoc()) {
    if ($row['type'] != 'textfield_s') {
        // Tambahkan pengkondisian untuk memeriksa apakah 'yes' ada dalam frm_option
        if (strpos($row['frm_option'], 'tidak') === false) {
            $mergedAnswers = array(); // Array untuk menggabungkan jawaban yang sama

            foreach (json_decode($row['frm_option']) as $k => $v) {
                // Inisialisasi jumlah jawaban dengan nilai yang sama
                $count = 0;

                // Periksa apakah jawaban dengan nilai yang sama ada dalam $ans
                if (isset($ans[$row['id']][$k])) {
                    $count = count($ans[$row['id']][$k]);
                }

                // Gabungkan jawaban dengan nilai yang sama
                if (isset($mergedAnswers[$v])) {
                    $mergedAnswers[$v] += $count;
                } else {
                    $mergedAnswers[$v] = $count;
                }

                // Jumlahkan hasil yang telah digabungkan dengan $hasil
                $hasil = array_map(function ($a, $b) {
                    return $a + $b;
                }, $hasil, $mergedAnswers);
            }
        } else {
            $mergedAnswersYaNo = array(); // Array untuk menggabungkan jawaban yang sama

            foreach (json_decode($row['frm_option']) as $k => $v) {
                // Inisialisasi jumlah jawaban dengan nilai yang sama
                $count = 0;

                // Periksa apakah jawaban dengan nilai yang sama ada dalam $ans
                if (isset($ans[$row['id']][$k])) {
                    $count = count($ans[$row['id']][$k]);
                }

                // Gabungkan jawaban dengan nilai yang sama
                if (isset($mergedAnswers[$v])) {
                    $mergedAnswersYaNo[$v] += $count;
                } else {
                    $mergedAnswersYaNo[$v] = $count;
                }

                // Jumlahkan hasil yang telah digabungkan dengan $hasil
                $hasilYaNo = array_map(function ($a, $b) {
                    return $a + $b;
                }, $hasilYaNo, $mergedAnswersYaNo);

                 // Jumlahkan hasil yang telah digabungkan dengan $hasil
                 $hasil = array_map(function ($a, $b) {
                    return $a + $b;
                }, $hasil, $mergedAnswers);
            }
        }
    }
}

// Hitung total jawaban
$totalJawaban = array_sum($hasil);



if ($totalJawaban != 0) {
    $hasil = array_map(function ($a) use ($totalJawaban) {
        return round(($a / $totalJawaban) * 100, 2);
    }, $hasil);
   
}

?>

<script src="assets/node_modules/chartjs/dist/chart.umd.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the canvas element
        const grafik_chart = document.getElementById('grafik_stats').getContext('2d');
        const doughnut_chart = document.getElementById('doughnut_stats').getContext('2d');
        const color = ['#16FF00', '#E84545'];

        // Function to update doughnut chart
        function updateDoughnutChart(labels, data) {
            doughnutChart.data.labels = labels;
            doughnutChart.data.datasets[0].data = data;
            doughnutChart.update();
        }

        <?php
        $question = $conn->query("SELECT * FROM questions WHERE survey_id = $id ORDER BY abs(order_by) ASC, abs(id) ASC");
        $questions_array = array();
        while ($row = $question->fetch_assoc()) {
            $options = json_decode($row['frm_option'], true); // Mendecode string JSON menjadi array asosiatif
            // Ekstrak nilai dari array asosiatif dan gabungkan ke $questions_array
            $questions_array = array_merge($questions_array, array_values($options));
        }

        // Hapus duplikat dari array
        $questions_array = array_unique($questions_array);

        // Konversi array menjadi array yang diindeks sederhana
        $questions_array = array_values($questions_array);
        ?>

        // Echo variabel pertanyaan sebagai variabel JavaScript
        const questions = <?php echo json_encode($questions_array); ?>;

        // Menampilkan variabel JavaScript di konsol
        console.log(questions);

        const value_doughnut = <?php echo json_encode($hasil); ?>;
        console.log('value_doughnut');
        console.log(value_doughnut);
        // Tentukan warna berdasarkan jumlah pertanyaan
        const colors = ['#FF5733', '#FFC300', '#44E500', '#007BFF', '#9300E5']; // Warna default
        if (questions.length > 0) {
            // Tentukan warna tambahan berdasarkan jumlah pertanyaan
            for (let i = colors.length; i < questions.length; i++) {
                colors.push('#' + Math.floor(Math.random() * 16777215).toString(16)); // Menghasilkan warna hex acak
            }
        }

        // Tentukan label berdasarkan pertanyaan
        const labels_doughnut = questions;

        const doughnutChart = new Chart(doughnut_chart, {
            type: 'doughnut', // Anda dapat mengubah jenis grafik sesuai kebutuhan
            data: {
                labels: labels_doughnut,
                label: 'Persentase Kepuasan',
                datasets: [{
                    data: value_doughnut,
                    backgroundColor: colors
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var label = data.labels[tooltipItem.index];
                            var value = dataset.data[tooltipItem.index];
                            return label + ': ' + value + '%';
                        }
                    }
                }
            }
        });

        // Handle dropdown change event
        $('.dropdown-item').on('click', function(e) {
            e.preventDefault();
            var year = $(this).attr('data-year'); // Get selected year from data attribute
            var url = $(this).attr('href'); // Get URL from href attribute
            // Redirect to URL with selected year
            location.href = url;
        });

    });
</script>