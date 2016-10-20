<?php
namespace Stelo\Subacquirer;

class Subacquirer
{
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
        $url = '/ec/V1/subacquirer/transactions/';
        
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
        $url = '/ec/V1/orders/transactions/' . $orderId;
        
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
        $url = '/ec/V1/orders/transactions/' . $orderId;
        
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

    private function sendRequest($method, $url, $entity = null) {
        $credentials = base64_encode(
            ApiConfiguration::getInstance()->getClientId() . ":" . ApiConfiguration::getInstance()->getClientSecret()
        );

        $request = new Request([
            'url'     => $url,
            'method'  => $method,
            'headers' => [
                'Accept: application/json',
                'Content-Type: application/json',
                'User-Agent: Subacquirer-SDK/1.0',
                'Authorization: Basic ' . $credentials
            ],
            'post_fields' => $entity
        ]);

        return $request->send();
    }
}