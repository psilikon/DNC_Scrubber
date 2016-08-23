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
	
});
</script>
<body>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12">
			<form enctype="multipart/form-data" action="saveDNCList.php" method="POST">
				Choose a file to upload: <input name="uploadedfile" type="file" /><br />
				<input type="submit" value="Upload File" />
			</form>
		</div> <!-- COL -->
	</div> <!-- ROW -->
</div>
</body>
</html>

