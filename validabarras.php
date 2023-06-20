<?php
session_start(); // Inicia a sessão para armazenar o array

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['meu_input'])) {
        $valor = $_POST['meu_input'];

        // Obtém o array da sessão
        $arrayCompleto = $_SESSION['meu_array'] ?? [];

        // Verifica se o valor já existe no array
        if (in_array($valor, $arrayCompleto)) {
            echo '<script>alert("Esta Nota Já está Cadastrada!");</script>';
        } else {
            // Adiciona o valor ao array
            $arrayCompleto[] = $valor;
            $_SESSION['meu_array'] = $arrayCompleto;
        }
    }
}

// Verifica se o botão "Visualizar" foi clicado
if (isset($_POST['arquivo_gerado'])) {

    // Converter o array em uma string formatada
    $stringArray = implode(PHP_EOL, $_SESSION['meu_array'] ?? []);

    // Caminho do arquivo de saída
    $nomeArquivo = 'Relação_de_Notas_Fiscais.txt';

    // Gravar o conteúdo no arquivo
    file_put_contents($nomeArquivo, $stringArray);
}

// Verifica se o botão "Visualizar" foi clicado
if (isset($_POST['limpar'])) {

    $_SESSION['meu_array'] = [];
}


// Obtém o array da sessão
$arrayCompleto = $_SESSION['meu_array'] ?? [];

// Função para exibir o array em uma lista numerada com quebras a cada 10 itens
function exibirArray($array) {
    echo '<ol>';
    foreach ($array as $item) {
        echo "<li>$item</li>";
    }
    echo '</ol>';
}



?>

<!DOCTYPE html>
<html>

<head>
    <title>Validador de Código de Barras</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">  
    
    <script type="text/javascript">
        window.onload = function() {
            document.getElementById("meuInput").focus();
        };
    </script>

</head>

<body>
    <div class="section">
        <div class="box">
            <h1>Validador de Código de Barras</h1>
            <form method="POST" action="">
                <input type="text" id="meuInput" name="meu_input" placeholder="Digite o Código de Barras">
                <script type="text/javascript">
                    window.onload = function() {
                        document.getElementById("meuInput").focus();
                    };
                </script>
                <input type="submit" value="Adicionar">
                <input type="submit" name="limpar" value="Limpar">
                <?php if (isset($_SESSION['meu_array']) && !empty($_SESSION['meu_array'])): ?>
                    <input type="hidden" name="arquivo_gerado" value="Relação_de_Notas_Fiscais.txt">
                    <a href="Relação_de_Notas_Fiscais.txt" download="Relação_de_Notas_Fiscais.txt"><button type="button">Download do arquivo</button></a>
                <?php endif; ?>
            </form>
        </div>
        <div class="box2">
                <?php
                    exibirArray($arrayCompleto);
                ?>
        </div>
    </div>

</body>
</html>
