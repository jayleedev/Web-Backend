<?php require_once '_leftmenu.php';?>

<main role="main" class="col-sm-9 ml-sm-auto col-md-9 pt-3">
<section class="row text-center placeholders">
	<div class="row-fluid api_section">
		<h2 class="api_title">
			<span style="color: #bababa;">POST&nbsp;</span>
			<span class="text-danger" style="font-size: 20px;">/addHistory?uid={User ID}&course_id={Course ID}&state={State}</span>
		</h2>
		<h4 class="api_subtitle text-secondary">Register history data</h4>
		
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
							<b>state</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td> State </td>
						<td>
							<input type="email" class="form-control" id="state" aria-describedby="emailHelp" placeholder="State">
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
			var state = $("#state").val();
	                
	                $.post( "<?php echo base_url();?>index.php/mobile/addHistory", {uid:uid, course_id:cid, state:state}, function(data) {
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