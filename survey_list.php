<?php include 'db_connect.php' ?>

<?php
include 'db_connect.php';
ob_start();

if (isset($_SESSION['login_id']) && isset($_SESSION['login_type'])) {
    $login_type = $_SESSION['login_type'];

    if (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1) { ?>
<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary"
                    href="./index.php?page=new_survey"><i class="fa fa-plus"></i> Add New Survey</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover " id="list">
                <colgroup>
                    <col width="5%">
                    <col width="20%">
                    <col width="20%">
                    <col width="20%">
                    <col width="20%">
                    <col width="15%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            $i = 1;
                            $qry = $conn->query("SELECT * FROM survey_set order by date(start_date) asc,date(end_date) asc ");

                            // Cek apakah pengguna sudah login dan memiliki type 3
                            if (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1) {
                                while ($row = $qry->fetch_assoc()) :
                            ?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><?php echo ucwords($row['title']) ?></td>
                        <td class="truncate"><?php echo $row['description'] ?></td>
                        <td><?php echo date("M d, Y", strtotime($row['start_date'])) ?></td>
                        <td><?php echo date("M d, Y", strtotime($row['end_date'])) ?></td>
                        <td class="text-center">
                            <div class="btn-group px-2">
                                <!-- <a href="./index.php?page=edit_survey&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat">
                                                    <span class="material-symbols-outlined">
                                                        edit_square
                                                    </span>
                                                </a>
                                                <a href="./index.php?page=view_survey&id=<?php echo $row['id'] ?>" class="btn btn-success btn-flat">
                                                    <i class="fas fa-eye"></i>
                                                </a> -->
                                <a href="./index.php?page=view_survey&id=<?php echo $row['id'] ?>"
                                    class="badge bg-success text-light py-2 mx-1">View</a>
                                <a href="./index.php?page=edit_survey&id=<?php echo $row['id'] ?>"
                                    class="badge bg-primary text-light py-2 mx-1">Edit</a>
                                <button type="button" class="badge btn-danger btn-flat delete_survey"
                                    data-id="<?php echo $row['id'] ?>">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php
                                endwhile;
                            } else {
                                // Jika pengguna belum login atau type bukan 3, Anda dapat menambahkan logika atau mengarahkan ke halaman lain.
                                echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
                            }
                            ?>
                </tbody>
            </table>
        </div>
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
$(document).ready(function() {
    $('#list').dataTable()
    $('.delete_survey').click(function() {
        _conf("Yakin untuk hapus survei?", "delete_survey", [$(this).attr('data-id')])
    })
})

function delete_survey($id) {
    start_load()
    $.ajax({
        url: 'ajax.php?action=delete_survey',
        method: 'POST',
        data: {
            id: $id
        },
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Data berhasil dihapus", 'success')
                setTimeout(function() {
                    location.reload()
                }, 1500)
            }
        }
    })
}
</script>