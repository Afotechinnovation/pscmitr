<?php
$svr_image_path = "/var/www/pscmitr.com/public/storage/questions/image";
$send_error_details = false;
$str_err = null;

$iMathEQ_qid = $_GET["iMathEQ_qid"];
if ($iMathEQ_qid == null || empty($iMathEQ_qid))
{
	$str_err = "Error: missing input parameter - \"iMathEQ_qid\".";
	echo "{\"error\":\"" . $str_err . "\"}";
	return;
}

if (!file_exists($svr_image_path))
{
	$str_err = "Error: server equation image folder does not exist, "
		. "folder=" . urlencode($svr_image_path);
	echo "{\"error\":\"" . $str_err + "\"}";
	return;
}
if ($svr_image_path[strlen($svr_image_path) - 1] != '\\') $svr_image_path .= "\\";

$image_path = $svr_image_path . $iMathEQ_qid . ".png";

try
{
	$fp = fopen($image_path, 'rb');

	// send the right headers
	header("Content-Type: image/png");
	header("Content-Length: " . filesize($image_path));

	// dump the picture and stop the script
	fpassthru($fp);
	exit;
}
catch (Exception $ex)
{
	$str_err = "Error: open and send png file, " . $iMathEQ_qid . ".png" . ", " . "folder=" . urlencode($svr_image_path) .
		", error =" . ex.Message . ($send_error_details ?
		"," . urlencode($ex.StackTrace) : "");
	echo "{\"error\":\"" . str_err + "\"}";
	return;
}
?>
