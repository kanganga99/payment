<?php include('db_connect.php'); ?>
<style>
	input[type=checkbox] {
		/* Double-sized Checkboxes */
		-ms-transform: scale(1.3);
		/* IE */
		-moz-transform: scale(1.3);
		/* FF */
		-webkit-transform: scale(1.3);
		/* Safari and Chrome */
		-o-transform: scale(1.3);
		/* Opera */
		transform: scale(1.3);
		padding: 10px;
		cursor: pointer;
	}
</style>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">

			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-header">
						<b>List of Classes and Fees</b>
						<!-- <span class="float:right"> -->
						<a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_class">
							<i class="fa fa-plus"></i> New Entry
						</a>
						<!-- </span> -->
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Class/Level</th>
									<th class="">Description</th>
									<th class="">Total Fee</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$class = $conn->query("SELECT * FROM classes  order by class asc ");
								while ($row = $class->fetch_assoc()) :
								?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td>
											<p> <b><?php echo $row['class'] . " - " . $row['level'] ?></b></p>
										</td>
										<td class="">
											<p><small><i><b><?php echo $row['description'] ?></i></small></p>
										</td>
										<td class="text-right">
											<p> <b><?php echo number_format($row['total_amount'], 2) ?></b></p>
										</td>
										<td class="text-center">
										<!-- <button class="btn btn-sm btn-outline-primary view_class" type="button" data-id="<?php echo $row['id'] ?>">View</button> -->
											<button class="btn btn-sm btn-outline-primary edit_class" type="button" data-id="<?php echo $row['id'] ?>">Edit</button>
											<button class="btn btn-sm btn-outline-danger delete_class" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>

</div>
<style>
	td {
		vertical-align: middle !important;
	}

	td p {
		margin: unset
	}

	img {
		max-width: 100px;
		max-height: 150px;
	}
</style>
<script>
	$(document).ready(function() {
		$('table').dataTable()
	})
	$('#new_class').click(function() {
		uni_modal("New Class and Fees Entry", "manage_class.php", 'large')

	})

	// $('.view_class').click(function() {
	// 	location.href = "view_class.php";
	// })

	$('.edit_class').click(function() {
		uni_modal("Manage Class and Fees Entry", "manage_class.php?id=" + $(this).attr('data-id'), 'large')

	})
	$('.delete_class').click(function() {
		_conf("Are you sure to delete this class?", "delete_class", [$(this).attr('data-id')])
	})

	function delete_class($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_class',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)
				}
			}
		})
	}
</script>