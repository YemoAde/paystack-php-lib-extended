<?php
/**
 * Created by Malik Abiola.
 * Date: 10/02/2016
 * Time: 16:10
 * IDE: PhpStorm
 * Create one time transactions
 */

namespace MAbiola\Paystack\Models;


use MAbiola\Paystack\Abstractions\BaseTransaction;
use MAbiola\Paystack\Contracts\TransactionContract;
use MAbiola\Paystack\Exceptions\PaystackInvalidTransactionException;

class CreateTransfer extends BaseTransaction implements TransactionContract
{
//    protected $transactionResource;

    private $source;
    private $amount;
    private $recipient;
    private $currency;

    /**
     * CreateTransfer constructor.
     * @param $source
     * @param $amount
     * @param $currency
     */
    protected function __construct($amount, $recipient, $source, $currency = 'NGN')
    {
        $this->source = $source;
        $this->amount = $amount;
        $this->recipient = $recipient;
        $this->currency = $currency;

//        $this->transactionResource = $transactionResource;
    }

    /**
     * Make a new one time transaction object
     * @@param $transactionReference
     * @param $amount
     * @param $currency
     * @return static
     */
    public static function make($amount, $recipient, $source, $currency = 'NGN')
    {
        return new static($amount, $recipient, $source, $currency);
    }

    /**
     * Create a Transfer Recipient via url
     * @return \Exception|mixed|PaystackInvalidTransactionException
     */
    public function createTransfer()
    {
        return !is_null($this->source) || !is_null($this->amount) || !is_null($this->recipient)?
           $this->getTransactionResource()->createTransfer($this->_requestPayload()) :
            new PaystackInvalidTransactionException(
                json_decode(
                    json_encode(
                        [
                            "message" => "Provide Amount and Recipient, Transaction Reference Not Generated."
                        ]
                    ),
                    false
                )
            );
    }

    /**
     * Get transaction request body.
     * @return string
     */
    public function _requestPayload()
    {
        $payload = [
            'source'    => $this->source,
            'amount' => $this->amount,
            'recipient' => $this->recipient,
            'currency' => $this->currency
        ];

        return $this->toJson($payload);
    }
}
