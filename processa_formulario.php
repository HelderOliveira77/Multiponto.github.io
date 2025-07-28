<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuração SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'testeanalytics77@gmail.com'; // seu email
    $mail->Password = 'ogau wfem vnnd oupd'; // senha de app do Gmail
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Destinatário e remetente
    $mail->setFrom('testeanalytics77@gmail.com', 'Helder Teste');
    $mail->addAddress('helder.oliveira@multiponto.com');

    // Conteúdo
    $mail->isHTML(false);
    $mail->Subject = 'Contato do formulário';
    $mail->Body    = "Nome: {$_POST['nome']}\nEmail: {$_POST['email']}\nTelefone: {$_POST['telefone']}";

    $mail->send();
    echo 'Mensagem enviada!';
} catch (Exception $e) {
    echo "Erro ao enviar: {$mail->ErrorInfo}";
}
?>
