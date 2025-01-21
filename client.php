<?php
try {
    $client = new SoapClient('http://localhost/soap/test.wsdl');
        //print_r($client->__getFunctions());


    $numero1 = isset($_POST['numero1']) ? floatval($_POST['numero1']) : 0.0;
    $currency = isset($_POST['currency']) ? $_POST['currency'] : 'USD';

    $xml = simplexml_load_file('eurofxref-daily.xml');
    $numero2 = 0.0;
    
    //echo (string)$xml->Cube->Cube['time'];
    $time=(string)$xml->Cube->Cube['time'];
    foreach ($xml->Cube->Cube->Cube as $cube) {
        if ((string)$cube['currency'] === $currency) {
            $numero2 = (float)$cube['rate'];
            break;
        }
    }

    //echo "numero1: $numero1<br>";
    //echo "currency: $currency<br>";
    //echo "numero2: $numero2<br>";

    //$parametri = ['numero1' => $numero1, 'numero2' => $numero2];
    //var_dump($parametri); // Debug dei parametri

    $risultato = $client->somma($numero1,$numero2);

    // Debug della richiesta e risposta SOAP
    //echo "SOAP Request:\n" . $client->__getLastRequest() . "\n";
    //echo "SOAP Response:\n" . $client->__getLastResponse() . "\n";

    if (is_float($risultato) || is_numeric($risultato)) {
        //echo "Risultato della somma: " . $risultato;
    } else {
        //echo "Risultato inatteso dal server SOAP.";
    }
} catch (SoapFault $e) {
    echo "Errore SOAP: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convertitore di Valuta</title>
    <style>
        :root {
            --primary-color: #1e90ff; /* Blue */
            --secondary-color: #ffffff; /* White */
            --accent-color: #333333; /* Dark Gray */
            --background-color: #f4f4f4; /* Light Gray */
            --text-color: #000000; /* Black */
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        header {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 20px;
            text-align: center;
            text-shadow: -1px 1px 0 #000, 1px 1px 0 #000, 1px -1px 0 #000, -1px -1px 0 #000;
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: var(--secondary-color);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }

        .converter {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .converter input, .converter select {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid var(--accent-color);
            border-radius: 5px;
            width: 100%;
            max-width: 300px;
        }

        .converter button {
            padding: 10px 20px;
            font-size: 1rem;
            background-color: var(--primary-color);
            color: var(--secondary-color);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .converter button:hover {
            background-color: #1c86ee;
        }

        .result {
            margin-top: 20px;
            font-size: 1.5rem;
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <header>
        <h1>Convertitore di Valuta</h1>
    </header>

    <div class="container">
        <div>
            <form class="converter" method="POST" action="">
                <input type="number" min="0" id="amount" placeholder="Importo in EUR" name="numero1" required/>
                <select id="currency" name="currency" required>
                    <option value="USD">USD - Dollaro Statunitense</option>
                    <option value="JPY">JPY - Yen Giapponese</option>
                    <option value="BGN">BGN - Lev Bulgaro</option>
                    <option value="CZK">CZK - Corona Ceca</option>
                    <option value="DKK">DKK - Corona Danese</option>
                    <option value="GBP">GBP - Sterlina Britannica</option>
                    <option value="HUF">HUF - Fiorino Ungherese</option>
                    <option value="PLN">PLN - Zloty Polacco</option>
                    <option value="RON">RON - Leu Rumeno</option>
                    <option value="SEK">SEK - Corona Svedese</option>
                    <option value="CHF">CHF - Franco Svizzero</option>
                    <option value="ISK">ISK - Corona Islandese</option>
                    <option value="NOK">NOK - Corona Norvegese</option>
                    <option value="TRY">TRY - Lira Turca</option>
                    <option value="AUD">AUD - Dollaro Australiano</option>
                    <option value="BRL">BRL - Real Brasiliano</option>
                    <option value="CAD">CAD - Dollaro Canadese</option>
                    <option value="CNY">CNY - Yuan Cinese</option>
                    <option value="HKD">HKD - Dollaro di Hong Kong</option>
                    <option value="IDR">IDR - Rupia Indonesiana</option>
                    <option value="ILS">ILS - Shekel Israeliano</option>
                    <option value="INR">INR - Rupia Indiana</option>
                    <option value="KRW">KRW - Won Sudcoreano</option>
                    <option value="MXN">MXN - Peso Messicano</option>
                    <option value="MYR">MYR - Ringgit Malese</option>
                    <option value="NZD">NZD - Dollaro Neozelandese</option>
                    <option value="PHP">PHP - Peso Filippino</option>
                    <option value="SGD">SGD - Dollaro di Singapore</option>
                    <option value="THB">THB - Baht Thailandese</option>
                    <option value="ZAR">ZAR - Rand Sudafricano</option>
                </select>
                <button type="submit" >Converti</button>
            </form>
        </div>
        <div class="result" id="result"><?php echo $numero1." EUR equivale a ".$risultato." ".$currency." il giorno ".$time;?></div>
    </div>
    <script>

        

        
        </script>
</body>

</html>

