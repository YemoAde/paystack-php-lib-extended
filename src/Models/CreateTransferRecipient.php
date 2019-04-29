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

class CreateTransferRecipient extends BaseTransaction implements TransactionContract
{
//    protected $transactionResource;

    private $accountName;
    private $accountNumber;
    private $bankCode;
    private $currency;
    private $type;

    /**
     * OneTimeTransaction constructor.
     * @param $accountName
     * @param $accountNumber
     * @param $bankCode
     * @param $currency
     */
    protected function __construct($accountName, $accountNumber, $bankCode, $currency = 'NGN', $type = 'nuban')
    {
        $this->accountName = $accountName;
        $this->accountNumber = $accountNumber;
        $this->bankCode = $bankCode;
        $this->currency = $currency;
        $this->type = $type;

//        $this->transactionResource = $transactionResource;
    }

    /**
     * Make a new one time transaction object
     * @param $accountName
     * @param $accountNumber
     * @param $bankCode
     * @param $currency
     * @param $type
     * @return static
     */
    public static function make($accountName, $accountNumber, $bankCode, $currency = 'NGN', $type = 'nuban')
    {
        return new static($accountName, $accountNumber, $bankCode, $currency, $type);
    }

    /**
     * Create a Transfer Recipient via url
     * @return \Exception|mixed|PaystackInvalidTransactionException
     */
    public function createRecipient()
    {
        return !is_null($this->accountNumber) || !is_null($this->accountName) || !is_null($this->bankCode) || !is_null($this->type)?
           $this->getTransactionResource()->createRecipient($this->_requestPayload()) :
            new PaystackInvalidTransactionException(
                json_decode(
                    json_encode(
                        [
                            "message" => "Provide Bank Account Name, Account Number and Bank Code."
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
            'name'    => $this->accountName,
            'account_number' => $this->accountNumber,
            'bank_code'     => $this->bankCode,
            'currency' => $this->currency,
            'type' => $this->type
        ];

        return $this->toJson($payload);
    }
}
