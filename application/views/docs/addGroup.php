<?php require_once '_leftmenu.php';?>

<main role="main" class="col-sm-9 ml-sm-auto col-md-9 pt-3">
<section class="row text-center placeholders">
	<div class="row-fluid api_section">
		<h2 class="api_title">
			<span style="color: #bababa;">POST&nbsp;</span>
			<span class="text-danger" style="font-size: 20px;">/addGroup?uid={User ID}&course_id={Course ID}&name={Group Name}&description={Group Description}&isPrivate={Private Value}&start_date={Start Date}&friends={Group Friends}</span>
		</h2>
		<h4 class="api_subtitle text-secondary">Register Group data</h4>
		
		<div class="table-contz">
			<table>
				<thead>
					<tr>
						<td>Parameter</td>
						<td>Description</td>
						<td>Test Console</td>
					</tr>
				</thead>
				<tbody>
					
					<tr class="">
						<td>
							<b>uid</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td> User ID </td>
						<td>
							<input type="email" class="form-control" id="uid" aria-describedby="emailHelp" placeholder="User ID">
						</td>
					</tr>
					
					<tr class="">
						<td>
							<b>course_id</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td> Course ID </td>
						<td>
							<input type="email" class="form-control" id="course_id" aria-describedby="emailHelp" placeholder="Course ID">
						</td>
					</tr>
					
					<tr class="">
						<td>
							<b>name</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td> Group Name </td>
						<td>
							<input type="email" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Group Name">
						</td>
					</tr>
					
					<tr class="">
						<td>
							<b>description</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td> Group Description </td>
						<td>
							<input type="email" class="form-control" id="description" aria-describedby="emailHelp" placeholder="Group Description">
						</td>
					</tr>
					
					<tr class="">
						<td>
							<b>isPrivate</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td> 0:Private, 1:public </td>
						<td>
							<input type="email" class="form-control" id="isPrivate" aria-describedby="emailHelp" placeholder="Group Private Value">
						</td>
					</tr>
					
					<tr class="">
						<td>
							<b>start_date</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td> Group Start Date </td>
						<td>
							<input type="email" class="form-control" id="start_date" aria-describedby="emailHelp" placeholder="Group Start Date">
						</td>
					</tr>
					
					<tr class="">
						<td>
							<b>friends</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td> Group Friends </td>
						<td>
							<input type="email" class="form-control" id="friends" aria-describedby="emailHelp" placeholder="Group Friends">
						</td>
					</tr>

				</tbody>
				<tfoot>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td> 
							<button type="button" class="btn btn-primary" id="try">Try it out</button>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="result result_fail" style="display: block;">
			<span class="close-response">
				<div class="close-window" title="Close Window"> </div>
			</span>
			<h5>Result (JSON)</h5>
			<div class="response-block response-body" id="result">{}</div>
			
		</div>
		
	</div>
</section>
</main>
				
</div></div></body>

<script type="text/javascript">
	
	$(document).ready(function() {
			
		$('#try').on('click', function(event) {
			var uid = $("#uid").val();
			var cid  = $("#course_id").val();
			var name = $("#name").val();
			var description = $("#description").val();
			var isPrivate = $("#isPrivate").val();
			var start_date = $("#start_date").val();
			var friends = $("#friends").val();
	                
	                $.post( "<?php echo base_url();?>index.php/mobile/addGroup", {uid:uid, course_id:cid, name:name, description:description, isPrivate:isPrivate, start_date:start_date, friends:friends}, function(data) {
            			var result = JSON.parse(data);
            			var output = JSON.stringify(result);
            			
            			output = output.replace('{','{<br>');
            			output = output.replace(',','<br>');
            			output = output.replace('",','"<br>');
            			output = output.replace('],',']<br>');
            			output = output.replace('}','<br>}');
            			
            			$("#result").html(output);
		    	}).fail(function() {
	    		    alert( "Can not connect the server. Try again, please." );
	    		});
	        });
	
	});
	
</script>

</html>