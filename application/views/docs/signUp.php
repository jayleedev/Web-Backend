<?php require_once '_leftmenu.php';?>

<main role="main" class="col-sm-9 ml-sm-auto col-md-9 pt-3">
<section class="row text-center placeholders">
	<div class="row-fluid api_section">
		<h2 class="api_title">
			<span style="color: #bababa;">POST&nbsp;</span>
			<span class="text-danger" style="font-size: 20px;">/signUp?mail={Email}&pwd={Password}&first_name={First Name}&last_name={Last Name}</span>
		</h2>
		<h4 class="api_subtitle text-secondary">Register with username, password and email</h4>
		
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
							<b>First Name</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td>
							User First Name
						</td>
						<td>
							<input type="email" class="form-control" id="first_name" aria-describedby="emailHelp" placeholder="First Name">
						</td>
					</tr>
					
					<tr class="">
						<td>
							<b>Last Name</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td>
							User Last Name
						</td>
						<td>
							<input type="email" class="form-control" id="last_name" aria-describedby="emailHelp" placeholder="Last Name">
						</td>
					</tr>
					
					<tr class="">
						<td>
							<b>mail</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td>
							User Mail
						</td>
						<td>
							<input type="email" class="form-control" id="mail" aria-describedby="emailHelp" placeholder="Enter email">
						</td>
					</tr>
					
					<tr class="">
						<td>
							<b>pwd</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td>
							User Password
						</td>
						<td>
							<input type="text" class="form-control" id="pwd" aria-describedby="emailHelp" placeholder="Enter password">
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
			var mail = $("#mail").val();
			var pwd  = $("#pwd").val();
			var fName = $("#first_name").val();
			var lName  = $("#last_name").val();
	                
	                $.post( "<?php echo base_url();?>index.php/mobile/signUp", {mail:mail, pwd:pwd, first_name:fName, last_name:lName}, function(data) {
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