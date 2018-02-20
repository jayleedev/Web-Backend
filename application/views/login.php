<!DOCTYPE html>
<html>
<head>
	<title>ADMIN PANEL</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/login.css">
	<link rel="icon" href="<?php echo base_url()?>assets/img/logo.png" type="image/x-icon">
</head>
<body>
<img src="<?php echo base_url()?>assets/img/login.jpg" style="margin-top:-10px;margin-left:-10px;width:100%;height:100%">

<div class="login">

    <h1>Login</h1>
    <form method="post" id="form_signin" action="<?php echo base_url().'index.php/admin/signIn'?>" method="post">
        <input type="text" name="mail" placeholder="Username" required="required" />
        <input type="password" name="password" placeholder="Password" required="required"/> 
	<button name="submit" type="submit" class="btn btn-primary btn-block btn-large">Login</button>
    </form>

</div>

<!-- jQuery  -->

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		
<!-- ajaxform js -->
<script type="text/javascript" src="<?php echo base_url()?>assets/plugins/form/jquery.form.js"></script>



<script type="text/javascript">
	jQuery.browser = {};
    (function () {
        jQuery.browser.msie = false;
        jQuery.browser.version = 0;
        if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
            jQuery.browser.msie = true;
            jQuery.browser.version = RegExp.$1;
        }
    })();
	$(document).ready(function() {
		$("#form_signin").ajaxForm({
			dataType: 'json',
			success: function(result) {
			   if (result.stat === 1) {
				   $(location).attr('href', result.url);
			   } else {
				   alert(result.msg);
				   /*swal({
					   title: "Error!",
					   text: result.msg,
					   type: "warning",
					   showCancelButton: false,
					   showConfirmButton: true
				   });*/
			   }
			}
		});
	});
</script>

</body>
</html>