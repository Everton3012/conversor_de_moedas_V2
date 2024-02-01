<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Resultado da Conversão</h1>
        
            <?php 
                $inicio = date("m-d-Y" , strtotime("-7 days"));

                $fim = date("m-d-Y");

                $moeda = $_POST["moeda"];

                $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoMoedaPeriodo(moeda=@moeda,dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@moeda=\''. $moeda .'\'&@dataInicial=\''. $inicio .'\'&@dataFinalCotacao=\''. $fim .'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

                $dados = json_decode(file_get_contents($url), true);

                $cotacao = $dados["value"][0]["cotacaoCompra"];

                $real = $_POST["real"] ?? 0;

                $resultado =  $real / $cotacao;

                $padrao = numfmt_create("pt_BR", NumberFormatter::CURRENCY);

                echo "Seus " . numfmt_format_currency($padrao, $real, "BRL") . " equivale a " . numfmt_format_currency($padrao, $resultado, $moeda);
            ?>
            
        <button onclick="javascript:window.location.href='index.html';">&#x2B05; Voltar</button>
    </main>
</body>
</html>