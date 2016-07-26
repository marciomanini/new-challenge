<?php
	include_once("util/menu.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="description" content="List contacts">
	<meta name="author" content="Marcio Manini">

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.css">

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/bootstrap.js"></script>

    <script type="text/javascript">
    	function createTable(){
		    dt = $('#dataTable').DataTable({
		    "ajax": {
		      "url": "controller/conContact.php?action=getDT",
		      "dataSrc": "",
		      "type": "POST"
		    },
		    "columns": [
			{ "data": "name"},
			{ "data": "email"},
			{ "data": "address"},
			{ "data": "address_complement"},
			{ "data": "birthday"},
			{ "data": "phone1"},
			{ "data": "phone2"},
			{
				"class":          "details-control center-th tr-update",
				"orderable":      false,
				"data":           null,
				"defaultContent": "<input type='button' id='btn_update' class='btn-img-phone-add update' title='Update the contact'>"
          	},
          	{
				"class":          "details-control center-th tr-delete",
				"orderable":      false,
				"data":           null,
				"defaultContent": "<input type='button' id='btn_delete' class='btn-img-phone-add delete' title='Delete the contact'>"
          	}
		    ],
		    	"autoWidth": false,
				"order": [0, 'asc']
		    });

		    $('#dataTable tbody').on('click', 'tr td.details-control.tr-update', function(){
				var tr = $(this).closest('tr');
				var row = dt.row( tr );
				updateContact(row.data().id, row.data().email);
			});

			$('#dataTable tbody').on('click', 'tr td.details-control.tr-delete', function(){
		        var tr = $(this).closest('tr');
		        var row = dt.row( tr );
		        showDelModal(row.data().id);
			});
		  }

		function updateContact(id, email){
			$.ajax({
				type: "POST",
				url:'ModalUpdate.php',
				data: "id="+ id + "&email=" + email,
				complete:function(answer){
					$("#modalUpdateContact").html(answer.responseText);
              	}
            });
            $("#modalUpdateContact").modal('show');
		}

		function showDelModal(id){
			$("#modalDeleteContact").modal('show');
			$('#id-contact').val(id);
		}

		function cancel(){
			$("#modalDeleteContact").modal('hide');
			$('#id-contact').val('');
		}

		function delContact(){
			$.ajax({
				type: "POST",
				url: "controller/conContact.php?action=delContact",
				data: "id=" + $('#id-contact').val(),
				success: function(answer) {
					$("#modalDeleteContact").modal('hide');
					$('#lb_del_contact').html('Contact successfully excluded');

					$('#lb_del_contact').show(2200, function(){//Using a callback
							$('#lb_del_contact').hide(2000);
					});
					//Reloading the dataTable
					dt.ajax.reload();
				}
			});
		}

		$(document).ready(function() {
			var dt;
			createTable();
		});
    </script>
	
</head>
<body>

    <div class="modal fade" tabindex="-1" role="dialog" id="modalUpdateContact" aria-labelledby="modalUpdateContact" aria-hidden="true"></div>

	<div class="modal fade" role="dialog" id="modalDeleteContact" aria-labelledby="modalDeleteContact" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<input type="hidden" name="id-contact" id="id-contact">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Delete Parmanently</h4>
				</div>
				<div class="modal-body">
					<p ><h3>Are you sure about this?</h3></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" title="This button doesn't delete" data-dismiss="modal" onclick="javascript:cancel()">Cancel</button>
					<button type="button" class="btn btn-danger" title="This button does" onclick="javascript:delContact()">Delete</button>
				</div>
			</div>
		</div>
	</div>

	<div class="container theme-showcase">
		<div class="table-responsive">
	      <table id="dataTable" class="table table-hover table-bordered table-striped table-mc-cyan mytable" >
	        <thead>
	          <tr>
	            <th class="text-center">Name				</th>
	            <th class="text-center">E-mail				</th>
	            <th class="text-center">Address				</th>
	            <th class="text-center">Address Complement	</th>
	            <th class="text-center">Birthday			</th>
	            <th class="text-center">Phone 1				</th>
	            <th class="text-center">Phone 2				</th>
	            <th class="text-center">Update				</th>
	            <th class="text-center">Delete				</th>
	          </tr>
	        </thead>
	      </table>
	    </div>
	    <div class="form-group">
			<div class="col-md-12">
				<label class="label label-success" id="lb_del_contact"></label>
			</div>
		</div>
	</div>
</body>
</html>