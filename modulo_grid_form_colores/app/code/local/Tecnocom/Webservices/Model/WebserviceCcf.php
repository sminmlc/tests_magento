<?php

/**
 * Webservices module
 *
 * PHP version 5
 *
 * @codepool Local
 * @category Tecnocom
 * @package Tecnocom_Webservices
 * @module Webservices
 * @copyright 2016 Tecnocom/Aether
 * @license GNU General Public License v3 <http://www.gnu.org/licenses/gpl-3.0.txt>
 * @version SVN:
 */
class Tecnocom_Webservices_Model_WebserviceCcf extends Mage_Core_Model_Abstract
{
    /**
     * Private method that returns proxy configuration for WS
     * 
     * @return array
     */
    private function _getProxy() 
    {
        $proxyArray = array();
        
        $proxyArray["host"] = Mage::getStoreConfig(
            'silk_params/urls_params/host_proxy_dmz', 
            Mage::app()->getStore()
        );
        $proxyArray["port"] = Mage::getStoreConfig(
            'silk_params/urls_params/port_proxy_dmz', 
            Mage::app()->getStore()
        );
        
        return $proxyArray;
    }
    
    /**
     * Private method that returns WSDL configuration for WS
     * 
     * @param string $wsdlMethod
     * @return string
     */
    private function _getWsdl($wsdlMethod, $hostProxy, $hostProxyPort)
    {
        $wsdl = '';
        
        $environment = Mage::getStoreConfig(
            'silk_params/compra_estrella_params/environment', 
            Mage::app()->getStore()
        );
        switch ($environment) {
            case 'tst':
                $wsdlHost = Mage::getStoreConfig(
                    'silk_params/compra_estrella_params/url_tst_environment', 
                    Mage::app()->getStore()
                );
                break;
            case 'PRE':
                $wsdlHost = Mage::getStoreConfig(
                    'silk_params/compra_estrella_params/url_pre_environment', 
                    Mage::app()->getStore()
                );
                break;
            case 'PRO':
                $wsdlHost = Mage::getStoreConfig(
                    'silk_params/compra_estrella_params/url_pro_environment', 
                    Mage::app()->getStore()
                );
                break;
        }

        $wsdl = $wsdlHost.$wsdlMethod;
        
        //Verify and change SOAP URL for TST environment ONLY
        if ($environment == 'tst') {
            $aContext = array(
                'http' => array(
                    'proxy' => 'tcp://'.$hostProxy.':'.$hostProxyPort,
                    'request_fulluri' => true,
                ),
            );
            $cxContext = stream_context_create($aContext);
            
            try {
                $sFile = file_get_contents($wsdl, False, $cxContext);
            
                $xmlDoc = new DOMDocument();
                $xmlDoc->loadXML($sFile);
            
                $soapAddress = $xmlDoc
                    ->getElementsByTagNameNS('http://schemas.xmlsoap.org/wsdl/soap/', 'address')
                    ->item(0);
                $location = $soapAddress
                    ->attributes
                    ->getNamedItem('location')
                    ->value;
            
                $wsdl = $location.'?wsdl';
            } catch (Exception $e) {
                throw $e;
            }
        }
        
        return $wsdl;
    }
    
    /**
     * Preparing data to be sent thru SOAP AltaPedido
     *
     * @param Mage_Sales_Model_Order $order
     * @param Mage_Sales_Model_Customer $customer
     * @return array
     * @throws Exception
     */
    private function _ccfAltaData($order, $customer)
    {
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_WebserviceCcf-->_ccfAltaData($order, $customer) [START]');
        }
        
        $shippingAddress = $order->getShippingAddress();
        $paymentInstance = $order->getPayment()->getMethodInstance();
        $paymentAdddionalInformation = $paymentInstance->getInfoInstance()
                ->getAdditionalInformation();
        
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_WebserviceCcf-->_ccfAltaData($order, $customer) - $paymentAdditionalInformation = ');
            Mage::log(var_export($paymentAdddionalInformation, true));
        }
        
        $dataFormaPago = [];
        $formaPago = '';
        $numeroPersona = '';
        $usuario = '';

        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_WebserviceCcf-->_ccfAltaData($order, $customer) - $paymentInstance->getCode() = ');
            Mage::log(var_export($paymentInstance->getCode(), true));
        }
        
        $paymentCode = $paymentInstance->getCode();
        switch ($paymentInstance->getCode()) {
            case CompraEstrella_BankTransfer_Model_PayBankTransfer::PAYMENT_METHOD_BANKTRANSFER_CODE:
                if (!isset($paymentAdddionalInformation['BankAccountNumber'])) {
                    throw new Exception(
                        $this->__(
                            CompraEstrella_BankTransfer_Model_PayBankTransfer::CHECKOUT_NAME .
                            ' account number not set'
                        )
                    );
                }
                $formaPago = CompraEstrella_BankTransfer_Model_PayBankTransfer::ALTAPEDIDO_FORMAPAGO;
                $numeroPersona = $customer->getData(
                    Silk_Customer_Model_Customer::CUSTOMER_NAME_ATTRIBUTE_00
                );
                $usuario = Mage::getSingleton('customer/session')->getNumeroEmpleado();
                break;
            case Excellenceredsys_Redsys_Model_Payredsys::PAYMENT_METHOD_REDSYS_CODE:
                $formaPago = Excellenceredsys_Redsys_Model_Payredsys::ALTAPEDIDO_FORMAPAGO;
                $numeroPersona = '0';
                $usuario = '000000';
                break;
            default:
                throw new Exception(
                    $this->__(
                        'Exception formaPago in AltaPedido not implemented for ' .
                        $paymentInstance->getCode()
                    )
                );
        }

        /*
         * Tecnocom/Aether: Bank account in traditional mode. IBAN+SWIFT?
         */
        if ($paymentCode == CompraEstrella_BankTransfer_Model_PayBankTransfer::PAYMENT_METHOD_BANKTRANSFER_CODE) {
            $bankNumber = $paymentAdddionalInformation['BankAccountNumber']['EEEE'] .
                $paymentAdddionalInformation['BankAccountNumber']['OOOO'] .
                $paymentAdddionalInformation['BankAccountNumber']['DD'] .
                $paymentAdddionalInformation['BankAccountNumber']['NNNNNNNNNN'];

            $coreVar = explode(
                ',', Mage::getModel('core/variable')
                    ->setStoreId(Mage::app()->getStore()->getId())
                    ->loadByCode('cuentaPromocaixa')
                    ->getValue('html')
            );

            if (in_array($bankNumber, $coreVar)) {
                throw new Exception(Mage::helper('silk_general')->__('Account number not valid'), self::EXCEPTION_00);
            }

            $dataFormaPago['cuentaAbono'] = $bankNumber;
            $dataFormaPago['cuentaCargo'] = $bankNumber;
            $dataFormaPago['cuentaDevolucion'] = $bankNumber;
        } else {
            $bankNumber = '';
        }

        $store = Mage::app()->getStore();
        $taxCalculation = Mage::getModel('tax/calculation');
        $request = $taxCalculation->getRateRequest(null, null, null, $store);
        $listaProductos = [];
        $items = $order->getAllVisibleItems();

        foreach ($items as $item) {
            $product = $item->getProduct();
            $categoryIds = $product->getCategoryIds();
            $category = Mage::getModel('catalog/category')->load(current($categoryIds));
            $taxClassId = $product->getTaxClassId();
            $taxPercent = $taxCalculation->getRate($request->setProductClassId($taxClassId));

            /*
             * modeloNegocio => Falta crear atributo en producto
             */
            $listaProductos[] = [
                'cantidad' => $item->getQtyToInvoice(),
                //'codigoHostProducto' => '',
                //'comision' => '0.0',
                //'comisionNegocio' => '0.0',
                'descripcionFamilia' => $category->getName(),
                'familiaProducto' => current($categoryIds),
                //'idCampanya' => '0',
                'identificadorProducto' => sprintf('%08d', $product->getSku()),
                //'igc' => '0.0',
                //'importeDescuento' => '0.0',
                'impuestoAplicado' => $taxPercent,
                //'marcaProducto' => '',
                'modeloNegocio' => Silk_Sales_Model_Order::MODELO_NEGOCIO,
                'nombreProducto' => $product->getName(),
                'precioFinal' => round($item->getBaseRowTotal(), 2),
                //'subFamilia' => '0'
            ];
        }
        unset($item);

        if (empty($shippingAddress->getData('middlename'))) {
            $externalInputTOApellido1 = $shippingAddress->getData('lastname');
            $externalInputTOApellido2 = ' ';
        } else {
            $externalInputTOApellido1 = $shippingAddress->getData('middlename');
            $externalInputTOApellido2 = $shippingAddress->getData('lastname');
        }

        /*
         * estadoContable => A falta de una contraorden de SILK será una 
         *      constante con valor 1 en todos los pedidos y condiciones.
         * tipoCargo => Siempre será 0, ya que las incondicionales se han
         *      descartado.
         * tipoEnvio => Siempre será 1, puesto que la entrega en oficinas
         *      está descartada (de momento)
         * 
         */
        $externalInputTO = [
            'apellido1' => $externalInputTOApellido1,
            'apellido2' => $externalInputTOApellido2,
            'asumeInteres' => '',
            'codigoPostalEnvio' => $shippingAddress->getData('postcode'),
            //'codigoSia' => '',
            //'comisionApertura' => '0.0',
            //'comisionEstudio' => '0.0',
            'convivenciaIntranet' => 's',
            'cuentaAbono' => $bankNumber,
            'cuentaCargo' => $bankNumber,
            'cuentaDevolucion' => $bankNumber,
            //'dan' => '',
            //'descripcionCanal' => '',
            //'descripcionLineaSia' => '',
            'descripcionTienda' => Mage::app()->getStore()->getName(),
            //'dg' => '',
            'direccionEnvio' => $shippingAddress->getData('street'),
            //'dt' => '',
            'emailUsuario' => $customer->getEmail(),
            'estadoContable' => Silk_Sales_Model_Order::ESTADO_CONTABLE,
            'estadoPedido' => '1',
            'fechaAlta' => date('d/m/Y', strtotime($order->getData('created_at'))),
            'formaPago' => $formaPago,
            //'fraccionamiento' => '0.0',
            //'idCanal' => '',
            'idImpuesto' => '0',
            //'idOficina' => '0',
            //'idOficinaTecleo' => '0',
            'idPedido' => 0, //$order->getIncrementId(),
            'idPedidoMagento' => $order->getIncrementId(),
            'idTienda' => (intval(Mage::app()->getStore()->getGroup()->getId()) === 2) ? 'CLUBCMPRA' : 'BAZAR',
            'listaProductos' => $listaProductos,
            'nif' => $customer->getData(Silk_Customer_Model_Customer::CUSTOMER_NAME_ATTRIBUTE_02),
            'nombreCliente' => $shippingAddress->getData('firstname'),
            'numeroPersona' => $numeroPersona,
            'paramContingencia' => '',
            //'plazo' => '0.0',
            'poblacionEnvio' => $shippingAddress->getData('city'),
            'provinciaEnvio' => $shippingAddress->getData('region'),
            //'tae' => '0.0',
            'tipoCargo' => Silk_Sales_Model_Order::TIPO_CARGO_CONDICIONAL,
            'tipoEnvio' => Silk_Sales_Model_Order::TIPO_ENVIO_DOMICILIO,
            'usuario' => $usuario
        ];
        
        $order->setData('silk_BankAccountNumber', $bankNumber);
        $order->save();

        $array = array('externalInputTO' => $externalInputTO);
        
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_WebserviceCcf-->_ccfAltaData($order, $customer) - $array = ');
            Mage::log(var_export($array, true));
            Mage::log('Tecnocom_Webservices_Model_WebserviceCcf-->_ccfAltaData($order, $customer) [END]');
        }
        
        return $array;
    }
    
    /**
     * Private method to prepare data to CCF update Order
     * 
     * @param Mage_Sales_Model_Order $order
     * @param integer $status
     * @return array
     */
    private function _ccfActualizaData($order, $status) 
    {
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_WebserviceCcf-->_ccfActualizaData($order, $status) [START]');
        }

        $externalInputTO = [
            'costeFinanciacionPromocaixa' => '',
            'dataOpFinan' => '',
            'dsAuthorisationCode' => '',
            'estadoPedido' => $status,
            'idOpFinan' => '',
            'idPedido' => 0, //$order->getIncrementId(),
            'idPedidoMagento' => $order->getIncrementId(),
            'paramContigencia' => '',
        ];
        
        $array = array('externalInputTO' => $externalInputTO);
        
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_WebserviceCcf-->_ccfActualizaData($order, $status) - $array = ');
            Mage::log(var_export($array, true));
            Mage::log('Tecnocom_Webservices_Model_WebserviceCcf-->_ccfActualizaData($order, $status) [END]');
        }

        return $array;
    }
    
    /**
     * Log WS error and force exception if necessary
     * 
     * @param string $message
     * @param array $exceptionData
     * @param boolean $forceHttpError
     * @param boolean $textFileLog
     * @return boolean
     * @throws Exception
     */
    private function _logError($message = '', $exceptionData, $textFileLog, $forceHttpError)
    {
        $date = new DateTime('now', new DateTimeZone('Europe/Madrid'));
        $dateFormated = date_format($date, 'Y-m-d H:i:s');
        
        if (!empty($message)) {
            $errorMessage = Mage::helper('tecnocom_webservices')->__($message);
        } else {
            $errorMessage = Mage::helper('tecnocom_webservices')->__(
                'Fatal error. The Order is cancelled. Please, try again later.'
            );
        }
        
        Mage::getSingleton('checkout/session')->addError($errorMessage);
        
        if ($textFileLog) {
            Mage::log(
                Mage::helper('tecnocom_webservices')->__(
                    '%s Error in CCF WS. ErrorCode = %s ErrorString = %s', 
                    $dateFormated,
                    $exceptionData['id_error'],
                    $exceptionData['desc_error']
                ), Zend_Log::INFO, 'webservices.log'
            );
        }
        
        $query = 'INSERT INTO tecnocom_webservices_log_error '.
            '(id, id_error, priority, desc_error, date, increment_id, '.
            'trace_input, trace_output, others, ws_method, paid, '.
            'transaction_code, customer, timestamp) '.
            'VALUES ('.
            ':id, :id_error, :priority, :desc_error, :date, :increment_id, '.
            ':trace_input, :trace_output, :others, :ws_method, :paid, '.
            ':transaction_code, :customer, :timestamp);';
        
        $binds = array(
            'id' => NULL,
            'id_error' => $exceptionData['id_error'],
            'priority' => $exceptionData['priority'],
            'desc_error' => $exceptionData['desc_error'],
            'date' => $dateFormated,
            'increment_id' => $exceptionData['increment_id'],
            'trace_input' => $exceptionData['trace_input'],
            'trace_output' => $exceptionData['trace_output'],
            'others' => $exceptionData['others'],
            'ws_method' => $exceptionData['ws_method'],
            'paid' => $exceptionData['paid'],
            'transaction_code' => $exceptionData['transaction_code'],
            'customer' => $exceptionData['customer'],
            'timestamp' => NULL,
        );
        
        $dbConnection = Mage::getModel('core/resource')->getConnection('core_write');
        try {
            $result = $dbConnection->query($query, $binds);
        } catch(Exception $e) {
            $dbConnection->closeConnection();
            Mage::logException($e);
            throw $e;
        }
        $dbConnection->closeConnection();
        
        if ($forceHttpError) {
            $result = array();
            $result['error'] = true;
            $result['success'] = false;
            $result['error_messages'] = $errorMessage;
            Mage::app()->getResponse()
                ->clearHeaders()
                ->setHeader('HTTP/1.1', '403 Forbidden')
                ->setBody(Mage::helper('core')->jsonEncode($result))
                ->sendResponse();
        }
        
        return true;
    }

    /**
     * Connects to Absis WS to create Magento's Order in CCF
     *
     * @param Mage_Sales_Model_Order $order
     * @return boolean
     */
    public function ccfAlta($order)
    {
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_WebserviceCcf-->ccfAlta($order) [START]');
        }
        
        $result = false;
        $response = null;
        
        $hostProxyDmz = $this->_getProxy()["host"];
        $portProxyDmz = $this->_getProxy()["port"];
        
        $wsdl = Mage::getStoreConfig(
            'silk_params/compra_estrella_params/alta_pedido', 
            Mage::app()->getStore()
        );
        
        $customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
        
        try {
            $host = $this->_getWsdl($wsdl, $hostProxyDmz, $portProxyDmz);
            
            $optionsWsdl = array(
                'proxy_host' => $hostProxyDmz,
                'proxy_port' => $portProxyDmz,
                'cache_wsdl' => WSDL_CACHE_NONE
            );

            
            $array = $this->_ccfAltaData($order, $customer);
            
            try {
                $client = new SoapClient($host, $optionsWsdl);
                try {
                    $response = $client->AltaPedido($array);
                    
                    if (Mage::getIsDeveloperMode()) {
                        Mage::log('Tecnocom_Webservices_Model_WebserviceCcf-->ccfAlta($order) - $response =');
                        Mage::log(var_export($response, TRUE));
                    }

                    if (isset($response->return)) {
                        $result = $response->return;
                        if (in_array($result->codRespuesta, array('OK', 'OK_000', 'OK_001'))) {
                            $date = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                            $dateFormat = date_format($date, 'Y-m-d H:i:s');
                            Mage::log(
                                Mage::helper('tecnocom_webservices')->__(
                                    '%s Saved Order to CCF WS for Order #%s (ID = %s)', 
                                    $dateFormat,
                                    $order->getIncrementId(),
                                    $order->getId()
                                ), Zend_Log::INFO, 'webservices.log'
                            );
                            Mage::log(
                                Mage::helper('tecnocom_webservices')->__(
                                    '- CCF WS Result Code = %s', var_export($result->codRespuesta, true)
                                ), Zend_Log::INFO, 'webservices.log'
                            );
                        } elseif (in_array($result->codRespuesta, array('ERR_028'))) {
                            //No available stock
                            $date = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                            $dateFormat = date_format($date, 'Y-m-d H:i:s');
                            Mage::log(
                                Mage::helper('tecnocom_webservices')->__(
                                    '%s Error creating Order in CCF WS for Order #%s (ID = %s). No available stock', 
                                    $dateFormat,
                                    $order->getIncrementId(),
                                    $order->getId()
                                ), Zend_Log::INFO, 'webservices.log'
                            );
                            Mage::log(
                                Mage::helper('tecnocom_webservices')->__(
                                    '- CCF WS Result Code = %s', var_export($result->codRespuesta, true)
                                ), Zend_Log::INFO, 'webservices.log'
                            );

                            //Error in WS AltaPedido --> Cancel Order
                            $order->setState('canceled', 'canceled');
                            $order->save();

                            $customerData = $customer->getMiddlename()." ".
                                $customer->getLastname().", ".
                                $customer->getFirstname();

                            $exceptionData = array(
                                "id_error" => $result->codRespuesta,
                                "priority" => "medio",
                                "desc_error" => $result->textoRespuesta,
                                "increment_id" => $order->getIncrementId(),
                                "trace_input" => var_export($array, true),
                                "trace_output" => var_export($response, true),
                                "others" => NULL,
                                "ws_method" => "AltaPedido",
                                "paid" => 0,
                                "transaction_code" => NULL,
                                "customer" => $customerData
                            );
                            
                            $message = $result->codRespuesta.': No available stock. The Order is cancelled. Please, try again later.';
                            $this->_logError($message, $exceptionData, false, true);
                        } else {
                            //$result->codRespuesta != OK | OK_000 | OK_001 | ERR_028
                            $date = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                            $dateFormat = date_format($date, 'Y-m-d H:i:s');
                            Mage::log(
                                Mage::helper('tecnocom_webservices')->__(
                                    '%s Error creating Order in CCF WS for Order #%s (ID = %s)', 
                                    $dateFormat,
                                    $order->getIncrementId(),
                                    $order->getId()
                                ), Zend_Log::INFO, 'webservices.log'
                            );
                            Mage::log(
                                Mage::helper('tecnocom_webservices')->__(
                                    '- CCF WS Result Code = %s', var_export($result->codRespuesta, true)
                                ), Zend_Log::INFO, 'webservices.log'
                            );

                            //Error in WS AltaPedido --> Cancel Order
                            $order->setState('canceled', 'canceled');
                            $order->save();

                            $customerData = $customer->getMiddlename()." ".
                                $customer->getLastname().", ".
                                $customer->getFirstname();

                            $exceptionData = array(
                                "id_error" => $result->codRespuesta,
                                "priority" => "medio",
                                "desc_error" => $result->textoRespuesta,
                                "increment_id" => $order->getIncrementId(),
                                "trace_input" => var_export($array, true),
                                "trace_output" => var_export($response, true),
                                "others" => NULL,
                                "ws_method" => "AltaPedido",
                                "paid" => 0,
                                "transaction_code" => NULL,
                                "customer" => $customerData
                            );

                            $message = $result->codRespuesta.': Error creating Order. The Order is cancelled. Please, try again later.';
                            $this->_logError($message, $exceptionData, false, true);
                        }
                    } else {
                        //$response = NULL | empty
                        $date = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                        $dateFormat = date_format($date, 'Y-m-d H:i:s');
                        Mage::log(
                            Mage::helper('tecnocom_webservices')->__(
                                '%s Error creating Order in CCF WS for Order #%s (ID = %s)', 
                                $dateFormat,
                                $order->getIncrementId(),
                                $order->getId()
                            ), Zend_Log::INFO, 'webservices.log'
                        );
                        Mage::log(
                            Mage::helper('tecnocom_webservices')->__('- CCF WS Result Code = NULL'), 
                            Zend_Log::INFO, 
                            'webservices.log'
                        );

                        //Error in WS AltaPedido --> Cancel Order
                        $order->setState('canceled', 'canceled');
                        $order->save();

                        $customerData = $customer->getMiddlename()." ".
                            $customer->getLastname().", ".
                            $customer->getFirstname();

                        $exceptionData = array(
                            "id_error" => "<no_code>",
                            "priority" => "urgente",
                            "desc_error" => "<no_message>",
                            "increment_id" => $order->getIncrementId(),
                            "trace_input" => var_export($array, true),
                            "trace_output" => var_export($response, true),
                            "others" => NULL,
                            "ws_method" => "AltaPedido",
                            "paid" => 0,
                            "transaction_code" => NULL,
                            "customer" => $customerData
                        );

                        $message = 'NULL: Error creating Order. The Order is cancelled. Please, try again later.';
                        $this->_logError($message, $exceptionData, false, true);
                    }
                } catch (SoapFault $fault) {
                    //catch $client->altaPedido(... )
                    //Error in WS AltaPedido --> Cancel Order
                    $order->setState('canceled', 'canceled');
                    $order->save();

                    $customerData = $customer->getMiddlename()." ".
                        $customer->getLastname().", ".
                        $customer->getFirstname();

                    $exceptionData = array(
                        "id_error" => $fault->faultcode,
                        "priority" => "urgente",
                        "desc_error" => $fault->faultstring,
                        "increment_id" => $order->getIncrementId(),
                        "trace_input" => var_export($array, true),
                        "trace_output" => var_export($response, true),
                        "others" => NULL,
                        "ws_method" => "AltaPedido",
                        "paid" => 0,
                        "transaction_code" => NULL,
                        "customer" => $customerData
                    );

                    $this->_logError(NULL, $exceptionData, true, true);
                }
            } catch (Exception $e) {
                //catch new SoapClient(... )
                $order->setState('canceled', 'canceled');
                $order->save();

                $customerData = $customer->getMiddlename()." ".
                    $customer->getLastname().", ".
                    $customer->getFirstname();

                $exceptionData = array(
                    "id_error" => $e->getCode(),
                    "priority" => "urgente",
                    "desc_error" => $e->getMessage(),
                    "increment_id" => $order->getIncrementId(),
                    "trace_input" => var_export($array, true),
                    "trace_output" => var_export($response, true),
                    "others" => NULL,
                    "ws_method" => "AltaPedido",
                    "paid" => 0,
                    "transaction_code" => NULL,
                    "customer" => $customerData
                );

                $this->_logError(NULL, $exceptionData, true, true);
            }
        } catch (Exception $e) {
            //catch $this->_getWsdl(... )
            $order->setState('canceled', 'canceled');
            $order->save();
            
            $customerData = $customer->getMiddlename()." ".
                $customer->getLastname().", ".
                $customer->getFirstname();
            
            $exceptionData = array(
                "id_error" => $e->getCode(),
                "priority" => "urgente",
                "desc_error" => $e->getMessage(),
                "increment_id" => $order->getIncrementId(),
                "trace_input" => NULL,
                "trace_output" => NULL,
                "others" => NULL,
                "ws_method" => "AltaPedido",
                "paid" => 0,
                "transaction_code" => NULL,
                "customer" => $customerData
            );
            
            $this->_logError(NULL, $exceptionData, true, true);
        }
        
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_WebserviceCcf-->ccfAlta($order) [END]');
        }

        return $response;
    }
    
    /**
     * Update Order status to the exported Order in WS CCF
     * 
     * @param Mage_Model_Saler_Order $order
     * @param String $status
     * @return type
     */
    public function ccfActualiza($order, $status) 
    {
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_WebserviceCcf-->ccfActualiza($order, $status) [START]');
        }
        
        $result = false;
        
        $hostProxyDmz = $this->_getProxy()["host"];
        $portProxyDmz = $this->_getProxy()["port"];
        
        $wsdl = Mage::getStoreConfig(
            'silk_params/compra_estrella_params/actualiz_estad_pedi', 
            Mage::app()->getStore()
        );
        
        $customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
        
        try {
            $host = $this->_getWsdl($wsdl, $hostProxyDmz, $portProxyDmz);
            
            $optionsWsdl = array(
                'proxy_host' => $hostProxyDmz,
                'proxy_port' => $portProxyDmz,
                'cache_wsdl' => WSDL_CACHE_NONE
            );

            $response = null;
            $array = $this->_ccfActualizaData($order, $status);

            try {
                $client = new SoapClient($host, $optionsWsdl);

                try {
                    $response = $client->ActulizEstadPedi($array);
                    
                    if (Mage::getIsDeveloperMode()) {
                        Mage::log('Tecnocom_Webservices_Model_WebserviceCcf-->ccfActualiza($order, $status) - $response =');
                        Mage::log(var_export($response, TRUE));
                    }

                    if (isset($response->return)) {
                        $result = $response->return;
                        if (in_array($result->codRespuesta, array('OK', 'OK_000', 'OK_001'))) {
                            $date = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                            $dateFormat = date_format($date, 'Y-m-d H:i:s');
                            Mage::log(
                                Mage::helper('tecnocom_webservices')->__(
                                    '%s Updated Order in CCF WS for Order #%s (ID = %s) with status = %s', 
                                    $dateFormat,
                                    $order->getIncrementId(),
                                    $order->getId(),
                                    $status
                                ), Zend_Log::INFO, 'webservices.log'
                            );
                            Mage::log(
                                Mage::helper('tecnocom_webservices')->__(
                                    '- CCF WS Result Code = %s', var_export($result->codRespuesta, true)
                                ), Zend_Log::INFO, 'webservices.log'
                            );
                        } else {
                            //$result->codRespuesta != OK | OK_000 | OK_001
                            $date = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                            $dateFormat = date_format($date, 'Y-m-d H:i:s');
                            Mage::log(
                                Mage::helper('tecnocom_webservices')->__(
                                    '%s Error updating Order in CCF WS for Order #%s (ID = %s)', 
                                    $dateFormat,
                                    $order->getIncrementId(),
                                    $order->getId()
                                ), Zend_Log::INFO, 'webservices.log'
                            );
                            Mage::log(
                                Mage::helper('tecnocom_webservices')->__(
                                    '- CCF WS Result Code = %s', var_export($result->codRespuesta, true)
                                ), Zend_Log::INFO, 'webservices.log'
                            );

                            $customerData = $customer->getMiddlename()." ".
                                $customer->getLastname().", ".
                                $customer->getFirstname();

                            $exceptionData = array(
                                "id_error" => $result->codRespuesta,
                                "priority" => "medio",
                                "desc_error" => $result->textoRespuesta,
                                "increment_id" => $order->getIncrementId(),
                                "trace_input" => var_export($array, true),
                                "trace_output" => var_export($response, true),
                                "others" => NULL,
                                "ws_method" => "ActulizEstadPedi",
                                "paid" => 1,
                                "transaction_code" => NULL,
                                "customer" => $customerData
                            );

                            $message = $result->codRespuesta.': Error updating Order. The Order is processed.';
                            $this->_logError($message, $exceptionData, false, false);
                        }
                    } else {
                        //$response = NULL | empty
                        $date = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                        $dateFormat = date_format($date, 'Y-m-d H:i:s');
                        Mage::log(
                            Mage::helper('tecnocom_webservices')->__(
                                '%s Error updating Order in CCF WS for Order #%s (ID = %s)', 
                                $dateFormat,
                                $order->getIncrementId(),
                                $order->getId()
                            ), Zend_Log::INFO, 'webservices.log'
                        );
                        Mage::log(
                            Mage::helper('tecnocom_webservices')->__('- CCF WS Result Code = NULL'), 
                            Zend_Log::INFO, 
                            'webservices.log'
                        );

                        $customerData = $customer->getMiddlename()." ".
                            $customer->getLastname().", ".
                            $customer->getFirstname();

                        $exceptionData = array(
                            "id_error" => "<no_code>",
                            "priority" => "urgente",
                            "desc_error" => "<no_message>",
                            "increment_id" => $order->getIncrementId(),
                            "trace_input" => var_export($array, true),
                            "trace_output" => var_export($response, true),
                            "others" => NULL,
                            "ws_method" => "ActulizEstadPedi",
                            "paid" => 1,
                            "transaction_code" => NULL,
                            "customer" => $customerData
                        );

                        $message = 'NULL: Error updating Order. The Order is processed.';
                        $this->_logError($message, $exceptionData, false, false);
                    }
                } catch (SoapFault $fault) {
                    //catch $client->actulizEstadPedi(... )
                    //Error in WS ActulizEstadPedi

                    $customerData = $customer->getMiddlename()." ".
                        $customer->getLastname().", ".
                        $customer->getFirstname();

                    $exceptionData = array(
                        "id_error" => $fault->faultcode,
                        "priority" => "urgente",
                        "desc_error" => $fault->faultstring,
                        "increment_id" => $order->getIncrementId(),
                        "trace_input" => var_export($array, true),
                        "trace_output" => var_export($response, true),
                        "others" => NULL,
                        "ws_method" => "ActulizEstadPedi",
                        "paid" => 1,
                        "transaction_code" => NULL,
                        "customer" => $customerData
                    );

                    $this->_logError(NULL, $exceptionData, true, false);
                }
            } catch (Exception $e) {
                //catch new SoapClient(... )

                $customerData = $customer->getMiddlename()." ".
                    $customer->getLastname().", ".
                    $customer->getFirstname();

                $exceptionData = array(
                    "id_error" => $e->getCode(),
                    "priority" => "urgente",
                    "desc_error" => $e->getMessage(),
                    "increment_id" => $order->getIncrementId(),
                    "trace_input" => var_export($array, true),
                    "trace_output" => var_export($response, true),
                    "others" => NULL,
                    "ws_method" => "ActulizEstadPedi",
                    "paid" => 1,
                    "transaction_code" => NULL,
                    "customer" => $customerData
                );

                $this->_logError(NULL, $exceptionData, true, false);
            } 
        } catch (Exception $e) {
            //catch $this->_getWsdl(... )
            
            $customerData = $customer->getMiddlename()." ".
                $customer->getLastname().", ".
                $customer->getFirstname();
            
            $exceptionData = array(
                "id_error" => $e->getCode(),
                "priority" => "urgente",
                "desc_error" => $e->getMessage(),
                "increment_id" => $order->getIncrementId(),
                "trace_input" => NULL,
                "trace_output" => NULL,
                "others" => NULL,
                "ws_method" => "ActulizEstadPedi",
                "paid" => 1,
                "transaction_code" => NULL,
                "customer" => $customerData
            );
            
            $this->_logError(NULL, $exceptionData, true, false);
        }
        
        if (Mage::getIsDeveloperMode()) {
            Mage::log('Tecnocom_Webservices_Model_WebserviceCcf-->ccfActualiza($order) [END]');
        }

        return $response;
    }
}
