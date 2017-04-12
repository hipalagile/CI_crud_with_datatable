<html>
<head>
	<title>CodeIgniter ajax post</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
</head>
<body>
	<div class="main">
	<div id="content">
	<h2 id="form_head">Codelgniter Ajax Post</h2><br/>
	<hr>
	<div id="form_input">
		<?php

		// Form Open
		echo form_open();
		$data_name = array(
		'type' => 'hidden',
		'name' => 'id',
		//'class' => 'input_box',
		//'placeholder' => 'Please Enter Name',
		'id' => 'id'
		);

		echo form_input($data_name);
		echo "<br>";
		echo "<br>";

		// Name Field
		echo form_label('First Name');

		$data_name = array(
		'type' => 'text',
		'name' => 'firstname',
		'class' => 'input_box',
		'placeholder' => 'Please Enter Name',
		'id' => 'firstname'
		);

		echo form_input($data_name);
		echo "<br>";
		echo "<br>";

		//lastname Field
		echo form_label('Last Name');
		$data_name = array(
			'type' => 'text',
			'name' => 'lastname',
			'class' => 'input_box',
			'placeholder' => 'Please Enter LastName',
			'id' => 'lastname'
		);
		echo form_input($data_name);	
		echo "<br>";
		echo "<br>";	
		//email Field
		echo form_label('Email');
		

		$data_name = array(
			'type' => 'email',
			'name' => 'email',
			'class' => 'input_box',
			'placeholder' => 'Please Enter Email',
			'id' => 'email'
		);
		echo form_input($data_name);
		?>
	</div>
	<div id="form_button">
		<?php echo form_submit('submit', 'Submit', "class='submit'"); ?>
	</div>
	<?php
		// Form Close
		echo form_close(); 
	?>
	</div>
	</div>
	<div id="ajax-content-container">
	<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
            	<th>Id</th>   
                <th>FirstName</th>
                <th>LastName</th>
                <th>Email</th>
                <th>Action</th>                                                                                                       
            </tr>
        </thead>
        <!-- <tbody>
        </tbody>  -->       
    </table>
    </div>
	<script type="text/javascript">

	// Ajax post
	$(document).ready(function() {
		
		var path = "<?php echo base_url(); ?>" + "Test/listing_data";

		//load table 
		var table = $("#example").DataTable({
			    "ajax": {
            		"url": path,
            		"type": "POST"
       			},
			    "processing": true,
        		"serverSide": true,
        		"columns": [
			        { "bVisible" : false }, // assume this is the id of the row, so don't show it
			        null,
			        null,
			        null,
			        {
			            mRender: function (data, type, row) {
			                return '<a class="table-edit" href="#" id="' + row[0] + '">EDIT</a>' + ' <a class="table-delete" href="#" id="' + row[0] + '">DELETE</a>';
			            }
			        }        
			    ]        		 		      		    
		});			

		//to submit button 
		$(".submit").click(function(event) {
			event.preventDefault();
			var firstname = $("input#firstname").val();
			var lastname = $("input#lastname").val();		
			var email = $("input#email").val();
			var id = $("input#id").val();		
			jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "Test/user_data_submit",
				dataType: 'html',
				//dataType: 'json',
				data: { firstname: firstname, lastname: lastname,email:email,id:id },
				success: function(res) {
					//console.log(res);
					if (res.message) {
						alert(res.message);
					} else {					   	 	   
					   table.ajax.reload();
        			}
				}
			});
		});
		$('#example').on('click', '.table-edit', function(event) {
			var id = $(this).attr('id');
			event.preventDefault();
			jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "Test/update_row_data",
				data: { id: id },
				dataType: 'json',
				success: function(res) {
					$("input#firstname").val(res.firstname);
					$("input#lastname").val(res.lastname);		
					$("input#email").val(res.email);	
					$("input#id").val(res.id);
				}			
			});			
		});

		$('#example').on('click', '.table-delete', function(event) {
			var id = $(this).attr('id');
			event.preventDefault();
			jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "Test/delete_row_data",
				data: { id: id },
				//dataType: 'html',
			//	dataType: 'json',
				success: function(res) {
					table.ajax.reload();
				}			
			});
			
		});						
	});
	</script>
</body>
</html>

