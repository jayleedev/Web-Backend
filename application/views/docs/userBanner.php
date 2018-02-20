<?php require_once '_leftmenu.php';?>

<main role="main" class="col-sm-9 ml-sm-auto col-md-9 pt-3">
<section class="row text-center placeholders">
	<div class="row-fluid api_section">
		<h2 class="api_title">
			<span style="color: #bababa;">POST&nbsp;</span>
			<span class="text-danger" style="font-size: 20px;">/setUserBanner?uid={User ID}&file={User Banner file}</span>
		</h2>
		<h4 class="api_subtitle text-secondary">Update user last name</h4>
		
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
						<td>
							User ID						
						</td>
						<td>
							<input type="email" class="form-control" id="uid" aria-describedby="emailHelp" placeholder="User ID">
						</td>
					</tr>
					
					<tr class="">
						<td>
							<b>file</b>
							<br>
							<font color="gray" size="1">String</font>
						</td>
						<td>
							User Banner File
						</td>
						<td>
							<input type="file" class="form-control" id="file" name="file">
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

	        var uid  = $("#uid").val();
	        var file_data = $('#file').prop('files')[0];   
            var form_data = new FormData();
            
            form_data.append('file', file_data);
            form_data.append('uid', uid);
            
            $.ajax({
                    url: '<?php echo base_url();?>index.php/mobile/setUserBanner',
                    dataType: 'text',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                         
                    type: 'post',
                    success: function(data){
                        var result = JSON.parse(data);
            			var output = JSON.stringify(result);
            			
            			output = output.replace('{','{<br>');
            			output = output.replace(',','<br>');
            			output = output.replace('",','"<br>');
            			output = output.replace('],',']<br>');
            			output = output.replace('}','<br>}');
            			
            			$("#result").html(output);
                    }
             });
	    });
	    
	});
	
</script>

</html>