$(document).ready(function() {
	var loggedIn;
	alert(loggedIn);
	$("#frmLogin").validate();
	if(loggedIn) {
		$("#login").hide();
	}
	
	$('#frmLogin').submit(function() {
		 var data = 'uname=' + $("#uname").val() + '&pass='+ $('#password').val();
		 var $page = $('#login');
	        $.ajax({
	            type: "POST",
	            dataType: "json",
	            url: "ajax.php",
	            data: data,
	            success: function(data, returnStatus, returnObject) {
	            	if(data == false) {
	            		alert('något blev fel');
	            		loggedIn = false;
	            	}else if(data == true) {
	            		loggedIn = true;
	            		$('#login').hide();
	            		$("#loginok").show();
	            	}
	            },
	            error: function(){
	            	alert('något gick fel');
	            }
	        });
	});

	$("#addform").validate({
		rules: {
			date: {
				required: true,
				date: true
		    }
		}
	});
});


