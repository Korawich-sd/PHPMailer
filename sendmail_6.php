<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';



$alert = '';

if (isset($_POST['sendmail_6'])) {
	$name = addslashes($_POST['name']);
	$age = addslashes($_POST['age']);
	$phone = addslashes($_POST['phone']);
	$email = addslashes($_POST['email']);
	$position = addslashes($_POST['position']);
	$money = addslashes($_POST['money']);
	$exp = addslashes($_POST['exp']);
	//$pdf = $_FILES['pdf'];
	$doc_file = (isset($_POST['pdf']) ? $_POST['pdf'] : '');
	$message = addslashes($_POST['message']);
	
	$to = "programmer@thaibyhost.com";
	$to1 = "programmer1@thaibyhost.com";
	$attachment = $_FILES["pdf"]["tmp_name"];
	$folder = "upload/";
	$file_name = $_FILES["pdf"]["name"];
    move_uploaded_file($_FILES["pdf"]["tmp_name"], "$folder" . $_FILES["pdf"]["name"]);

	$msg =  "เรื่อง : " . "สมัครงาน" . "\n" .
		"จากคุณ : " . $name . "\n" .
		"อีเมล : " . $email . "\n" .
		"เบอร์โทรศัพท์ : " . $phone . "\n" .
		"สมัครตำแหน่ง : " . $position . "\n" .
		"เงินเดือนที่ต้องการ : " . $money . "\n" .
		"ประสบการณ์ : " . $exp . "\n" .
		"สอบถามเพิ่มเติม : " . $message;

	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$mail->From = $email;
	$mail->Subject = "สมัครงาน";
	$mail->Body = $msg;
	$mail->addAddress($to);
	//$mail->addAddress($to1);

	$attach_file = $folder . "" . $file_name;
	$mail->addAttachment($attach_file, $file_name);
	$mail->send();

	if ($mail) {
		echo "<script>alert('ส่ง Email สำเร็จ')</script>";
		echo "<meta http-equiv='refresh' content='0;url=career.php'>";
	} else {
		echo "<script>alert('ส่ง Email ไม่สำเร็จ')</script>";
	}
}
