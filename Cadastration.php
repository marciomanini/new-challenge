<?php
	include_once("util/menu.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="description" content="Add contact">
	<meta name="author" content="Marcio Manini">
	
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.maskedinput.js"></script>

	<script type="text/javascript">
		//Add one or two more phone nunbers
		function control_phone_number(param){
			if(param === 'add'){
				//If the second phone number is hidden and the first phone number is filled, it shows
				if($('#div_second_pn').is(":hidden") && $('#phone1').val()){
					$('#div_second_pn').removeClass('hidden');
					return;
				}
				//If the second phone number is visible, it shows a message
				if($('#div_second_pn').is(":visible"))
					alert("You can insert only two phone numbers");
			}
			if(param === 'delete'){
				//If the second phone number is visible, it hides
				if($('#div_second_pn').is(":visible"))
					$('#div_second_pn').addClass('hidden');
			}
		}

		//Clear all inputs in a form
		function clearAll(){
			$('#form-contact :input').val('');
			$('#div_second_pn').addClass('hidden');
		}

		//Add a new contact
		function addContact(){
			//If the required fields are filled
			if(!$.trim($('#name').val()) || !$.trim($('#email').val()) || !$.trim($('#address').val())){
				alert('The fields with * are required');
				return
			}

			//It avoids that the user hide a number and still saving it
			if($('#div_second_pn').is(":hidden"))
				$('#phone2').val('');

			var dataArray = $('#form-contact').serialize();
			$.ajax({
				type: "POST",
				url: "controller/conContact.php?action=addContact",
				data: dataArray,
				success: function(answer) {
					//The answer can't be 1 because that indicates that's ok
					if(answer !== "" && answer !== "1"){
						alert(answer);
						return;
					}
					clearAll();
					$('#lb_add_contact').html('Contact successfully added');
					$('#lb_add_contact').show(2200, function(){//Using a callback
							$('#lb_add_contact').hide(2000);
					});
				}
			});
		}

		$(document).ready(function() {
			$("#birthday").mask("99/99/9999", {placeholder:" "});
			$("#phone1").mask("(99)99999-9999", {placeholder:" "});
			$("#phone2").mask("(99)99999-9999", {placeholder:" "});
			$('#lb_add_contact').hide();
    	});
	</script>
</head>
<body>
	<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Add Contact</div>
			</div>
			<div class="panel-body" >
				<div class="form-group">
					<div class="col-md-12">
						<label class="label label-info">* Required Fields</label>
					</div>
				</div>
				<form id="form-contact" class="form-horizontal" role="form">
					<div class="form-group">
						<label for="name" class="col-md-3 control-label">*Name</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="name" name="name" placeholder="Insert the name" maxlength="100">
						</div>
					</div>                                  
					<div class="form-group">
						<label for="email" class="col-md-3 control-label">*E-mail</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="email" name="email" placeholder="Insert the e-mail" maxlength="100">
						</div>
					</div>
					<div class="form-group">
						<label for="address" class="col-md-3 control-label">*Address</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="address" name="address" placeholder="Insert the address" maxlength="100">
						</div>
					</div>
					<div class="form-group">
						<label for="address_complement" class="col-md-3 control-label">Address Complement</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="address_complement" placeholder="Insert the address complement" maxlength="100">
						</div>
					</div>
					<div class="form-group">
						<label for="birthday" class="col-md-3 control-label">Birthday</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="birthday" name="birthday" placeholder="Insert the birthday dd/mm/yyyy">
						</div>
					</div>
					<div class="form-group">
						<label for="phone1" class="col-md-3 control-label">Phone number</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="phone1" name="phone1" placeholder="Insert the phone number">
							<input type="button" class="btn-img-phone-add" title="Add another phone number (the first number must be filled)" onclick="javascript:control_phone_number('add')">
							<input type="button" class="btn-img-phone-delete" title="Remove a phone number" onclick="javascript:control_phone_number('delete')">
						</div>
					</div>
					<div class="form-group hidden" id="div_second_pn">
						<label for="phone2" class="col-md-3 control-label">Second phone number</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="phone2" name="phone2" placeholder="Insert the second phone number">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-3 col-md-9">
							<button type="button" class="btn btn-danger" title="Cancel the operation" onclick="javascript:clearAll()">Cancel</button>
							<button type="button" class="btn btn-info" title="Add the contact" onclick="javascript:addContact()">Add Contact</button>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<label class="label label-success" id="lb_add_contact"></label>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>