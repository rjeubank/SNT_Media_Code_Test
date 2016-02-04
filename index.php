<html>
<body>
<form action="index.php" method="GET">
 
Enter Article URL
<input type="text" name="urlText">
 
<input type="submit" name="submit" value="Submit">
</form>
</body>
</html>
<?php
require_once('class.urlContentReader.php');

if(isset($_GET["urlText"]))
{
	$cnnArticle = new urlContentReader($_GET["urlText"]);
	$cnnArticle->displayContent();
}


?>
