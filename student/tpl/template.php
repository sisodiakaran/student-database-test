<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Manager (MVC/OOP)</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
    </head>
    <body style="margin-top: 70px;">
	<div class="col-md-12">
	    <div class="row">
		<div class="col-md-8 col-md-push-2">
		    <button class="btn btn-default pull-right" data-toggle="modal" data-target="#new_student_form">
			<i class="glyphicon glyphicon-plus"></i> New Student
		    </button>
		    <table class="table table-striped">
			<thead>
			    <tr>
				<th>Picture</th>
				<th>Student Name</th>
				<th>class</th>
				<th>Phone</th>
				<th>Address</th>
				<th></th>
			    </tr>
			</thead>
			<tbody id="list_student">
			    <?php
			    foreach ($data as $student) {
				?>
    			    <tr>
    				<td>
    				    <img alt="<?php echo $student['full_name']; ?>" src="<?php echo $student['picture']; ?>" class="img img-circle" width="32" />
    				</td>
    				<td>
    				    <?php echo $student['full_name']; ?>
    				</td>
    				<td><?php echo $student['class']; ?></td>
    				<td><?php echo $student['phone']; ?></td>
    				<td><?php echo $student['address']; ?></td>
    				<td>
    				    <a href="?page=student&action=delete" data-delete="<?php echo $student['id']; ?>" class="btn btn-danger delete">
    					<i class="glyphicon glyphicon-trash"></i> Delete
    				    </a>
    				</td>
    			    </tr>
			    <?php } ?>
			</tbody>
		    </table>
		</div>
	    </div>
	</div>

	<div id="new_student_form" class="modal fade">
	    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">New Student Form</h4>
		    </div>
		    <div class="modal-body">
			<form id="new_student_form_data">
			    <div class="form-group">
				<label for="FullName">Full Name</label>
				<input type="text" name="full_name" class="form-control" id="FullName" />
			    </div>
			    <div class="form-group">
				<label for="Class">Class</label>
				<select name="class" id="Class" class="form-control">
				    <option value="first">First</option>
				    <option value="second">Second</option>
				    <option value="third">Third</option>
				    <option value="fourth">Fourth</option>
				</select>
			    </div>
			    <div class="form-group">
				<label for="Address">Address</label>
				<textarea name="address" id="Address" class="form-control" rows="3"></textarea>
			    </div>
			    <div class="form-group">
				<label for="Phone">Phone</label>
				<input class="form-control" type="text" name="phone" id="Address" />
			    </div>
			    <div class="form-group">
				<label for="PictureUrl">Picture URL</label>
				<input class="form-control" type="text" name="picture" id="PictureUrl" />
			    </div>
			</form>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button id="save_student" type="button" class="btn btn-primary">Save Student</button>
		    </div>
		</div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

	<script type="text/javascript">
	    $(document).ready(function() {
		$('#new_student_form').modal({
		    backdrop: "static",
		    show: false
		}).on('hidden.bs.modal', function (e) {
		    $("#new_student_form_data").trigger("reset");
		});
		
		$("table").delegate(".delete", "click", function(e){
		   e.preventDefault();
		   var me = $(this);
		   var id = me.data('delete');
		   var url = me.attr('href');
		   
		   $.post(url, {id:id}, function(resp) {
			if(resp.status === 'success'){
			    me.parent().parent().remove();
			} else {
			    alert("Unable to delete this student");
			}
		    });
		});
		
		$("#save_student").on("click", function(e) {
		    e.preventDefault();
		    var data = $("#new_student_form_data").serialize();

		    $.post("?page=student&action=save", data, function(resp) {
			if(resp.status === 'success'){
			    var image_url = $("#new_student_form_data").find('input[name=picture]').val();
			    var full_name = $("#new_student_form_data").find('input[name=full_name]').val();
			    var phone = $("#new_student_form_data").find('input[name=phone]').val();
			    var address = $("#new_student_form_data").find('textarea[name=address]').val();
			    var s_class = $("#new_student_form_data").find('select[name=class]').val();
			    var id = resp.data;
			    var template = '<tr>'
				+ '<td>'
				    + '<img alt="'+full_name+'" src="'+image_url+'" class="img img-circle" width="32" />'
				+ '</td>'
				+ '<td>'
				    + full_name
				+ '</td>'
				+ '<td>'
				    + s_class
				+ '</td>'
				+ '<td>'
				    + phone
				+ '</td>'
				+ '<td>'
				    + address
				+ '</td>'
				+ '<td>'
				    + '<a href="?page=student&action=delete" data-delete="'+id+'" class="btn btn-danger delete">'
					+'<i class="glyphicon glyphicon-trash"></i> Delete'
				    +'</a>'
				+ '</td>'
			    + '</tr>';
			    $('#list_student').append(template);
			    $('#new_student_form').modal('hide');
			    $("#new_student_form_data").trigger("reset");
			}
		    });
		});
	    });
	</script>
    </body>
</html>