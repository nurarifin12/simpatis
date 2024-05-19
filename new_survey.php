<?php
if (!isset($conn)) {
	include 'db_connect.php';
}
?>

<?php
include 'db_connect.php';
ob_start();

if (isset($_SESSION['login_id']) && isset($_SESSION['login_type'])) {
	$login_type = $_SESSION['login_type'];

	if (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1) { ?>
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<form action="" id="manage_survey">
						<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
						<div class="row">
							<div class="col-md-6 border-right">
								<div class="form-group">
									<label for="" class="control-label">Title</label>
									<input type="text" name="title" class="form-control form-control-sm" required value="<?php echo isset($stitle) ? $stitle : '' ?>">
								</div>
								<div class="form-group">
									<label for="" class="control-label">Start</label>
									<input type="date" name="start_date" class="form-control form-control-sm" required value="<?php echo isset($start_date) ? $start_date : '' ?>">
								</div>
								<div class="form-group">
									<label for="" class="control-label">End</label>
									<input type="date" name="end_date" class="form-control form-control-sm" required value="<?php echo isset($end_date) ? $end_date : '' ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Description</label>
									<textarea name="description" id="" cols="30" rows="4" class="form-control" required><?php echo isset($description) ? $description : '' ?></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="control-label">Type User</label><br>
									<input type="checkbox" name="user_id[]" value="2" <?php echo (isset($user_id) && is_array($user_id) && in_array('2', $user_id)) ? 'checked' : '' ?>> Staff <br>
									<input type="checkbox" name="user_id[]" value="3" <?php echo (isset($user_id) && is_array($user_id) && in_array('3', $user_id)) ? 'checked' : '' ?>> Mahasiswa <br>
									<input type="checkbox" name="user_id[]" value="4" <?php echo (isset($user_id) && is_array($user_id) && in_array('4', $user_id)) ? 'checked' : '' ?>> Dosen <br>
									<input type="checkbox" name="user_id[]" value="5" <?php echo (isset($user_id) && is_array($user_id) && in_array('5', $user_id)) ? 'checked' : '' ?>> Mitra <br>
									<input type="checkbox" name="user_id[]" value="6" <?php echo (isset($user_id) && is_array($user_id) && in_array('6', $user_id)) ? 'checked' : '' ?>> Alumni <br>
								</div>
							</div>

						</div>
						<hr>
						<div class="col-lg-12 text-right justify-content-center d-flex">
							<button class="btn btn-primary mr-2">Save</button>
							<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=survey_list'">Cancel</button>
						</div>
					</form>
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
	$('#manage_survey').submit(function(e) {
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		$.ajax({
			url: 'ajax.php?action=save_survey',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast('Data successfully saved.', "success");
					setTimeout(function() {
						location.replace('index.php?page=survey_list')
					}, 1500)
				}
			}
		})
	})
</script>