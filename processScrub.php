<?
session_start();


$filename = $_SESSION['dncfile'];
$list_array = $_POST['lists'];

$liststring = implode(' ',$list_array);

$filename = '/srv/www/htdocs/scrub/'.$filename;
$commandargs = "screen -dmS SCRUB /srv/www/htdocs/scrub/list_scrub.py ".$filename." '$liststring'";
shell_exec($commandargs);

echo "<hr>";
echo "<br />";
echo "<h3> You should receive and email shortly detailing how many leads were matched to the DNC list.</h3><br />";

?>

