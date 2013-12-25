<?php
	$source = $_POST["source"];
	if(get_magic_quotes_gpc())
	{
		$source = stripslashes($source);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>csv2mt</title>
<body>

<form method="POST" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>">
<textarea cols="80" rows="20" name="source"><?php echo $source; ?></textarea><br />
<input type="checkbox" name="unixtime"<?php if($_POST[unixtime]){echo " checked";} ?>>use unixtime / 
<input type="checkbox" name="reverse"<?php if($_POST[reverse]){echo " checked";} ?>>reverse mode 
<input type="submit" name="submit" value="convert" /><br />

<?php
	if($_POST["submit"])
	{
		$source = trim($source);
		$data = split("\n",$source);
		if($_POST["reverse"])
		{
			$data = array_reverse($data);
		}
		foreach($data as $value)
		{
			$value = trim($value);
			list($title,$author,$date,$category,$body,$status) = split(",",$value);
			if($_POST["unixtime"])
			{
				$date = date("m/d/Y H:i:s",$date);
			}
			$body = eregi_replace("(<br>|<br />)","\n",$body);
			$output .= <<< EOM
TITLE: $title
AUTHOR: $author
DATE: $date
PRIMARY CATEGORY: $category
STATUS: $status
CONVERT BREAKS: 1
-----
BODY:
$body
-----
--------

EOM;
		}
		print <<< EOM
<textarea cols="80" rows="20" name="output">$output</textarea>
EOM;
	}
?>
</form>
</body>
</html>