<?php require_once '_sidebar.php';?>

<style type="text/css">
      .modal .modal-dialog {
        width: 500px;
      }
      
      
</style>
    
<div class="col-md-8">
	<div class="card">
	    <div class="header">
	        <h4 class="title">Edit Admin Profile</h4>
	    </div>
	    <div class="content">
	         
	            <div class="row">
	                <div class="col-md-6">
	                    <div class="form-group">
	                        <label>First Name</label>
	                        <input type="text" id="first_name" class="form-control" placeholder="First Name" value="<?php echo $info['first_name']?>">
	                    </div>
	                </div>
	                <div class="col-md-6">
	                    <div class="form-group">
	                        <label>Last Name</label>
	                        <input type="text" id="last_name" class="form-control" placeholder="Last Name" value="<?php echo $info['last_name']?>">
	                    </div>
	                </div>
	            </div>
	
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group">
	                        <label>E-Mail</label>
	                        <input type="text" id="mail" class="form-control" placeholder="Email" value="<?php echo $info['mail']?>">
	                    </div>
	                </div>
	            </div>
	
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="form-group">
	                        <label>About Me</label>
	                        <textarea rows="5" class="form-control" id="description" placeholder="Here can be your description"><?php echo $info['description']?></textarea>
	                    </div>
	                </div>
	            </div>
	
	            <button href="#" id="updateBtn" class="btn btn-info btn-fill pull-right">Update Profile</button>
	            <button href="#" id="changeBtn" class="btn btn-danger btn-fill pull-right" style="margin-right:10px;">Change Password</button>
	            <div class="clearfix"></div>
	        
	    </div>
	</div>
</div>

<div class="col-md-4">
        <div class="card card-user">
            <div class="image">
                <img src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400" alt="..."/>
            </div>
            <div class="content">
                <div class="author">
                     <a href="#">
                    <img class="avatar border-gray" src="<?php echo $info['photo']?>" alt="..."/>

                      <h4 class="title">
                      	 <?php echo $info['name']?><br />
                         <small><?php echo $info['mail']?></small>
                      </h4>
                    </a>
                </div>
                <p class="description text-center">"<?php echo $info['description']?>"</p>
            </div>
            <hr>
            <div class="text-center" style="padding-bottom:10px;">
                <!-- <button href="#" id="photoBtn" class="btn btn-success btn-fill">Change Photo</button> -->
            </div>
        </div>
</div>

<div id="modal" class="modal">
	<div class="modal-dialog animated">
	    <div class="modal-content">
	        <form class="form-horizontal" method="post" id="changeForm" action="<?php echo base_url();?>index.php/admin/setPassword">
	            <div class="modal-header">
	                <strong>Change Password</strong>
	            </div>
	
	            <div class="modal-body">
	                <div class="form-group has-label">
	                    <label for="dummyText" class="control-label col-xs-4">Old Password</label>
	                    <div class="col-xs-7">
	                        <input type="password" name="old_password" id="old_password" class="form-control" required="true" />
	                    </div>
	                </div>
	                <div class="form-group has-label">    	
	                    <label for="dummyText" class="control-label col-xs-4">New Password</label>
	                    <div class="col-xs-7">
	                        <input type="password" name="new_password" id="new_password" class="form-control" required="true" />
	                    </div>
	                </div>    
	                <div class="form-group has-label">
	                    <label for="dummyText" class="control-label col-xs-4">Confirm Password</label>
	                    <div class="col-xs-7">
	                        <input type="password" name="re_password" id="re_password" class="form-control" required="true" equalTo="#new_password" />
	                    </div>
	                </div>
	                
	            </div>
	
	            <div class="modal-footer">
	                <button class="btn btn-default" type="button" onclick="modal.close();">Cancel</button>
	                <button class="btn btn-primary" type="submit" onclick="">Update</button>
	            </div>
	        </form>
	    </div>
      </div>
</div>

<?php require_once '_footbar.php';?>

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
		var msg = "<?php echo $msg; ?>";
		if (msg != "") alert(msg);
		
		$("#updateBtn").click(function() {
			$.post( "<?php echo base_url();?>index.php/admin/setAdminInfo", 
			
			       {
			        first_name:$("#first_name").val(), 
			        last_name:$("#last_name").val(), 
			        mail:$("#mail").val(), 
			        description:$("#description").val()
			       }, 
			        
			       function(data) {
				    	
				    	$.notify({
				        	icon: "pe-7s-gift",
				        	message: "<b>Update admin information</b><br>The admin information updated."
				        },{
				            type: 'success',
				            timer: 4000,
				            placement: {
				                from: 'top',
				                align: 'center'
				            }
				        });
				}
		        );
	        });
	        
	        $("#changeBtn").click(function() {
	        	modal.open();
	        });
	        
	        var modal = new RModal(document.getElementById('modal'), {
	                
	                beforeOpen: function(next) {
	                    console.log('beforeOpen');
	                    next();
	                }
	                
	                , afterOpen: function() {
	                    console.log('opened');
	                }
	
	                , beforeClose: function(next) {
	                    console.log('beforeClose');
	                    next();
	                }
	                
	                , afterClose: function() {
	                    console.log('closed');
	                }
	                
	        });
	        
	        window.modal = modal;
	        
	        $("#changeForm").validate({
	            highlight: function(element) {
	                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
	                $(element).closest('.form-check').removeClass('has-success').addClass('has-error');
	            },
	            success: function(element) {
	                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
	                $(element).closest('.form-check').removeClass('has-error').addClass('has-success');
	            },
	            errorPlacement: function(error, element) {
	                $(element).closest('.form-group').append(error).addClass('has-error');
	            },
	        });
	        
	        $("#changeForm").ajaxForm({
			dataType: 'json',
			success: function(result) {
			   if (result.stat === 1) {
				   $(location).attr('href', result.url);
			   } else {
				   alert(result.msg);
			   }
			}
		});
	} );
	
</script>
	
</html>