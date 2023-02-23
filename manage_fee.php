<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM studentfees where id = {$_GET['id']} ");
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form id="manage-fees">
		<div id="msg"></div>
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		 <div class="form-group">
            <label for="" class="control-label">Enrollment No./ E.F. No.</label>
            <input type="text" class="form-control" name="ef_no"  value="<?php echo isset($ef_no) ? $ef_no :'' ?>" required>
        </div>
		<div class="form-group">
			<label for="" class="control-label">Student</label>
			<select name="student_id" id="student_id" class="custom-select input-sm select2">
				<option value=""></option>
				<?php
					$student = $conn->query("SELECT * FROM student order by name asc ");
					while($row= $student->fetch_assoc()):
				?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($student_id) && $student_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']).' | '. $row['reg_no'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Class</label>
			<select name="class_id" id="class_id" class="custom-select input-sm select2">
				<option value=""></option>
				<?php
					$student = $conn->query("SELECT *,concat(class,'-',level) as class FROM classes order by class asc ");
					while($row= $student->fetch_assoc()):
				?>
				<option value="<?php echo $row['id'] ?>" data-amount = "<?php echo $row['total_amount'] ?>" <?php echo isset($class_id) && $class_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['class'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		 <div class="form-group">
            <label for="" class="control-label">Fee</label>
            <input type="text" class="form-control text-right" name="total_fee"  value="<?php echo isset($total_fee) ? number_format($total_fee) :'' ?>" required readonly>
        </div>
	</form>
</div>
<script>
	$('.select2').select2({
		placeholder:'Please select here',
		width:'100%'
	})
	$('#class_id').change(function(){
		var amount= $('#class_id option[value="'+$(this).val()+'"]').attr('data-amount')
		$('[name="total_fee"]').val(parseFloat(amount).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
	})
	$('#manage-fees').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_fees',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
				end_load()
			},
			success:function(resp){
				if(resp == 1){
					alert_toast("Data successfully saved.",'success')
						setTimeout(function(){
							location.reload()
						},1000)
				}else if(resp == 2){
					$('#msg').html('<div class="alert alert-danger">EF Nunmber already exist.</div>')
					end_load()
				}
			}
		})
	})
</script>
