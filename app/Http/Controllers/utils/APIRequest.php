<?php

namespace App\Http\Controllers\Utils;

use Exception;
use GuzzleHttp\Client;
use App\Exceptions\ClientAPIException;
use App\Exceptions\RequestAPIException;
use GuzzleHttp\Exception\ClientException;
use App\Http\Controllers\Utils\LogManager;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;

class APIRequest
{
    // Generate soap request
    public function generateSoapRequest($header,$body,$action,$type,$method =null,$amount=null,$order=null){
        $log = new LogManager();
        $soapEnvelope = '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">';
        $soapHeader = '<soap:Header>'.$header.'</soap:Header>';
        $soapBody = '<soap:Body>'.$body;
        $closeSoap = '</soap:Body></soap:Envelope>';
        $xml = $soapEnvelope . $soapHeader . $soapBody . $closeSoap;

        // Guzzle client
        $client = new Client();
        try {
            $response = $client->post(env('WSDL'),[
                            'verify' => false,
                            'connect_timeout' => 10,
                            'timeout' => 25,
                            'headers' => [
                                'SOAPAction' => $action,
                                'Content-Type' => 'text/xml'
                            ],	          
                            'body' => $xml
                        ]);
        // } catch (ConnectException $e) {
        //     $log->error("ConnectException - Line:".$e->getLine()." ".$e->getMessage()." ".$e->getFile());
        //     throw new RequestAPIException('No se pudo realizar el proceso, verifique nuevamente.');
        } catch (RequestException $e) {
            $log->error("RequestException - Line:".$e->getLine()." ".$e->getMessage()." ".$e->getFile());
            if($type === 'payment'){
                $this->requestReverse($method,$amount,$order);
            }
            throw new RequestAPIException('No se pudo realizar el proceso, verifique nuevamente.');
        } catch (ClientException $e) {
            $log->error("ClientException - Line:".$e->getLine()." ".$e->getMessage()." ".$e->getFile());
            if($type === 'payment'){
                $this->requestReverse($method,$amount,$order);
            }
            throw new ClientAPIException('Solicitud incorrecta, verifique nuevamente.');
        } catch (Exception $e) {
            $log->error("Exception - Line:".$e->getLine()." ".$e->getMessage()." ".$e->getFile());
            if($type === 'payment'){
                $this->requestReverse($method,$amount,$order);
            }
            throw new RequestAPIException('No se pudo realizar el proceso, verifique nuevamente.');
        }

        // Convert the response body to array	      
        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3",	        
        $response->getBody()->getContents());
        $xml = new \SimpleXMLElement($response);
        $array = json_decode(json_encode((array)$xml), true);
        return $array;

    }

    public function requestReverse($method,$amount,$order){
        $log = new LogManager();
        $soapEnvelope = '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">';
        $soapHeader = '<soap:Header></soap:Header>';
        $soapBody = '<soap:Body>
                        <RequestRevers xmlns="http://buypass.service.serfinsa.com/">
                            <e>
                                <Rtl>'.env('RTL').'</Rtl>
                                <Key>'.$method->key.'</Key>
                                <Amount>'.$amount.'</Amount>
                                <Aditional> Reversión de orden #'.$order->order_number.'</Aditional>
                            </e>
                        </RequestRevers>';
        $closeSoap = '</soap:Body></soap:Envelope>';
        $xml = $soapEnvelope . $soapHeader . $soapBody . $closeSoap;

        // Guzzle client
        $client = new Client();
        try {
            $response = $client->post(env('WSDL'),[
                            'verify' => false,
                            'connect_timeout' => 10,
                            'timeout' => 25,
                            'headers' => [
                                'SOAPAction' => 'http://buypass.service.serfinsa.com/RequestRevers',
                                'Content-Type' => 'text/xml'
                            ],	          
                            'body' => $xml
                        ]);
        // } catch (ConnectException $e) {
        //     $log->error("ConnectException - Line:".$e->getLine()." ".$e->getMessage()." ".$e->getFile());
        //     throw new RequestAPIException('Problemas procesando pago, favor intente nuevamente.');
        } catch (RequestException $e) {
            $log->error("RequestException - Line:".$e->getLine()." ".$e->getMessage()." ".$e->getFile());
            throw new RequestAPIException('Problemas procesando pago, favor intente nuevamente.');
        } catch (ClientException $e) {
            $log->error("ClientException - Line:".$e->getLine()." ".$e->getMessage()." ".$e->getFile());
            throw new ClientAPIException('Problemas procesando pago, favor intente nuevamente.');
        } catch (Exception $e) {
            $log->error("Exception - Line:".$e->getLine()." ".$e->getMessage()." ".$e->getFile());
            throw new RequestAPIException('Problemas procesando pago, favor intente nuevamente.');
        }
        
        throw new RequestAPIException('No se pudo realizar el pago, favor verifique nuevamente.');
    }
}