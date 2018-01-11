<?php
/**
 * Created by PhpStorm.
 * User: Avery
 * Date: 5/27/2015
 * Time: 3:40 PM
 */

class Paypal{
    var $api_url = "https://svcs.paypal.com/AdaptivePayments/";
    var $paypal_url = "https://www.paypal.com/webscr?cmd=_ap-payment&paykey=";
    var $paypal_pre = "https://www.paypal.com/webscr?cmd=_ap-preapproval&preapprovalkey=";
    var $headers;
    var $envelope;

    function __construct(){
        $this->headers = array(
        );

        $this->envelope = array(
            "errorLanguage" => "en_US",
            "detailLevel" => "ReturnAll"
        );
    }

    function getPaymentOptions($payKey){
        $packet = array(
            "requestEnvelope" => $this->envelope,
            "payKey" => $payKey
        );

        return $this->_paypalSend($payKey, "GetPaymentOptions");
    }

    function _paypalSend($data, $call){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . $call);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        return json_decode(curl_exec($ch), TRUE);
    }

    function splitPay(){
        $createPacket = array(
            "actionType" => "PAY",
            "currencyCode" => "USD",
            "receiverList" => array(
                "receiver" => array(
                    array(
                        "amount" => "1.00",
                        "email" => 'avery246813579@gmail.com'
                    )
                )
            ),
            "returnUrl" => "http://roflgator.net/finish.php",
            "cancelUrl" => "http://roflgator.net/cancel.php",
            "requestEnvelope" => $this->envelope
        );

        $response =  $this->_paypalSend($createPacket, "Pay");
        $paykey = $response['payKey'];

        $detailsPacket = array(
            "requestEnvelope" => $this->envelope,
            "payKey" => $paykey,
            "receiverOptions" => array(
                array(
                    "receiver" => array("email" => "avery246813579@gmail.com"),
                    "invoiceDate" => array(
                        "item" => array(
                            array(
                                "name" => "product 1",
                                "price" => "1.00",
                                "identifier" => "p1"
                            )
                        )
                    )
                )
            )
        );

        $response2 = $this->_paypalSend($detailsPacket, "SetPaymentOptions");

        $dets = $this->getPaymentOptions($paykey);

        ob_start();
        header("Location: " . $this->paypal_url . $paykey);
    }
}

?>
<?php
$paypal = new Paypal();
$paypal->splitPay();
?>