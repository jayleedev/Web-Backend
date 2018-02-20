<?php require_once '_sidebar.php';?>

<div class="col-md-12"> <div class="card"> <div class="content table-responsive">

<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Name</th>
			<th>Date</th>
			<th>Icon</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Name</th>
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
			ajax: "<?php echo base_url();?>index.php/admin/setGoal",
			table: "#example",
			fields: [ {
					label: "Name:",
					name: "name"
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
			ajax: "<?php echo base_url();?>index.php/admin/getGoalList",
			columns: [
				{ data: "name" },
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
			columnDefs: [
			    { className: "dt-body-center", "targets": [ 2 ] }
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
