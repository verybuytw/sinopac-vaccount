<?php

namespace VeryBuy\Payment\SinoPac;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use VeryBuy\Payment\SinoPac\Request\AuthenticateRequestTrait as AuthenticateRequest;
use VeryBuy\Payment\SinoPac\Request\EncryptVerifyCodeTrait as EncryptVerifyCode;
use VeryBuy\Payment\SinoPac\Request\HttpClientTrait as HttpClient;
use VeryBuy\Payment\SinoPac\Request\TransformToXmlTrait as TransformToXml;

class RequestBuilder
{
    use AuthenticateRequest, EncryptVerifyCode, HttpClient, TransformToXml;

    /**
     *@var string
     */
    protected $companyId;

    /**
     *@var array
     */
    protected $keys;

    /**
     *@var RequestContract
     */
    protected $request;

    /**
     * @param string $companyId
     * @param array  $keys
     */
    public function __construct(string $companyId, array $keys)
    {
        $this
            ->setCompanyId($companyId)
            ->setKeys($keys);
    }

    /**
     * @param RequestContract $request
     */
    protected function setRequest(RequestContract $request) : self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @param string $companyId
     */
    protected function setCompanyId(string $companyId) : self
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * @param array $keys
     */
    protected function setKeys(array $keys) : self
    {
        $this->keys = $keys;

        return $this;
    }

    /**
     * [request description]
     * @param  RequestContract $contract
     * @return self|Response
     */
    public function request(RequestContract $contract)
    {
        $authenticate = $this
            ->setRequest($contract)
            ->authenticate();

        try {
            $request = new Request(
                'POST',
                $contract->getUri(),
                [
                    'Authorization' => $authenticate,
                    'Content-Type' => 'text/xml'
                ],
                $this->getRequestContent()
            );

            $response = $this
                ->genClient(['verify' => false])
                ->send($request);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }
        dump($request);
        dump($this->getRequestContent());
        dump($response);

        return $this;
    }
}
