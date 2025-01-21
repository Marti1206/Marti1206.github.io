<?php
class HelloService {
    public function somma($numero1, $numero2) {
        return $numero1 * $numero2;
    }
}

$options = ['uri' => 'http://localhost/soap/hello'];
$server = new SoapServer('http://localhost/soap/test.wsdl', $options);
$server->setClass('HelloService');
$server->handle();
?>
