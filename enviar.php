
<!-- _________________________ -->
<?php

// 1. Defina o endereço de email de destino no início.
$para = "multiponto.oliveira@multiponto.com"; 

// 2. Verifique se o pedido é POST e se o script não está a ser executado diretamente.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. Valide os campos obrigatórios primeiro.
    if (empty($_POST["nome"]) || empty($_POST["email"]) || empty($_POST["mensagem"])) {
        http_response_code(400); // 400 Bad Request
        echo "Por favor, preencha todos os campos do formulário.";
        exit;
    }

    // 4. Limpeza e validação de dados
    //    Use strip_tags() para remover tags HTML
    //    Use trim() para remover espaços em branco no início e no fim
    //    Use filter_var() com a validação mais rigorosa para o email
    $nome = htmlspecialchars(trim($_POST["nome"]), ENT_QUOTES, 'UTF-8');
    $email = trim($_POST["email"]);
    $mensagem = htmlspecialchars(trim($_POST["mensagem"]), ENT_QUOTES, 'UTF-8');

    // Validação final do email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "O endereço de email fornecido é inválido.";
        exit;
    }

    // 5. Preparação dos dados para o email
    $assunto = "Mensagem do site de $nome";
    $conteudo = "Nome: $nome\n";
    $conteudo .= "Email: $email\n\n";
    $conteudo .= "Mensagem:\n$mensagem\n";

    // 6. Cabeçalhos de email seguros
    //    Defina o remetente como o seu próprio domínio para evitar spam.
    //    O email do utilizador pode ser colocado no Reply-To para que você possa responder.
    $cabecalhos = "From: Seu Site <noreply@seu-dominio.com>\r\n";
    $cabecalhos .= "Reply-To: $email\r\n";
    $cabecalhos .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // 7. Envio do email
    if (mail($para, $assunto, $conteudo, $cabecalhos)) {
        header("Location: obrigado.html");
        exit;
    } else {
        http_response_code(500); // 500 Internal Server Error
        echo "Ocorreu um erro ao tentar enviar a sua mensagem. Por favor, tente novamente mais tarde.";
    }

} else {
    // Se o método não for POST, redirecione ou exiba uma mensagem de erro.
    http_response_code(405); // 405 Method Not Allowed
    echo "Método de pedido não permitido.";
}

?>
