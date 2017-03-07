# Subacquirer-PHP

SDK Subacquirer PHP

## Utilizando o SDK

Após o cliente efetuar os passos de compra da loja, escolher o meio de pagamento Stelo e clicar em “Finalizar Compra”, a loja realizará a seguinte requisição com o SDK:

### Criando um pagamento

```php
// ...
$bankSlip = true;

// Configure as credenciais da API
$clientId = 'SEU CLIENT ID';
$clientSecret = 'SEU CLIENT SECRET';

$steloAccount = new SteloAccount($clientId, $clientSecret);

// Crie uma instância de Subacquirer e defina as credenciais e o ambiente
$subacquirer = new Subacquirer($steloAccount, Subacquirer::SANDBOX);

// Crie a instância de Order, definindo o número do pedido e o código de segurança
$order = (new Order('100000005'))->setSecureCode('978455809540');

// Crie a instância de Payment, definindo os dados do pagamento
$payment = (new Payment())->setAmount(180)
                          ->setFreight(45)
                          ->setCurrency('BRL')
                          ->addNewProduct('Coalesce: Functioning On Impatience T-Shirt', 180, 1, '001');

if ($bankSlip) {
    $payment->setPaymentType(Payment::TYPE_BANK_SLIP);
} else {
    $payment->setPaymentType(Payment::TYPE_CREDIT)
            ->setCardData('TOKEN DO CARTÃO')
            ->setInstallment(1);
}

// Crie a instância de Customer com os dados do cliente
$customer = (new Customer())->setIdentity('38292728805')
                            ->setName('Teste integração')
                            ->setEmail('teste@teste.com.br')
                            ->setBirthDate('1983-07-08')
                            ->setBillingAddress((new Address())->setStreet('Rua Vitório Soriani')
                                                               ->setNumber('256')
                                                               ->setNeighborhood('JD Sabino')
                                                               ->setZipcode('14340000')
                                                               ->setCity('Brodowski')
                                                               ->setState('SP')
                                                               ->setCountry('BR'))
                            ->setShippingAddress((new Address())->setStreet('Rua Vitório Soriani')
                                                                ->setNumber('256')
                                                                ->setNeighborhood('JD Sabino')
                                                                ->setZipcode('14340000')
                                                                ->setCity('Brodowski')
                                                                ->setState('SP')
                                                                ->setCountry('BR'))
                            ->addNewPhone('11', '24242424', Phone::TYPE_LANDLINE)
                            ->addNewPhone('11', '998989898', Phone::TYPE_CELL);

// Crie a transação
try {
    $transaction = $subacquirer->createNewTransaction($order, $payment, $customer);
} catch (\Stelo\Subacquirer\SteloException $e) {
    $steloError = $e->getSteloError();

    //...
}

// ...
```