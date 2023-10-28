<?php
    // header('Content-Type: text/html; charset=utf-8');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    $conn = new mysqli("localhost", "root", "", "db_shop");
    // $email1 = $_POST['email'];
    $query = "SELECT * FROM db_user";
    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           $email = $row["email"];
           $password = sha1($row['password']);
        //    $hoten = $row["hoten"];
        }
    }
    
    // $email1 = $_POST['email'];
    
    $repass = rand(222222222, 999999999);
    $newpass = sha1($repass);
    if(isset($_POST['repass'])){
        $email1 = $_POST['email'];

        if($email1 == "huutin@gmail.com" || $email1 == "19004210@st.vlute.edu.vn" || $email1 == "nv@gmail.com"){
            $conn->query($sqlupdate = "UPDATE `db_user` SET `password` = '$newpass' WHERE `email` = '$email1'");
            
            //send mail pass
            $name = "Master Chef - Forgot Password";
            $email = "masterchef@gmail.com";
            $subject = "Khôi Phục Passsword";
            $body = "Password quản lý của bạn là:  $repass, vui lòng không cung cấp cho người ngoài.";
        
            $return_name = mb_strtoupper($name, 'UTF-8');
            $return_subject = mb_strtoupper($subject, 'UTF-8');
            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer;
            $mail->CharSet = 'UTF-8';
            $mail->ContentType = 'text/plain'; 
            $mail->IsHTML(false);
        
            // $mail = new PHPMailer(true);
        
            try {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tinnguen123@gmail.com';// SMTP username
                $mail->Password = 'cnniyiqdpejrxdqr'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                //Recipients
                $mail->setFrom($email, $return_name);
                $mail->addAddress('tinnguen123@gmail.com', 'Bao Trung');
                // $mail->addAddress('19004210@st.vlute.edu.vn');
                $mail->addAddress($email1); // Name is optional
                $mail->isHTML(true);
                $mail->Subject = ("$name - $return_subject");
                $mail->Body ="From: $email <br>$name <br>$body";
                $mail->CharSet = 'UTF-8';
                
                if($mail->send()){
                    echo '<script language="javascript">
                    alert("Mật khẩu được gửi về mail của bạn, vui lòng kiểm tra mail");
                    location.replace("admin/login");
                    </script>';
                }
        
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            
        } else {
            echo '<script language="javascript">;
                    alert("Không Tìm Thấy Email Trùng Khớp!! Vui Lòng Kiểm Tra Lại");
                </script>';
                // return $email1;
        }
        
    }
    // echo $email1;
    // echo '<script language="javascript">;
    //         alert("'.$email1.'");
    //     </script>';

?>

<html lang="">
	<head>
        <base href="<?php echo base_url(); ?>"></base>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Master Chef - Forgot Password</title>
        <link rel="shortcut icon" href="public/images/templates/favicon.png" />
		<link rel="stylesheet" href="public/css/bootstrap.css">
		<link rel="stylesheet" href="public/css/login.css">
		<link rel="stylesheet" href="public/css/font-awesome.min.css">
    </head>
    <body>
        <div class="container khung">
            <div class="title">
                <h2 class="text-center" style="color:#337ab7">Master Chef - Forgot Password</h2>
            </div>
            <hr>
            <div class="myform">
                <form action="" method="POST" role="form">
                    <div class="row form-row">
                        <div class="input-group">
                           <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                           <input type="text" name="email" class="form-control" placeholder="Email đăng nhập">
                          
                        </div>
                    </div>

                    <div class="row form-row" style="width:100%; margin-top: 15px;">
                        <button name="repass" type="submit" class="form-control btn btn-primary btn-login">Forgot Password</button>
                    </div>
                    <div class="row form-row" style="width:100%; margin-top: 15px;">
                        <center><a href="admin/login">Goto Login</a></center>
                    </div>
                    
                    <?php  if(isset($error)):?>
                        <div class="row">
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            </div>
                        </div>
                    <?php  endif;?>
                </form>
            </div>
            <hr>
        </div>
        <nav class="navbar navbar-fixed-bottom" role="navigation">
            <div class="container">
               <h5 class="text-center">Copyright © 2022 <a href="#" style="color:red">Master-Chef</a>. All rights reserved.</h5>
            </div>
        </nav>
        <!-- jQuery -->
        <script src="public/js/jquery-2.2.3.min.js"></script>
		<script src="public/js/bootstrap.js"></script>
    
	</body>
</html>