<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<script type="text/javascript">
	var id;
	var email;

	function buildScreen(){
		$.ajax({
	        type:'POST',
	        url: "controller/conContact.php?action=listContact",
	        data: "id=" + id,
	        success: function(answer){
	          var values = JSON.parse(answer);

	          $('#name').val(values['name']);
	          $('#email').val(values['email']);
	          $('#address').val(values['address']);
	          $('#address_complement').val(values['address_complement']);
	          $('#birthday').val(values['birthday']);
	          $('#phone1').val(values['phone1']);

	          if(values['phone2']){
	          	$('#phone2').val(values['phone2']);
	          	$('#div_second_pn').removeClass('hidden');
	          }
    		}
 		});
	}
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
	function cancel(){
		$("#modalUpdateContact").modal('hide');
	}

	//Add a new contact
	function updContact(){
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
			url: "controller/conContact.php?action=updContact",
			data: dataArray,
			success: function(answer) {
				//The answer can't be 1 because that indicates that's ok
				if(answer !== "" && answer !== "1"){
					alert(answer);
					return;
				}
				$('#lb_message').html('Contact successfully updated');

				$('#lb_message').show(800, function(){//Using a callback
					$('#lb_message').hide(500, function(){//Using a callback
						cancel();
						//Reloading the dataTable of the List
						dt.ajax.reload();
					});
				});
			}
		});
	}

	$(document).ready(function() {
		$("#birthday").mask("99/99/9999", {placeholder:" "});
		$("#phone1").mask("(99)99999-9999", {placeholder:" "});
		$("#phone2").mask("(99)99999-9999", {placeholder:" "});
		$('#lb_message').hide();

		//Receiving the value sent by the POST
		id = "<?php echo $_POST['id']?>";
		email = "<?php echo $_POST['email']?>";
		$('#id-contact').val(id);
		$('#old-email').val(email);
		buildScreen();
	});
</script>
</head>
<body>
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="panel-heading">
				<div class="panel-title">Update Contact</div>
			</div>
			<div class="panel-body" >
				<div class="form-group">
					<div class="col-md-12">
						<label class="label label-info">* Required Fields</label>
					</div>
				</div>
				<form id="form-contact" class="form-horizontal" role="form">
					<input type="hidden" name="id-contact" id="id-contact">
					<input type="hidden" name="old-email" id="old-email">
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
							<input type="text" class="form-control" id="address_complement" name="address_complement" placeholder="Insert the address complement" maxlength="100">
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
					<div class="modal-footer">
						<div class="form-group">
							<div class="col-md-offset-3 col-md-9">
								<button id="btn_add_contact" type="button" class="btn btn-danger" title="Cancel the operation" onclick="javascript:cancel()">Cancel</button>
								<button id="btn_add_contact" type="button" class="btn btn-info" title="Update the contact" onclick="javascript:updContact()">Update Contact</button>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<label class="label label-warning" id="lb_message"></label>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>