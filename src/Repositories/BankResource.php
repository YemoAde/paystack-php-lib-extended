<?php
/**
 * Created by Malik Abiola.
 * Date: 05/02/2016
 * Time: 00:13
 * IDE: PhpStorm.
 */
namespace MAbiola\Paystack\Repositories;

use GuzzleHttp\Client;
use MAbiola\Paystack\Abstractions\Resource;

class BankResource extends Resource
{
    private $paystackHttpClient;

    /**
     * TransactionResource constructor.
     *
     * @param Client $paystackHttpClient
     */
    public function __construct(Client $paystackHttpClient)
    {
        $this->paystackHttpClient = $paystackHttpClient;
    }

    /**
     * Get List of Banks.
     *
     * @return \Exception|mixed
     */
    public function banks()
    {
        $request = $this->paystackHttpClient->get(
            Resource::LIST_BANK
        );

        return $this->processResourceRequestResponse($request);
    }

   
}
