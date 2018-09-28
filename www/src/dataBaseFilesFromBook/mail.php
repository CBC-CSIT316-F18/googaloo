
<?php
include ('./mailer/class.smtp.php');
require_once('./mailer/class.phpmailer.php');

function mail_registrationworking($email)
    {
         $config = parse_ini_file(CONFIG);    
         $url=BASE_URL;
         $message=$url."activate.php?"."email=".$email."&key=".sha1($config['key'].$email);
         redirect($message);
    }



    function mail_registration($email)
    {
        $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
        $mail->IsSMTP(); // telling the class to use SMTP
        try 
        {
        
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "joshuabee@gmail.com";
        $mail->Password = "ab34stinger";
        $mail->SetFrom("joshuabee@gmail.com");
        $mail->Subject = "Custom Cloud account validation";
        $config = parse_ini_file(CONFIG); 
        //$mail->Body = 'Thank you for registering with custom cloud please click here to activate your account: '.'activate.php'?user=&email&$key=sh1($config[key].email);
        $mail->AddAddress('beejosh@yahoo.com');
          $mail->Send();
          echo 'Message Sent OK<p></p>\n';
        } catch (phpmailerException $e) {
          echo $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
          echo $e->getMessage(); //Boring error messages from anything else!
    }
}
?>

