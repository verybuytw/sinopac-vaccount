<?php

namespace VeryBuy\Payment\SinoPac;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use VeryBuy\Payment\SinoPac\BuilderTrait\Request\AuthenticateRequestTrait as AuthenticateRequest;
use VeryBuy\Payment\SinoPac\BuilderTrait\Request\EncryptVerifyCodeTrait as EncryptVerifyCode;
use VeryBuy\Payment\SinoPac\BuilderTrait\Request\HttpClientTrait as HttpClient;
use VeryBuy\Payment\SinoPac\BuilderTrait\Response\ResponseParseTrait as ResponseParse;
use VeryBuy\Payment\SinoPac\Requests\RequestContract;
use VeryBuy\Payment\SinoPac\TransformToXmlTrait as TransformToXml;

class RequestBuilder
{
    use AuthenticateRequest, EncryptVerifyCode, HttpClient, TransformToXml, ResponseParse;

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
     * @param  RequestContract $contract
     * @return string
     */
    public function make(RequestContract $contract)
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
                    'Content-Type' => 'text/xml;'
                ],
                $this->getRequestContent()
            );

            $response = $this
                ->genClient()
                ->send($request);
        } catch (RequestException $e) {
            $response = $e->getResponse();

            throw $e;
        }

        return $this->parseHttpResponse($response);
    }
}
