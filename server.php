<?php
class HelloService {
    public function somma($numero1, $numero2) {
        return $numero1 * $numero2;
    }
}

$options = ['uri' => 'http://localhost/soap/hello'];
$server = new SoapServer('https://marti1206.github.io/test.wsdl', $options);
$server->setClass('HelloService');
$server->handle();
?>
