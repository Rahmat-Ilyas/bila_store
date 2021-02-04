<!-- MODAL ADMIN -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-admin">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Setup Account Admin</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" id="setAdmin">
				<div class="modal-body px-5" style="margin-bottom: -20px;">
					<h6>Username Sekarang: <b>"<i class="username_admin"><?= $username_admin ?></i></b>"</h6>
					<hr>
					<b><u>Update akun login Admin BilaStore</u></b>
					<div class="form-group mt-3">
						<label>Username</label>
						<input type="text" class="form-control" id="username_admin" name="username" value="<?= $username_admin ?>" required autocomplete="off" placeholder="Masukkan Username">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" id="password" name="password" autocomplete="off" placeholder="Masukkan Password Baru">
						<div class="text-info">
							*Masukkan password baru untuk mengganti password
						</div>
					</div>
				</div>
				<div class="modal-footer bg-whitesmoke br">
					<input type="hidden" name="req" value="setAdmin">
					<button type="submit" class="btn btn-primary">Update</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- MODAL RESELLER -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-reseller">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Setup Account Reseller</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" id="setReseller">
				<div class="modal-body px-5" style="margin-bottom: -20px;">
					<h6>Username Sekarang: <b>"<i class="username_reseller"><?= $username_reseller ?></i></b>"</h6>
					<hr>
					<b><u>Update akun login Reseller BilaStore</u></b>
					<div class="form-group mt-3">
						<label>Username</label>
						<input type="text" class="form-control" id="username_reseller" name="username" value="<?= $username_reseller ?>" required autocomplete="off" placeholder="Masukkan Username">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" id="password_res" name="password" autocomplete="off" placeholder="Masukkan Password Baru">
						<div class="text-info">
							*Masukkan password baru untuk mengganti password
						</div>
					</div>
				</div>
				<div class="modal-footer bg-whitesmoke br">
					<input type="hidden" name="req" value="setReseller">
					<button type="submit" class="btn btn-primary">Update</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>
<footer class="main-footer">
	<div class="footer-left">
		Copyright &copy; <?= date('Y') ?> <div class="bullet"></div> BilaStore</a>
	</div>
	<div class="footer-right">

	</div>
</footer>
</div>
</div>

<!-- General JS Scripts -->
<script src="../assets/modules/popper.js"></script>
<script src="../assets/modules/tooltip.js"></script>
<script src="../assets/modules/bootstrap/js/bootstrap.min.js"></script>
<script src="../assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="../assets/modules/moment.min.js"></script>
<script src="../assets/js/stisla.js"></script>

<!-- JS Libraies -->
<script src="../assets/modules/datatables/datatables.min.js"></script>
<script src="../assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
<script src="../assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

<!-- Page Specific JS File -->
<script src="../assets/js/page/modules-datatables.js"></script>
<script src="../assets/modules/sweetalert/sweetalert.min.js"></script>
<script src="../assets/modules/sweetalert2/sweetalert2.all.min.js"></script>

<script src="../assets/modules/dropzone/min/dropzone.min.js"></script>

<!-- Template JS File -->
<script src="../assets/js/scripts.js"></script>
<script src="../assets/js/custom.js"></script>
<script>
	$(document).ready(function() {
		// ADMIN
		$('#setAdmin').submit(function(e) {
			e.preventDefault();
			var data = $('#setAdmin').serialize();

			$.ajax({
				url     : 'controller.php',
				method  : "POST",
				data    : data,
				success : function(data) {
					swal({
						title: 'Berhasil diupdate',
						text: 'Akun login admin berhasil diperbaharui',
						icon: 'success',
					});
					$('.username_admin').text(data);
					$('#username_admin').val(data);
					$('#password').val('');
					$('#modal-admin').modal('hide');
				}
			});
		});

		// RESELLER
		$('#setReseller').submit(function(e) {
			e.preventDefault();
			var data = $('#setReseller').serialize();

			$.ajax({
				url     : 'controller.php',
				method  : "POST",
				data    : data,
				success : function(data) {
					swal({
						title: 'Berhasil diupdate',
						text: 'Akun login reseller berhasil diperbaharui',
						icon: 'success',
					});
					$('.username_reseller').text(data);
					$('#username_reseller').val(data);
					$('#password_res').val('');
					$('#modal-reseller').modal('hide');
				}
			});
		});
	});
</script>
</body>
</html>