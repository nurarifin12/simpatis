<?php
include 'db_connect.php';

ob_start();

if (isset($_SESSION['login_id']) && isset($_SESSION['login_type'])) {
    $login_type = $_SESSION['login_type']; // Ambil nilai login_type dari sesi

    if (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1) { ?>
        <div class="col-lg-12">
            <div class="d-flex w-100 justify-content-center align-items-center mb-2">
                <label for="" class="control-label">Find Survey</label>
                <div class="input-group input-group-sm col-sm-5">
                    <input type="text" class="form-control" id="filter" placeholder="Enter keyword...">
                    <span class="input-group-append">
                        <button type="button" class="btn btn-primary btn-flat" id="search">Search</button>
                    </span>
                </div>
            </div>
            <div class="w-100" id='ns' style="display: none">
                <center><b>No Result.</b></center>
            </div>
            <div class="row">
                <?php
                $survey = $conn->query("SELECT * FROM survey_set ORDER BY RAND()");
                while ($row = $survey->fetch_assoc()) :
                ?>
                    <div class="col-lg-6 py-1 px-1 survey-item">
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
                                        <a href="index.php?page=view_survey_report&id=<?php echo $row['id'] ?>" class="btn btn-sm bg-gradient-primary"><i class="fa fa-poll"></i> View Report</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
<?php
    } else {
        echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
    }
} else {
    echo "Anda belum login.";
}
?>

<script>
    function find_survey() {
        start_load()
        var filter = $('#filter').val()
        filter = filter.toLowerCase()
        console.log(filter)
        $('.survey-item').each(function() {
            var txt = $(this).text()
            if ((txt.toLowerCase()).includes(filter) == true) {
                $(this).toggle(true)
            } else {
                $(this).toggle(false)
            }
            if ($('.survey-item:visible').length <= 0) {
                $('#ns').show()
            } else {
                $('#ns').hide()
            }
        })
        end_load()
    }
    $('#search').click(function() {
        find_survey()
    })
    $('#filter').keypress(function(e) {
        if (e.which == 13) {
            find_survey()
            return false;
        }
    })
</script>