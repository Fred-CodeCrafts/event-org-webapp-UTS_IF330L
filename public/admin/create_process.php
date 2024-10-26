<?php 
session_start();
if(!isset($_SESSION["admin"]) || $_SESSION["admin"] != "true") {
	header("Location: ../aut/login/admin.php");
}

require_once('../DB.php');

$cap = isset($_POST["cap"])
	? filter_var($_POST["cap"], FILTER_SANITIZE_NUMBER_INT)
	: "";
$event_name = isset($_POST["event_name"])
	? htmlspecialchars($_POST["event_name"])
	: "";
$loc = isset($_POST["loc"]) ? htmlspecialchars($_POST["loc"]) : "";
$start_time = isset($_POST["start_time"])
	? htmlspecialchars($_POST["start_time"])
	: "";
$end_time = isset($_POST["end_time"])
	? htmlspecialchars($_POST["end_time"])
	: "";
$start_date = isset($_POST["start_date"])
	? htmlspecialchars($_POST["start_date"])
	: "";
$end_date = isset($_POST["end_date"])
	? htmlspecialchars($_POST["end_date"])
	: "";
$desc = isset($_POST["desc"]) ? htmlspecialchars($_POST["desc"]) : "";

if ($start_time == $end_time && $start_date == $end_date) {
$end_time = date("H:i", strtotime($end_time) + 60 * 60);
}

if(empty($cap))
$cap = 50;

if (!empty($start_date) && !empty($end_date)) {

	$startDateTime = DateTime::createFromFormat("D M d Y", $start_date);
	$endDateTime = DateTime::createFromFormat("D M d Y", $end_date);

	if ($startDateTime && $endDateTime) {
		$start_date = $startDateTime->format("m/d/Y");
		$end_date = $endDateTime->format("m/d/Y");

		if (
			preg_match(
				'/^(0[1-9]|1[0-2]|[1-9])\/(0[1-9]|[12][0-9]|3[01]|[1-9])\/\d{4}$/',
				$start_date
			) &&
			preg_match(
				'/^(0[1-9]|1[0-2]|[1-9])\/(0[1-9]|[12][0-9]|3[01]|[1-9])\/\d{4}$/',
				$end_date
			)
		) {
			$startDateTime = DateTime::createFromFormat(
				"m/d/Y",
				$start_date
			);
			$endDateTime = DateTime::createFromFormat("m/d/Y", $end_date);

			if ($startDateTime === false || $endDateTime === false) {
				echo "Invalid date provided.";
				exit();
			}

			$start_date = $startDateTime->format("Y-m-d");
			$end_date = $endDateTime->format("Y-m-d");
		} else {
			echo "Invalid date format. Please use MM/DD/YYYY.";
			exit();
		}
	} else {
		echo "Invalid date format. Please use MM/DD/YYYY.";
		exit();
	}
} else {
	echo "Start date and end date are required.";
	exit();
}

$data =
"INSERT INTO event (event_name, start_time, end_time, location, description, capacity, start_date, end_date, image, status_toogle) 
	VALUES (:event_name, :start_time, :end_time, :location, :description, :capacity, :start_date, :end_date, :image, :status_toogle);";

$stmt = connectDB()->prepare($data);
$params = [
	":event_name" => $event_name,
	":start_time" => $start_time,
	":end_time" => $end_time,
	":location" => $loc,
	":description" => $desc,
	":capacity" => $cap,
	":start_date" => $start_date,
	":end_date" => $end_date,
	":status_toogle" => 1,
];

if (isset($_FILES["img"]) && $_FILES["img"]["error"] == UPLOAD_ERR_OK) {
	$fileName = $_FILES["img"]['name'];
	$tempName = $_FILES["img"]['tmp_name'];

	$fileExt = explode(".",$fileName);
	$fileExt = strtolower(end($fileExt));
	$allowedExtensions = ["jpg", "jpeg", "png", "svg", "webp", "bmp"];

	if (in_array($fileExt, $allowedExtensions)) {
	$uploadPath = "gambar/" . $fileName;
	if (move_uploaded_file($tempName, $uploadPath)) {
		$data .= ", image=:image";
		$params[":image"] = $fileName;
	}
	}
}

$stmt->execute($params);

header("Location: create_event.html");
