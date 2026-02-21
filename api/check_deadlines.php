<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include Composer's autoloader only if it exists
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

require 'connectDB.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$current_time = new DateTime();
$check_time = clone $current_time;
$check_time->add(new DateInterval('PT1H')); // Add 1 hour

$sql = "SELECT l.id, l.uid, l.name, l.deadline_time, s.email 
        FROM logs l
        JOIN students s ON l.uid = s.uid
        WHERE l.warning_sent = FALSE AND l.deadline_time <= ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $check_time->format('Y-m-d H:i:s'));
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $student_name = $row['name'];
    $deadline_time = $row['deadline_time'];
    $email = $row['email'];
    $log_id = $row['id'];

    sendWarningEmail($student_name, $email, $deadline_time);

    $update_sql = "UPDATE logs SET warning_sent = TRUE WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('i', $log_id);
    $update_stmt->execute();
}

$stmt->close();
$conn->close();

function sendWarningEmail($student_name, $email, $deadline_time)
{
    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kaushikkumar2373@gmail.com'; // Your Gmail address
            $mail->Password = 'xhhj ytml arwo vfoz';      // Your Gmail app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('kaushikkumar2373@gmail.com', 'College Entry System');
            $mail->addAddress($email, $student_name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Warning: Entry Deadline Approaching';
            $mail->Body = "Dear $student_name,<br><br>You have only 1 hour left to enter the college. Your entry deadline is at $deadline_time.<br><br>Please make sure to enter the college before the deadline.<br><br>Thank you.";

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "[INFO] PHPMailer not found, skipping warning email.";
    }
}
?>