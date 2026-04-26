<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

header("Content-Type: application/json; charset=utf-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
    exit;
}

//  Match form field names
$name    = trim($_POST['form_name'] ?? '');
$email   = trim($_POST['form_email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$subject = trim($_POST['subject'] ?? 'New Enquiry');
$message = trim($_POST['message'] ?? '');

//  Validation
if (empty($name)) {
    echo json_encode(["status" => "error", "message" => "Name is required"]);
    exit;
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Valid email is required"]);
    exit;
}

//  Email config
$to = "praveenmethraskar@gmail.com";
$mail_subject = "New Enquiry - " . $subject;

//  Email body
$body = '
<table width="100%" cellpadding="0" cellspacing="0" style="font-family: Arial, sans-serif; background:#f7f7f7; padding:20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.1);">

                <tr>
                    <td style="background:#131e66; padding:20px; text-align:center; color:#fff;">
                        <h2 style="margin:0; font-size:24px; color:#fff;">New Customer Enquiry</h2>
                    </td>
                </tr>

                <tr>
                    <td style="padding:25px;">
                        <table width="100%" cellpadding="8" cellspacing="0" style="font-size:16px; border-collapse: collapse;">
                            <tr>
                                <td style="background:#f2f2f2; font-weight:bold; border:1px solid #ddd;">Name</td>
                                <td style="border:1px solid #ddd;">' . htmlspecialchars($name) . '</td>
                            </tr>
                            <tr>
                                <td style="background:#f2f2f2; font-weight:bold; border:1px solid #ddd;">Email</td>
                                <td style="border:1px solid #ddd;">' . htmlspecialchars($email) . '</td>
                            </tr>
                            <tr>
                                <td style="background:#f2f2f2; font-weight:bold; border:1px solid #ddd;">Phone</td>
                                <td style="border:1px solid #ddd;">' . htmlspecialchars($phone) . '</td>
                            </tr>
                            <tr>
                                <td style="background:#f2f2f2; font-weight:bold; border:1px solid #ddd;">Subject</td>
                                <td style="border:1px solid #ddd;">' . htmlspecialchars($subject) . '</td>
                            </tr>
                            <tr>
                                <td style="background:#f2f2f2; font-weight:bold; border:1px solid #ddd;">Message</td>
                                <td style="border:1px solid #ddd;">' . nl2br(htmlspecialchars($message)) . '</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="background:#131e66; padding:15px; text-align:center; color:#fff; font-size:14px;">
                        © 2026 — Customer Enquiry
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
';

//  Headers
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type:text/html;charset=UTF-8\r\n";
$headers .= "From: Website Enquiry <no-reply@yourdomain.com>\r\n";
$headers .= "Reply-To: $email\r\n";

//  Send mail
if (mail($to, $mail_subject, $body, $headers)) {
    echo json_encode(["status" => "success", "message" => "Mail sent successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Mail sending failed. Configure SMTP on server"]);
}
?>