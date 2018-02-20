<?php require_once '_leftmenu.php';?>

<main role="main" class="col-sm-9 ml-sm-auto col-md-9 pt-3">
<section class="row text-center placeholders">
	<div class="row-fluid api_section">
		<h2 class="api_title">
			<span style="color: #bababa;">POST&nbsp;</span>
			<span class="text-danger" style="font-size: 20px;">/getModuleDetail?user_id={User ID}&module_id={Module ID}</span>
		</h2>
		<h4 class="api_subtitle text-secondary">Get Module Detail</h4>
		<p class="api_description">Get Module Detail</p>
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
							<b>user_id</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td>
							User ID
						</td>
						<td>
							<input type="email" class="form-control" id="user_id" aria-describedby="emailHelp" placeholder="Enter User ID">
						</td>
					</tr>
					
					<tr class="">
						<td>
							<b>module_id</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td>
							Module ID
						</td>
						<td>
							<input type="email" class="form-control" id="module_id" aria-describedby="emailHelp" placeholder="Enter Module ID">
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
			var uid = $("#user_id").val();
			var mid = $("#module_id").val();
	                
	                $.post( "<?php echo base_url();?>index.php/mobile/getModuleDetail", {user_id:uid, module_id:mid}, function(data) {
            			var result = JSON.parse(data);
            			var output = JSON.stringify(result);
            			
            			output = output.replace('{','{<br>');
            			output = output.replace(',',',<br>');
            			output = output.replace('",','",<br>');
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