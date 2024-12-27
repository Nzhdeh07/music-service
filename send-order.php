<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Origin: *');

if($_POST){
// 	print_r($_POST);

    require_once('phpmailer/PHPMailerAutoload.php');

    $mail = new PHPMailer;
    $mail->CharSet = 'utf-8';

    // print_r($_POST);
    $form_subject = "Форма с сайта";
    foreach ($_POST as $key => $value) {
        if ($key === "form_subject") {
            // Преобразуем значение в строку, даже если оно передано как массив
            $form_subject = is_array($value) ? reset($value) : $value;
        }
    }



    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->SMTPAuth = true;    // Enable SMTP authentication
    //* YANDEX
    $mail->Host = 'smtp.yandex.ru';
    $mail->Username = 'take@digitalgoweb.com';// Ваш логин от почты с которой будут отправляться письма
    $mail->Password = 'dkvvrmmxsmsepbqe';
    // $mail->Password = '1Q0f6K7s'; // Ваш пароль от почты с которой будут отправляться письма
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465; // TCP port to connect to / этот порт может отличаться у других провайдеров

    // $mail->setFrom('piro.master@bk.ru', $form_subject);
    $mail->setFrom('take@digitalgoweb.com'); // от кого будет уходить письмо?
    $mail->addAddress('mut_nyut@mail.ru');     // Кому будет уходить письмо
// 	$mail->addAddress('kraska.ey@gmail.com');     // Кому будет уходить письмо
    $mail->addReplyTo('mut_nyut@mail.ru', 'Обратная связь');
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = '' .$form_subject;

    $c = true;

    $body = '';
    $body .= '
		<table style="width: 100%;">';
    foreach ( $_POST as $key => $value ) {
        if ( $key != "project_name" && $key != "admin_email" && $key != "form_subject" && $value[0]) {

            $body .= "
				" . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
					<td style='padding: 10px; border: #e9e9e9 1px solid;'><b>";

            if($key === 'tel'){
                $body .= 'Телефон';
            }elseif ($key === 'object') {
                $body .= 'Объект для оценки';
            }else{
                $body .= str_replace('_',' ',$key);
            }

            $body .="</b></td>
					<td style='padding: 10px; border: #e9e9e9 1px solid;'>". implode(";<br/> ", $value) ."</td>
				</tr>
				";
        }
    }
    $body .= '</table>';

    $mail->Body = $body;
    $mail->AltBody = $body;

    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                               // Enable verbose debug output
    // $mail->send();
    if(!$mail->send()) {
        echo $answer = 0;
    } else {
        echo $answer = 1;
    }

    die($answer);
}