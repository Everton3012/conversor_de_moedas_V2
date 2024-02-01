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
        <h1>Conversor de Moedas: Euro e Dolar</h1>
        <p>
            <?php 

                $inicio = date("m-d-Y" , strtotime("-7 days"));

                $fim = date("m-d-Y");

                $urlDol = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''. $inicio .'\'&@dataFinalCotacao=\''. $fim .'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

                $dadosDol = json_decode(file_get_contents($urlDol), true);

                $cotacaoDol = $dadosDol["value"][0]["cotacaoCompra"];

                $urlEur = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoMoedaPeriodo(moeda=@moeda,dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@moeda=\'EUR\'&@dataInicial=\''. $inicio .'\'&@dataFinalCotacao=\''. $fim .'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

                $dadosEur = json_decode(file_get_contents($urlEur), true);

                $cotacaoEur = $dadosEur["value"][0]["cotacaoCompra"];

                $real = $_POST["real"] ?? 0;

                $dolar =  $real / $cotacaoDol;

                $euro  =  $real / $cotacaoEur;

                $padrao = numfmt_create("pt_BR", NumberFormatter::CURRENCY);

                echo "Seus " . numfmt_format_currency($padrao, $real, "BRL") . " equivale a " . numfmt_format_currency($padrao, $dolar, "USD") .  " Dolares" . " e também equivale a " . numfmt_format_currency($padrao, $euro, "EUR") . " Euros";
                

            ?>
            </p>
    <button onclick="javascript:window.location.href='index.html';">&#x2B05; Voltar</button>
    </main>
</body>
</html>