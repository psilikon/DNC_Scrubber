<?

session_start();

$timestamp = time();
$dest_path = "dnclist/";
$target_path = $dest_path . basename( $_FILES['uploadedfile']['name']);
$path_parts = pathinfo($target_path);
$xten = $path_parts['extension'];

$_SESSION['dncfile'] = $dest_path . $timestamp . "." . $xten;

function countLines($file){
	$linecount = 0;
	$handle = fopen($file, "r");
	while(!feof($handle)){
		$line = fgets($handle);
	  	$linecount++;
	}
	fclose($handle);
	return $linecount;
}

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
	if(rename($target_path, $dest_path . $timestamp . "." . $xten)) {
		$_SESSION['lineCount'] = countLines($dest_path.$timestamp.".".$xten);
      		header("Location: http://itsinc.psinet.pw/scrub/scrub.php");
		exit();
	} else {
		echo "An error occured saving and renaming file.";
	}
} else{
    echo "There was an error uploading the file, please try again!";
}


?>
