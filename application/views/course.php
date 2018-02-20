<?php require_once '_sidebar.php';?>

<div class="col-md-12"> <div class="card"> <div class="content table-responsive">

<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Goal Name</th>
			<th>Date</th>
			<th>Icon</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Goal Name</th>
			<th>Date</th>
			<th>Icon</th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>

<?php require_once '_footbar.php';?>

<script type="text/javascript">
	var editor;
	 
	$(document).ready(function() {
		editor = new $.fn.dataTable.Editor( {
			ajax: "<?php echo base_url();?>index.php/admin/setCourse",
			table: "#example",
			fields: [ {
					label: "Name:",
					name: "name"
				}, {
					label: "Description:",
					name: "description",
					type: 'textarea'
				}, {
					label: "Goal",
					name: "goal_id",
					type: "select"
				}, {
					label: "Icon File:",
					name: "icon",
					type: "upload",
					display: function ( file_id ) {
						return '<img src="'+editor.file( 'files', file_id ).web_path+'"/>';
					},
					clearText: "Clear",
					noImageText: 'No file'
				}
			]
		} );
		
		editor.dependent( 'goal_id', function (val, data, callback) {
		    $.ajax({
		        type: 'POST',
		        url: "<?php echo base_url();?>index.php/admin/getGoalItems",
		        dataType: 'json',
		        success: function (json) {
		            callback(json);
		        }
		    });
		});
		
		editor.on( 'preSubmit', function ( e, o, action ) {
		        if ( action !== 'remove' ) {
		        
		            var name = this.field( 'name' );
		            if ( ! name.isMultiValue() ) {
		                if ( ! name.val() ) {
		                    name.error( 'A name must be given' );
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
			ajax: "<?php echo base_url();?>index.php/admin/getCourseList",
			columns: [
				{ data: "name" },
				{ data: "description" },
				{ data: "goal_name" },
				{ data: "date" },
				{
			                data: "icon",
			                render: function ( file_id ) {
			                    return file_id ?
			                        '<img height="22" width="22" src="'+editor.file( 'files', file_id ).web_path+'"/>' :
			                        null;
			                },
			                defaultContent: "",
			                title: "Icon"
			        }
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
