<?php
namespace Stelo\Subacquirer;

class Subacquirer
{

    const PRODUCTION = 'https://api.stelo.com.br';

    const SANDBOX = 'https://apic1.hml.stelo.com.br';

    private $steloAccount;

    private $environment;

    public function __construct(SteloAccount $steloAccount, $environment = Subacquirer::PRODUCTION)
    {
        $this->steloAccount = $steloAccount;
        $this->environment = $environment;
    }

    /**
     * After the customer make the purchase steps of the store, choose Stelo
     * payment method and click in “Checkout”, the store will carry out the
     * request by sending the data
     *
     * @param Transaction $transaction            
     * @return Transaction
     * @throws SteloException
     */
    public function createTransaction(Transaction $transaction)
    {
        $url = $this->environment . '/ec/V1/subacquirer/transactions/';
        
        $entity = json_encode($transaction);
        
        $response = $this->sendRequest("POST", $url, $entity);
        
        $orderData = $transaction->getOrder();
        
        $orderData->setOrderId($response->orderData->orderId)
            ->setNsu($response->orderData->nsu)
            ->setTid($response->orderData->tid);
        
        if (isset($response->bankSlipURL) && !empty($response->bankSlipURL)) {
            $transaction->setBankSlipURL($response->bankSlipURL);
        }
        
        return $transaction;
    }

    /**
     * After the customer make the purchase steps of the store, choose Stelo
     * payment method and click in “Checkout”, the store will carry out the
     * request by sending the data
     *
     * @param Order $order            
     * @param Payment $payment            
     * @param Customer $customer            
     * @return Transaction
     *
     * @throws SteloException
     */
    public function createNewTransaction(Order $order, Payment $payment, Customer $customer)
    {
        return $this->createTransaction(new Transaction($order, $payment, $customer));
    }

    /**
     * After creating a transaction and the buyer give up the purchase, Stelo
     * allows to cancel the request.
     * To do this simply send a REQUEST informing
     * the orderId.
     *
     * @param string $orderId            
     * @throws SteloException
     */
    public function cancellTransaction($orderId)
    {
        $url = $this->environment + '/ec/V1/orders/transactions/' + $orderId;
        
        $this->sendRequest("DELETE", $url);
    }

    /**
     * Upon receiving query the status of a transaction, Stelo will return the
     * statusCode and statusMessage parameters.
     *
     * @param string $orderId            
     * @return The requested Order
     * @throws SteloException
     */
    public function getOrder($orderId)
    {
        $url = $this->environment . '/ec/V1/orders/transactions/' . $orderId;
        
        $response = $this->sendRequest("GET", $url);
        
        $order = (new Order($orderId))->setAmount($response->amount)
            ->setFreight($response->freight)
            ->setSteloId($response->steloId)
            ->setInstallment($response->installment)
            ->setAutorizationId($response->autorizationId)
            ->setNsu($response->nsu)
            ->setTid($response->tid)
            ->setSteloStatus(new Status($response->steloStatus->statusCode, $response->steloStatus->statusMessage));
        
        return $order;
    }

    private function sendRequest($method, $url, $entity = null)
    {
        $credentials = base64_encode($this->steloAccount->getClientId() . ":" . $this->steloAccount->getClientSecret());
        $exception = null;
        
        $curl = curl_init($url);
        
        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        
        switch ($method) {
            case 'GET':
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                break;
            default:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        }
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
            'User-Agent: Subacquirer-SDK/1.0',
            'Authorization: Basic ' . $credentials
        ]);
        
        if ($entity !== null) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $entity);
        }
        
        $response = json_decode(curl_exec($curl));
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        if ($statusCode >= 400) {
            $steloError = new SteloError($response->errorCode ?: $statusCode, $response->errorMessage ?: '');
            
            if (is_object($response->detail) && is_array($response->detail->message)) {
                foreach ($response->detail->message as $message) {
                    $steloError->addDetail($message);
                }
            } else 
                if (isset($response->detail)) {
                    $steloError->addDetail($response->detail);
                }
            
            $exception = new SteloException($response->errorMessage ?: '');
            $exception->setSteloError($steloError);
        }
        
        if (curl_errno($curl)) {
            $exception = new \Exception('Curl error: ' . curl_error($curl));
        }
        
        curl_close($curl);
        
        if ($exception !== null) {
            throw $exception;
        }
        
        return $response;
    }
}