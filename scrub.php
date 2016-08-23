<!DOCTYPE html>
<html lang="en">
    <title>DNC Scrubber</title>
	<head>
        <link rel="stylesheet" href="css/loading.css">
        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
	</head>
<script>
$(document).ready(function() {
	$("#loading-background").css({ opacity: 0.8 });
	var listArray = [];
	function addToListArray(id) {
		var x = listArray.indexOf(id);
		if(x >= 0){
			alert(id+" has already been added.");
			return false;
		}else{
			listArray.push(id);
			return true;
		}
	}

	function getLists() {
		$.getJSON('getLists.php', function(data) {
			$.each(data, function(i, val) {
				$("#scrubLists").append("<option value='"+val['list_id']+"'>"+val['list_id']+" - "+val['list_name']+" - "+val['list_description']+"</option>");
			});
		});
	}

	getLists();

	$(document).on('click', "input.removeListId", function() {
		var idToRemove = $(this).closest('tr').attr('id')
;		var index = listArray.indexOf(idToRemove);
		listArray.splice(index, 1)
		$("table#selectedLists tr#"+idToRemove).remove();
	});

	$("#addlist").click(function(event) {
		event.preventDefault();
		var listIdValue = $("#scrubLists").val();
		if(addToListArray(listIdValue)) {
			$("#selectedLists").append("<tr id='"+listIdValue+"'><td>"+listIdValue+"</td><td><input type='button' class='removeListId' value='remove'/></td></tr>");
		}
	});

	$("#initiateScrub").click(function () {
		if(listArray < 1){
			alert("Must include at least one list to scrub.");
		}else{
			var el = $(this);
			el.attr('disabled', 'disabled')
			$.ajax({
				type: "POST",
				url: "processScrub.php",
				data: { lists: listArray },
				success: function(data) {
					$("#processOutput").html(data);
				}
			});
		}
	});
});
</script>
<?php
session_start();
?>
<body>
<div class="container">
	<div class="well">
	<div class="row clearfix">
		<div class="col-md-12">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="scrubLists" class="col-sm-2 control-label">Scrub File:</label>
					<div class="col-sm-4">
						<input type="text" value="<? echo $_SESSION['dncfile']; ?>" readonly>
						<span>Records:<?echo $_SESSION['lineCount']; ?></span>
					</div>
				</div>
				<div class="form-group">
					<label for="scrubLists" class="col-sm-2 control-label">Select List:</label>
					<div class="col-sm-4">
						<select class="form-control" id="scrubLists">
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						 <input type="submit" class="btn btn-success" id="addlist" value="Add List">
					</div>
				</div>
			</form>
		</div> <!-- COL -->
	</div> <!-- ROW -->
	<div class="row">
		<fieldset>
		<div class="col-md-4">
			<span>Lists to Scrub:</span>
			<table id="selectedLists" class="table-striped table-bordered table-condensed">
			</table>
			<br />
			<input type="button" value="Scrub Lists" id="initiateScrub" class="btn btn-info"/>
		</div>
		</fieldset>
	</div> <!-- ROW -->
	</div>
</div>
<div id="processOutput">
</div>
<div id="loading-background">
    <div id="loading" class="ui-corner-all" >
	    <img style="height:80px;margin:30px;" src="css/loading.gif" alt="Loading.."/>
        <h2 style="color:gray;font-weight:normal;">Please wait....</h2>
    </div>
</div>
</body>
</html>

