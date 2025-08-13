<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = strip_tags(trim($_POST["nome"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mensagem = trim($_POST["mensagem"]);

    if (empty($nome) || empty($mensagem) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Preencha todos os campos corretamente.");
    }

    $para = "multiponto.oliveira@multiponto.com"; // <-- ALTERE AQUI
    $assunto = "Mensagem do site de $nome";
    $conteudo = "Nome: $nome\n";
    $conteudo .= "Email: $email\n\n";
    $conteudo .= "Mensagem:\n$mensagem\n";

    $cabecalhos = "From: $nome <$email>";

    if (mail($para, $assunto, $conteudo, $cabecalhos)) {
        header("Location: obrigado.html");
exit;
    } else {
        echo "Erro ao enviar. Tente novamente.";
    }
}
?>
