<?php 

/**
* Payment platform to colombia (PayU LATAM)
* Developed by David León
* Web Developer: jdevweb.com
*/
class PaymentPAUY extends Secure
{
	const API_KEY = ""; //Ingrese aquí su propio apiKey.
	const API_LOGIN = ""; //Ingrese aquí su propio apiLogin.
	const MERCHANT_ID = ""; //Ingrese aquí su Id de Comercio.
	const LANG = SupportedLanguages::ES; //Seleccione el idioma.
	const TEST = true; //Dejarlo True cuando sean pruebas.
	const ID_ACCOUNT = "512321";

	const PAYMENT_PAGE = "https://api.payulatam.com/payments-api/4.0/service.cgi"; // URL de Pagos
	const CONSULT_PAGE = "https://api.payulatam.com/reports-api/4.0/service.cgi"; // URL de Consultas
	const PAYMENT_SUBSCRIPTIONS_PAGE = "https://api.payulatam.com/payments-api/rest/v4.3/"; // URL de Suscripciones para Pagos Recurrentes

	public $error;
	private $_DEVICE_SESSION_ID;
	private $_IP_ADDRESS;
	private $_PAYER_COOKIE;
	private $_USER_AGENT;


	function __construct()
	{
		require_once URL_BASE.'class/PAYU/payu-php-sdk-4.5.6/lib/PayU.php';
		PayU::$apiKey = API_KEY; 
		PayU::$apiLogin = API_LOGIN;
		PayU::$merchantId = MERCHANT_ID;
		PayU::$language = SupportedLanguages::ES;
		PayU::$isTest = false;		
		Environment::setPaymentsCustomUrl(PAYMENT_PAGE);		
		Environment::setReportsCustomUrl(CONSULT_PAGE);		
		Environment::setSubscriptionsCustomUrl(PAYMENT_SUBSCRIPTIONS_PAGE);
		$this->getSessionBuyerData();
	}


	public function creditCardPay($data)
	{
		/*

			$data_buyer = [
				'buyer_name' => 'NAME',
				'buyer_email' => 'EMAIL',
				'buyer_phone' => 'BUYER_CONTACT_PHONE',
				'buyer_name' => 'NAME',
			];

			$data_payer = [
				
			];

			$data_credit_card = [
				
			];

		*/

		if (!$this->validateCreditCArt($data->card,$data->number_card)) {
			$error = 'Número de tarjeta de crédito inválido';
			return false;
		};

		$parameters = array(
			//Ingrese aquí el identificador de la cuenta.
			PayUParameters::ACCOUNT_ID => ID_ACCOUNT,
			//Ingrese aquí el código de referencia.
			PayUParameters::REFERENCE_CODE => $data->reference,
			//Ingrese aquí la descripción.
			PayUParameters::DESCRIPTION => $data->description,
			
			// -- Valores --
			//Ingrese aquí el valor.        
			PayUParameters::VALUE => $data->value,
			//Ingrese aquí la moneda.
			PayUParameters::CURRENCY => "COP",
			
			// -- Comprador 
			//Ingrese aquí el nombre del comprador.
			PayUParameters::BUYER_NAME => $data->buyer_name,
			//Ingrese aquí el email del comprador.
			PayUParameters::BUYER_EMAIL => $data->buyer_mail,
			//Ingrese aquí el teléfono de contacto del comprador.
			PayUParameters::BUYER_CONTACT_PHONE => $data->buyer_phone,
			//Ingrese aquí el documento de contacto del comprador.
			PayUParameters::BUYER_DNI => $data->buyer_cc,
			//Ingrese aquí la dirección del comprador.
			PayUParameters::BUYER_STREET => $data->buyer_address1,
			PayUParameters::BUYER_STREET_2 => $data->buyer_address2,
			PayUParameters::BUYER_CITY => $data->buyer_city,
			PayUParameters::BUYER_STATE => $data->buyer_dep,
			PayUParameters::BUYER_COUNTRY => "CO",
			PayUParameters::BUYER_POSTAL_CODE => "000000",
			PayUParameters::BUYER_PHONE => $data->buyer_phone,
			
			// -- pagador --
			//Ingrese aquí el nombre del pagador.
			PayUParameters::PAYER_NAME => $data->payer_name,
			//Ingrese aquí el email del pagador.
			PayUParameters::PAYER_EMAIL => $data->payer_mail,
			//Ingrese aquí el teléfono de contacto del pagador.
			PayUParameters::PAYER_CONTACT_PHONE => $data->payer_phone,
			//Ingrese aquí el documento de contacto del pagador.
			PayUParameters::PAYER_DNI => $data->payer_cc,
			//Ingrese aquí la dirección del pagador.
			PayUParameters::PAYER_STREET => $data->payer_address1,
			PayUParameters::PAYER_STREET_2 => $data->payer_address2,
			PayUParameters::PAYER_CITY => $data->payer_city,
			PayUParameters::PAYER_STATE => $data->payer_dep,
			PayUParameters::PAYER_COUNTRY => "CO",
			PayUParameters::PAYER_POSTAL_CODE => "000000",
			PayUParameters::PAYER_PHONE => $data->payer_phone,
			
			// -- Datos de la tarjeta de crédito -- 
			//Ingrese aquí el número de la tarjeta de crédito
			PayUParameters::CREDIT_CARD_NUMBER => $data->number_card,
			//Ingrese aquí la fecha de vencimiento de la tarjeta de crédito
			$month = $data->card_month;
			$year = $data->card_year;
			$date_card = $year.'/'.$month;
			PayUParameters::CREDIT_CARD_EXPIRATION_DATE => $date_card,
			//Ingrese aquí el código de seguridad de la tarjeta de crédito
			PayUParameters::CREDIT_CARD_SECURITY_CODE=> $data->card_security_code,
			//Ingrese aquí el nombre de la tarjeta de crédito
			//VISA||MASTERCARD||AMEX||DINERS
			PayUParameters::PAYMENT_METHOD => $data->card,
			
			//Ingrese aquí el número de cuotas.
			PayUParameters::INSTALLMENTS_NUMBER => $data->card_installments,
			//Ingrese aquí el nombre del pais.
			PayUParameters::COUNTRY => PayUCountries::CO,
			
			
			PayUParameters::DEVICE_SESSION_ID => $this->_DEVICE_SESSION_ID, //Session id del device.	
			PayUParameters::IP_ADDRESS => $this->_IP_ADDRESS,//IP del pagadador		
			PayUParameters::PAYER_COOKIE => $this->_PAYER_COOKIE, //Cookie de la sesión actual.		        
			PayUParameters::USER_AGENT => $_SERVER['HTTP_USER_AGENT'] //Cookie de la sesión actual.
		);
			
		$response = PayUPayments::doAuthorizationAndCapture($parameters);

		if ($response) {
			$response->transactionResponse->orderId;
			$response->transactionResponse->transactionId;
			$response->transactionResponse->state;
			if ($response->transactionResponse->state == "PENDING") {
				$response->transactionResponse->pendingReason;	
			}
			$response->transactionResponse->paymentNetworkResponseCode;
			$response->transactionResponse->paymentNetworkResponseErrorMessage;
			$response->transactionResponse->trazabilityCode;
			$response->transactionResponse->responseCode;
			$response->transactionResponse->responseMessage;   	
		}

		return false;
	}

	private function getSessionBuyerData()
	{	
		$this->_DEVICE_SESSION_ID = $_SERVER['UNIQUE_ID'];
		$this->_IP_ADDRESS = Secure::getUserIP();
		$this->_PAYER_COOKIE = $_COOKIE['PHPSESSID'];
		$this->_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	}

	public function validateCreditCArt($franquicia,$credit_cart_number)
	{	
		$lenght = lenght($credit_cart_number);
		if ($franquicia = 'VISA') {
			
		}
		if ($franquicia = 'MASTERCARD') {
			
		}
		if ($franquicia = 'AMEX') {
			
		}
		if ($franquicia = 'DINERS') {
			
		}
	}

	public function cash()
	{
		String reference = "payment_test_00000001";
		String value= "10000";
		Map<String, String> parameters = new HashMap<String, String>();

		//Ingrese aquí el identificador de la cuenta.
		parameters.put(PayU.PARAMETERS.ACCOUNT_ID, "512321");
		//Ingrese aquí el código de referencia.
		parameters.put(PayU.PARAMETERS.REFERENCE_CODE, ""+reference);
		//Ingrese aquí la descripción.
		parameters.put(PayU.PARAMETERS.DESCRIPTION, "payment test");
		//Ingrese aquí el idima de la orden.
		parameters.put(PayU.PARAMETERS.LANGUAGE, "Language.es");

		// -- Valores --
		//Ingrese aquí el valor.
		parameters.put(PayU.PARAMETERS.VALUE, ""+value);	
		//Ingrese aquí la moneda.
		parameters.put(PayU.PARAMETERS.CURRENCY, ""+Currency.COP.name());

		//Ingrese aquí el email del comprador.
		parameters.put(PayU.PARAMETERS.BUYER_EMAIL, "buyer_test@test.com");

		//Ingrese aquí el nombre del pagador.
		parameters.put(PayU.PARAMETERS.PAYER_NAME, "First name and second payer name");
			
		//Ingrese aquí el nombre del medio de pago en efectivo
		parameters.put(PayU.PARAMETERS.PAYMENT_METHOD, "BALOTO");

		//Ingrese aquí el nombre del pais.
		parameters.put(PayU.PARAMETERS.COUNTRY, PaymentCountry.CO.name());

		//Ingrese aquí la fecha de expiración. 
		parameters.put(PayU.PARAMETERS.EXPIRATION_DATE,"2014-05-20T00:00:00");

		//IP del pagadador
		parameters.put(PayU.PARAMETERS.IP_ADDRESS, "127.0.0.1");

		//Solicitud de autorización y captura
		TransactionResponse response = PayUPayments.doAuthorizationAndCapture(parameters);

		//Respuesta
		if(response != null){
			response.getOrderId();
			response.getTransactionId();
			response.getState();
			if(response.getState().equals(TransactionState.PENDING)){
				response.getPendingReason();	
				Map extraParameters = response.getExtraParameters();
				
				//obtener la url del comprobante de pago
				String url=(String)extraParameters.get("URL_PAYMENT_RECEIPT_HTML");
			}
			response.getPaymentNetworkResponseCode();
			response.getPaymentNetworkResponseErrorMessage();
			response.getTrazabilityCode();
			response.getResponseCode();
			response.getResponseMessage();
		}
	}



}