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

class CreateRefund extends BaseTransaction implements TransactionContract
{
//    protected $transactionResource;

    private $transactionReference;
    private $amount;
    private $currency;

    /**
     * CreateRefund constructor.
     * @param $transactionReference
     * @param $amount
     * @param $currency
     */
    protected function __construct($transactionReference, $amount, $currency = 'NGN')
    {
        $this->transactionReference = $transactionReference;
        $this->amount = $amount;
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
    public static function make($transactionReference, $amount, $currency = 'NGN')
    {
        return new static($transactionReference, $amount, $currency);
    }

    /**
     * Create a Transfer Recipient via url
     * @return \Exception|mixed|PaystackInvalidTransactionException
     */
    public function createRefund()
    {
        return !is_null($this->transactionReference) || !is_null($this->amount) ?
           $this->getTransactionResource()->createRefund($this->_requestPayload()) :
            new PaystackInvalidTransactionException(
                json_decode(
                    json_encode(
                        [
                            "message" => "Provide Transaction Reference, Amount."
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
            'transaction' => $this->transactionReference,
            'amount' => $this->amount,
            'currency' => $this->currency
        ];

        return $this->toJson($payload);
    }
}
