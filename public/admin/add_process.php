<?php 
$dsn = "mysql:host=localhost;dbname=uts";
$kunci = new PDO($dsn,"root","");

$fileName = $_FILES["img"]['name'];
$tempName = $_FILES["img"]['tmp_name'];

$fileExt = explode(".",$fileName);
$fileExt = strtolower(end($fileExt));

$extList = ['jpg','jpeg','png','svg','webp','bmp'];

if(!(in_array($fileExt,$extList)))
    echo "<script>alert('Anda hanya bisa upload file gambar')</script>";
else{
    $cap = htmlspecialchars(preg_replace('/\D/', '', $_POST['cap']));
    $event_name = htmlspecialchars($_POST['event_name']);
    $loc = htmlspecialchars($_POST['loc']);
    $start_time = htmlspecialchars($_POST['start_time']);
    $end_time = htmlspecialchars($_POST['end_time']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    $desc = htmlspecialchars($_POST['desc']);

    if($start_time = $end_time)
        $end_time = date('H:i', strtotime($end_time) + 60*60);

    echo $cap;

    if(empty($cap))
        $cap = 50;

    $tempS = explode("/",$start_date);
    $tempE = explode("/",$end_date);

    $start_date = $tempS[2] . '-' . $tempS[0] . '-' . $tempS[1];
    $end_date = $tempE[2] . '-' . $tempE[0] . '-' . $tempE[1];

    $data = "INSERT INTO event (nama,waktu_mulai,waktu_berakhir,lokasi,deskripsi,kapasitas,gambar,tgl_mulai,tgl_akhir)
                VALUES (?,?,?,?,?,?,?,?,?)";

    $stmt = $kunci->prepare($data);
    $data = [$event_name,$start_time,$end_time,$loc,$desc,$cap,$fileName,$start_date,$end_date];
    $stmt->execute($data);
    move_uploaded_file($tempName,"gambar/{$fileName}");
    header("Location: add_event.php");
}
