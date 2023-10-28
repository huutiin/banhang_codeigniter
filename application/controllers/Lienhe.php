<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
class Lienhe extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->data['com']='Lienhe';
		$this->load->model('frontend/Mcategory');
		$this->load->model('frontend/Mproduct');
		$this->load->model('frontend/Mcontact');

	}
	
	public function index()
	{	
		$d=getdate();
		$today=$d['year']."/".$d['mon']."/".$d['mday'];
		$this->load->library('form_validation');
		$this->form_validation->set_rules('fullname', 'Họ và tên','required' );
		$this->form_validation->set_rules('email', 'email','required|valid_email' );
		$this->form_validation->set_rules('phone', 'Số điện thoại','required' );
		$this->form_validation->set_rules('subject', 'tiêu đề','required' );
		$this->form_validation->set_rules('body', 'nội dụng','required' );
		if($this->form_validation->run()==TRUE){
			$mydata=array(
				'fullname'=>$_POST['fullname'],
				'email'=>$_POST['email'],
				'phone'=>$_POST['phone'],
				'title'=>$_POST['subject'],
				'content'=>$_POST['body'],
				'created_at'=> $today
			);
			$this->Mcontact->contact_insert($mydata);
			echo '<script>alert("Tin nhắn của bạn đã gửi đi thành công !")</script>';

			$name = $_POST['fullname'];
			$email = $_POST['email'];
			$subject = $_POST['subject'];
			$body = $_POST['body'];

			$return_name = mb_strtoupper($name, 'UTF-8');
			$return_subject = mb_strtoupper($subject, 'UTF-8');
			// Instantiation and passing `true` enables exceptions
			$mail = new PHPMailer;
			$mail->CharSet = 'UTF-8';
			$mail->ContentType = 'text/plain'; 
			$mail->IsHTML(false);

			// $mail = new PHPMailer(true);

			try {
				//Server settings
				$mail->SMTPDebug = SMTP::DEBUG_SERVER;// Enable verbose debug output
				$mail->isSMTP();// gửi mail SMTP
				$mail->Host = 'smtp.gmail.com';// Set the SMTP server to send through
				$mail->SMTPAuth = true;// Enable SMTP authentication
				$mail->Username = 'tinnguen123@gmail.com';// SMTP username
				$mail->Password = 'cnniyiqdpejrxdqr'; // SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
				$mail->Port = 587; // TCP port to connect to
				//Recipients
				$mail->setFrom($email, $return_name);
				$mail->addAddress('tinnguen123@gmail.com', 'Nguyen Huu Tin'); // Add a recipient
				// $mail->addAddress('nhocnho721@gmail.com'); // Name is optional
				$mail->isHTML(true);   // Set email format to HTML
				$mail->Subject = ("$return_subject");
				$mail->Body = "From: $email <br>Name: $name <br>Message: $body";
				$mail->CharSet = 'UTF-8';
				// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				// $mail->send();
				if($mail->send()){
				    echo '<script language="javascript">
				    	location.replace("http://localhost/Project_Laravel/BaoCao/lien-he");
				    </script>';
				}

			} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}
		}
		// header('Content-Type: text/html; charset=utf-8');
        
        

		$this->data['title']="Master Chef - Liên hệ";
		$this->data['view']='index';
		$this->load->view('frontend/layout',$this->data);
	}
	
	
}

