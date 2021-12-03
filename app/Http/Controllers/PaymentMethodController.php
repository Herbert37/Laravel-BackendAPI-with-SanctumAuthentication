<?php

namespace App\Http\Controllers\API\User;

use Exception;
use App\PaymentMethod;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Exceptions\ClientAPIException;
use App\Exceptions\RequestAPIException;
use App\Http\Requests\VerifyCardRequest;
use GuzzleHttp\Exception\ClientException;
use App\Http\Controllers\Utils\LogManager;
use GuzzleHttp\Exception\RequestException;
use App\Http\Controllers\Utils\APIRequest;
use App\Http\Requests\PaymentMethodRequest;
use App\Http\Resources\PaymentMethodResource;

class PaymentMethodController extends Controller
{
    protected $log;

    public function __construct()
    {
        $this->log = new LogManager();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cards = auth()->user()->payment_methods()->whereVerified(true)
                  ->latest()->get();

        return PaymentMethodResource::collection($cards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\PaymentMethodRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PaymentMethodRequest $request)
    {
        $apiRequest = new APIRequest();

        $last_four = substr($request->card_number,-4);

        $type = 'store';
        $rtl = env('RTL');
        $soapHeader = '';
        $soapBody = '<CreateCliente xmlns="http://buypass.service.serfinsa.com/">
                        <e>
                            <Rtl>'.$rtl.'</Rtl>
                            <Info>'.$request->card_number.'</Info>
                            <InfoV>'.$request->exp_year.''.$request->exp_month.'</InfoV>
                            <InfoS>'.$request->cvv.'</InfoS>
                        </e>
                    </CreateCliente>';
        $action = 'http://buypass.service.serfinsa.com/CreateCliente';
        $response = $apiRequest->generateSoapRequest($soapHeader,$soapBody,$action,$type);

        $result = $response['soapBody']['CreateClienteResponse']['CreateClienteResult'];
        if($result['IsPersist'] ==='false'){
            if($result['Message'] ==='Tarjeta ya se encuentra registrada'){
                return response()->json(['error' => $result['Message']], 422);
            }
            return response()->json(['error' => 'Tarjeta invalida, favor verifique.'], 422);
        }
            
        // save payment method
        try{
            $method = auth()->user()->payment_methods()->create([
                'key' => $result['Data'],
                'name' => $request->name,
                'card_brand' => $request->card_brand,
                'card_last_four' => $last_four,
                'auth_code' => $result['Auth'],
                'default' => false,
                'verified' => false
            ]);
        } catch (Exception $e) {
            $this->log->error("Line:".$e->getLine()." ".$e->getMessage()." ".$e->getFile());
            return response()->json(['error' => 'Tarjeta no asignada.'], 422);
        }

        return response()->json([
            'message' => 'Titular persiste.',
            'method_id' => $method->id,
            'auth_code' => $result['Auth']
        ]);
    }

    /**
     * Verify card (external)
     *
     * @param  \App\PaymentMethod $method
     * @param  App\Http\Requests\VerifyCardRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyCard(PaymentMethod $method,VerifyCardRequest $request)
    {
        $apiRequest = new APIRequest();

        $type = 'verify';
        $rtl = env('RTL');
        $default = false;
        if(auth()->user()->payment_methods()->whereDefault(true)->count() === 0){
            $default = true;
        }

        // Verified card
        if($method->auth_code != $request->auth_code){
            return response()->json(['error' => 'Código de autorización invalido.'],422);
        }else if($method->verified){
            return response()->json(['error' => 'Tarjeta ya ha sido verificada.'],422);
        }

        // formatting number
        $replace = str_replace(".", "", $request->amount);
        $final_amount = sprintf("%012d",$replace);

        $soapHeader = '';
        $soapBody = '<VerifyClient xmlns="http://buypass.service.serfinsa.com/">
                        <e>
                            <Rtl>'.$rtl.'</Rtl>
                            <Key>'.$method->key.'</Key>
                            <Amount>'.$final_amount.'</Amount>
                        </e>
                    </VerifyClient>';
        $action = 'http://buypass.service.serfinsa.com/VerifyClient';
        $response = $apiRequest->generateSoapRequest($soapHeader,$soapBody,$action,$type);

        $result = $response['soapBody']['VerifyClientResponse']['VerifyClientResult'];
        if($result['IsPersist'] ==='false'){
            return response()->json(['error' => 'Tarjeta no se pudo verificar.'], 422);
        }
        
        $method->update([
            'default' => $default,
            'verified' => true
        ]);
        
        return response()->json([
            'message' => 'Tarjeta verificada exitosamente.'
        ]);
    }


    /**
     * Set default card.
     *
     * @param  \App\PaymentMethod $method
     * @return \Illuminate\Http\JsonResponse
     */
    public function default(PaymentMethod $method)
    {
        auth()->user()->payment_methods()->update(['default' => false]);
        $method->update(['default' => true]);

        return new PaymentMethodResource($method);
    }

    /**
     * Remove card (external)
     *
     * @param  \App\PaymentMethod $method
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCard(PaymentMethod $method)
    {
        $apiRequest = new APIRequest();
        $type = 'remove';
        $rtl = env('RTL');

        // Verified card
        if(!auth()->user()->payment_methods()->whereId($method->id)->first()){
            return response()->json(['error' => 'Tarjeta no encontrada.'],422);
        }else if(!$method->key){
            return response()->json(['error' => 'Tarjeta no identificada.'],422);
        }

        $soapHeader = '';
        $soapBody = '<DeleteCliente xmlns="http://buypass.service.serfinsa.com/">
                        <e>
                            <Rtl>'.$rtl.'</Rtl>
                            <Key>'.$method->key.'</Key>
                        </e>
                    </DeleteCliente>';
        $action = 'http://buypass.service.serfinsa.com/DeleteCliente';
        $response = $apiRequest->generateSoapRequest($soapHeader,$soapBody,$action,$type);

        $result = $response['soapBody']['DeleteClienteResponse']['DeleteClienteResult'];
        if($result['IsPersist'] ==='false'){
            return $result;
            return response()->json(['error' => 'No se pudo cancelar la tarjeta, favor verifique nuevamente.'], 422);
        }

        $method->delete();
        
        return response()->json([
            'message' => 'Tarjeta cancelada correctamente.'
        ]);
    }

}
