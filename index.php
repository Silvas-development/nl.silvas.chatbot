<?PHP

if ($_REQUEST['vraag'] != "")
{

$servername = "localhost";
$username = "";
$password = "";
$database = "";

$conn = new mysqli($servername, $username, $password);
$conn->select_db($database);

$vraag = $_REQUEST['vraag'];

$vraag = str_replace("?","",$vraag);
$vraag = str_replace(".","",$vraag);
$vraag = str_replace(",","",$vraag);

$woorden = explode(" ",$vraag);
foreach ($woorden as $woord)
{
	if (strlen($woord) > 2)
	{
		$sqlline = "SELECT `ID` FROM `vragen` WHERE `vraag` LIKE '%" . $conn->mysqli_real_escape_string($woord) . "%'";
		$result = $conn->query($sqlline);
		while($row = $result->fetch_assoc())
		{
			$punten[$row['ID']]++;
		}
	}
}

if (count($punten) > 0)
{
$winnaar = array_search(max($punten), $punten);
}
else
{
print "Geen antwoord gevonden in de database";
exit;
}

$sqlline = "SELECT `antwoord` FROM `vragen` WHERE `ID`='" . (int)$winnaar . "'";

$result = $conn->query($sqlline);
$antwoord = $result->fetch_assoc();

print "Het antwoord is:" . $antwoord['antwoord'] . "<hr>";
}
?>
<form action="">
Vraag: <input type='text' name='vraag'><input type='submit' value='Vragen'>
</form>
