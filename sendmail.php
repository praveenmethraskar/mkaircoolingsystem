<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['form_name'];
    $email = $_POST['form_email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if(empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message)){
        echo json_encode([
            "status" => "error",
            "message" => "All fields are required!"
        ]);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'praveenmethraskar@gmail.com';
        $mail->Password   = 'ifzdxrniqejrfdsu';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('praveenmethraskar@gmail.com', 'Website Contact');
        $mail->addAddress('praveenmethraskar@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = "New Contact: $subject";

$mail->Body = '
<html>
<head>
<style>
    body { font-family: Arial, sans-serif; }
    .container {
        width: 100%;
        max-width: 600px;
        margin: auto;
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
    }
    .header {
        background: #0d6efd;
        color: #fff;
        padding: 15px;
        text-align: center;
        font-size: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    td {
        padding: 12px;
        border-bottom: 1px solid #eee;
    }
    .label {
        background: #f8f9fa;
        font-weight: bold;
        width: 30%;
    }
    .footer {
        text-align: center;
        padding: 10px;
        font-size: 12px;
        color: #999;
    }
</style>
</head>

<body>

<div class="container">
    <div class="header">
        New Contact Message
    </div>

    <table>
        <tr>
            <td class="label">Name</td>
            <td>'.$name.'</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td>'.$email.'</td>
        </tr>
        <tr>
            <td class="label">Phone</td>
            <td>'.$phone.'</td>
        </tr>
        <tr>
            <td class="label">Subject</td>
            <td>'.$subject.'</td>
        </tr>
        <tr>
            <td class="label">Message</td>
            <td>'.$message.'</td>
        </tr>
    </table>

    <div class="footer">
        MK Air Cooling System Website
    </div>
</div>

</body>
</html>
';

        $mail->send();

        echo json_encode([
            "status" => "success",
            "message" => "Message sent successfully!"
        ]);

    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => $mail->ErrorInfo
        ]);
    }
}
?>