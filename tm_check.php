<!DOCTYPE html>
<html lang="en">
    <title>TM CHECK</title>
	<head>
        <link rel="stylesheet" href="css/loading.css">
        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
	</head>
<script>
$(document).ready(function() {
    $("#myModal").modal({ show: false});
	$("#loading-background").css({ opacity: 0.8 });
	$("#dnc_check").click(function () {
        $("#loading-background").show();
		var phone_number = $("#phone_number").val();
		var	cleaned_phone_number = phone_number.replace(/[^\d]/g, '');
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "dnc_check.php",
			data: { phone_number: cleaned_phone_number },
            success : function(data){
	            var dnc_result = data.dnc_result;
                $("#loading-background").hide();
				if(dnc_result === 'TRUE'){
					$("#dnc_result").html('<button type="button" class="btn btn-danger btn-lg"> '+cleaned_phone_number+' IS A DNC MATCH</button>');
				}else{
					$("#dnc_result").html('<button type="button" class="btn btn-success btn-lg">'+cleaned_phone_number+' IS NOT A DNC MATCH</button>');
				}
                $("#myModal").modal('show');
			}
		});
	});
});
</script>
<body>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="phone_number" class="col-sm-2 control-label">Phone Number:</label>
					<div class="col-sm-4">
						<input type="text" value="" id="phone_number" name="phone_number">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						 <input type="button" class="btn btn-success" id="dnc_check" value="DNC Check">
					</div>
				</div>
			</form>
		</div> <!-- COL -->
	</div> <!-- ROW -->
</div>
<div id="loading-background">
    <div id="loading" class="ui-corner-all" >
	    <img style="height:80px;margin:30px;" src="css/loading.gif" alt="Loading.."/>
        <h2 style="color:gray;font-weight:normal;">Please wait....</h2>
    </div>
</div>
 <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
						<div id="dnc_result">
						</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="modal_close" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>

