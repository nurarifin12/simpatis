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
                    <a class="btn btn-block btn-sm btn-primary" href="./index.php?page=new_user"><i class="fa fa-plus"></i> Add
                        New User</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover" id="list">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $type = array('', "Admin", "Staff/Karyawan", "Mahasiswa", "Dosen", "Mitra", "Alumni");
                        $qry = $conn->query("SELECT *,concat(firstname,' ',lastname,' ') as name FROM users order by concat(firstname,', ',lastname,' ') asc");
                        while ($row = $qry->fetch_assoc()) :
                        ?>
                            <tr>
                                <th class="text-center"><?php echo $i++ ?></th>
                                <td><?php echo ucwords($row['name']) ?></td>
                                <td><?php echo $type[$row['type']] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" class="badge bg-success text-light py-2 view_user">View</a>
                                    <a href="./index.php?page=edit_user&id=<?php echo $row['id'] ?>" class="badge bg-primary text-light py-2">Edit</a>
                                    <a href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" class="badge bg-danger text-light py-2 delete_user">Delete</a>

                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <!-- <table class="table tabe-hover table-bordered" id="list">
                
            </table> -->
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
        $('.view_user').click(function() {
            uni_modal("<i class='fa fa-id-card'></i> User Details", "view_user.php?id=" + $(this).attr(
                'data-id'))
        })
        $('.delete_user').click(function() {
            _conf("Yakin untuk hapus user?", "delete_user", [$(this).attr('data-id')])
        })
    })

    function delete_user($id) {
        start_load()
        $.ajax({
            url: 'ajax.php?action=delete_user',
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