<?php require_once '_sidebar.php';?>

<div class="col-md-12"> <div class="card"> <div class="content table-responsive">

<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Mail</th>
			<th>Description</th>
			<th>Date</th>
			<th>Banner</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Mail</th>
			<th>Description</th>
			<th>Date</th>
			<th>Banner</th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>

<?php require_once '_footbar.php';?>

<script type="text/javascript">
	var editor;
	 
	$(document).ready(function() {
		editor = new $.fn.dataTable.Editor( {
			ajax: "<?php echo base_url();?>index.php/admin/setUser",
			table: "#example",
			fields: [ {
					label: "FirstName:",
					name: "first_name"
				}, {
					label: "LastName:",
					name: "last_name"
				}, {
					label: "Mail:",
					name: "mail"
				}, {
					label: "Password:",
					name: "password",
					type: "password"
				}, {
					label: "Description:",
					name: "description",
					type: 'textarea'
				}, {
					label: "Banner File:",
					name: "banner",
					type: "upload",
					display: function ( file_id ) {
						return '<img src="'+editor.file( 'files', file_id ).web_path+'"/>';
					},
					clearText: "Clear",
					noImageText: 'No file'
				}, {
					label: "Photo File:",
					name: "photo",
					type: "upload",
					display: function ( file_id ) {
						return '<img src="'+editor.file( 'files', file_id ).web_path+'"/>';
					},
					clearText: "Clear",
					noImageText: 'No file'
				}
			]
		} );
		
		editor.on( 'initCreate', function ( e, json, data ) {
		    editor.show('password');
		} );
		
		editor.on( 'initEdit', function ( e, json, data ) {
		    editor.hide('password');
		} );
		
		editor.on( 'preSubmit', function ( e, o, action ) {
		        if ( action !== 'remove' ) {  // create, edit, remove
		        
		            var first_name = this.field( 'first_name' );
		            if ( ! first_name.isMultiValue() ) {
		                if ( ! first_name.val() ) {
		                    first_name.error( 'A first name must be given' );
		                }
		            }
		            
		            var last_name = this.field( 'last_name' );
		            if ( ! last_name.isMultiValue() ) {
		                if ( ! last_name.val() ) {
		                    last_name.error( 'A last name must be given' );
		                }
		            }
		            
		            var mail = this.field( 'mail' );
		            if ( ! mail.isMultiValue() ) {
		                if ( ! mail.val() ) {
		                    mail.error( 'A mail must be given' );
		                } else {
			                if ( action === 'create') {
			                	
			                	$.post( "<?php echo base_url();?>index.php/admin/isExistMail", {mail:mail.val()}, function(data) {
			            			var result = JSON.parse(data);
			            			
			            			if (result['state']) {
			            				mail.error( result['msg'] );
			            			}
					    	});
			                }
		                }
		            }
		            
		            if ( action === 'create') {
		            	var password = this.field( 'password' );
		            	if ( ! password .isMultiValue() ) {
		                    if ( ! password.val() ) {
		                        password.error( 'A password must be given' );
		                    }
		            	}
		            }
		 
		            // If any error was reported, cancel the submission so it can be corrected
		            if ( this.inError() ) {
		                return false;
		            }
		        }
		} );
	 
		var table = $('#example').DataTable( {
			dom: "Bfrtip",
			ajax: "<?php echo base_url();?>index.php/admin/getUserList",
			columns: [
				{
			                data: "photo",
			                render: function ( file_id ) {
			                    return file_id ?
			                        '<img height="50" width="50" src="'+editor.file( 'files', file_id ).web_path+'"/>' :
			                        null;
			                },
			                defaultContent: "",
			                title: "#"
			        },
				{ data: "name" },
				{ data: "mail" },
				{ data: "description" },
				{ data: "date" },
				{
			                data: "banner",
			                render: function ( file_id ) {
			                    return file_id ?
			                        '<img height="50" width="50" src="'+editor.file( 'files', file_id ).web_path+'"/>' :
			                        null;
			                },
			                defaultContent: "",
			                title: "Banner"
			        }
			],
			columnDefs: [
			    { className: "dt-body-center", "targets": [ 0, 5 ] }
			],
			select: true,
			buttons: [
				{ extend: "create", editor: editor },
				{ extend: "edit",   editor: editor },
				{ extend: "remove", editor: editor }
			]
		} );
	} );
</script>
	
</html>
