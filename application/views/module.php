<?php require_once '_sidebar.php';?>

<div class="col-md-12"> <div class="card"> <div class="content table-responsive">
                            
<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Course Name</th>
			<th>Duration</th>
			<th>Date</th>
			<th>Audio</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Course Name</th>
			<th>Duration</th>
			<th>Date</th>
			<th>Audio</th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>

<?php require_once '_footbar.php';?>

<script type="text/javascript">
	var editor;
	 
	$(document).ready(function() {
		editor = new $.fn.dataTable.Editor( {
			ajax: "<?php echo base_url();?>index.php/admin/setModule",
			table: "#example",
			fields: [ {
					label: "Name:",
					name: "name"
				}, {
					label: "Description:",
					name: "description",
					type: 'textarea'
				}, {
					label: "Course",
					name: "course_id",
					type: "select"
				}, {
					label: "Duration (seconds):",
					name: "duration"
				}, {
					label: "Audio File:",
					name: "audio",
					type: "upload",
					display: function ( file_id ) {
						return editor.file( 'files', file_id ).web_path;
					},
					clearText: "Clear",
					noImageText: 'No file'
				}
			]
		} );
		
		editor.dependent( 'course_id', function (val, data, callback) {
		    $.ajax({
		        type: 'POST',
		        url: "<?php echo base_url();?>index.php/admin/getCourseItems",
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
		 
		            var duration = this.field( 'duration' );
		            if ( ! duration.isMultiValue() ) {
		                if ( ! duration.val() ) {
		                    duration.error( 'A duration must be given' );
		                }
		                
		                if (!$.isNumeric(duration.val())) {
		                	duration.error( 'A duration must be number' );
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
			ajax: "<?php echo base_url();?>index.php/admin/getModuleList",
			columns: [
				{ data: "name" },
				{ data: "description" },
				{ data: "course_name" },
				{ data: "duration" },
				{ data: "date" },
				{
			                data: "audio",
			                render: function ( file_id ) {
			                    return file_id ?
			                        '<img src="<?php echo base_url();?>assets/img/audio.png"/>' :
			                        null;
			                },
			                defaultContent: "",
			                title: "Audio"
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
