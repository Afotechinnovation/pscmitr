<?php
//print_r("save_imatheq_eq_image.php, beginning");
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$svr_image_path = "/var/www/pscmitr.com/public/storage/questions/image";
	$send_error_details = false;
	$str_err = null;
	$input;

	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}

	if (empty($_POST["image_data"]))
	{
		$str_err = "Error: missing (POST) parameters in server call. Please contact system administrator.";
		echo "{\"error\":\"".$str_err."\"}";
		return;
	}

	$iMathEQ_qid;
	if (empty($_POST["iMathEQ_qid"]))
	{
		$iMathEQ_qid = GUID();
	}
	else
		$iMathEQ_qid = $_POST["iMathEQ_qid"];

	$image_data = $_POST["image_data"];

	if (!file_exists($svr_image_path))
	{
		$str_err = "Error: server equation image folder does not exist, "
			. "folder=" . urlencode($svr_image_path);
		echo "{\"error\":\"" . $str_err . "\"}";
		return;
	}
	if ($svr_image_path[strlen($svr_image_path) - 1] != '\\') $svr_image_path .= "\\";

	$image_path = $svr_image_path . $iMathEQ_qid . ".png";

	try
	{
		$img_str = urldecode($image_data);

		//remove beginning "data:image/png;base64,"
		$img_str = substr($img_str, 22);
		//echo $img_str;

		$img_str = str_replace(' ', '+', $img_str);

		$bytes = base64_decode($img_str);

		try
		{
			$file = file_put_contents($image_path, $bytes);
			if ($file === false) {
				$str_err = "Error: save file, " . $iMathEQ_qid . ".png" . ", to image folder, " . "folder=" + urlencode($svr_image_path);
				echo "{\"error\":\"" . $str_err . "\"}";
				return;
			}

		}
		catch (Exception $ex)
		{
			$str_err = "Error: save file, " . $iMathEQ_qid . ".png" . ", to image folder, " . "folder=" . urlencode($svr_image_path) .
				", error =" . ex.Message . ($send_error_details ?
				"," . urlencode($ex.StackTrace) : "");
			echo "{\"error\":\"" . str_err + "\"}";
			return;
		}

	}
	catch (Exception $ee)
	{
		$str_err = "Error when saving equation image to server, error message: " .
			$ee.Message . ($send_error_details ?
				"," . urlencode($ee.StackTrace) : "");
		echo "{\"error\":\"" . str_err + "\"}";
		return;
	}

	echo "{\"iMathEQ_qid\":\"" . $iMathEQ_qid . "\"}";
}
?>
