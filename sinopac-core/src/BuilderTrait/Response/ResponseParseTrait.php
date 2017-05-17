<?php

namespace VeryBuy\Payment\SinoPac\BuilderTrait\Response;

use GuzzleHttp\Psr7\Response;
use VeryBuy\Payment\SinoPac\Exceptions\FailedException;
use VeryBuy\Payment\SinoPac\Responses\ResponseContract;

trait ResponseParseTrait
{
    /**
     * @param  Response $response
     * @return ResponseContract|FailedException
     */
    protected function parseHttpResponse(Response $response): ResponseContract
    {
        $class = $this->request->getResponseClass();

        $response = new $class(
            $response->getBody()->getContents()
        );

        if ($response->isSuccess()) {
            return $response;
        }

        throw new FailedException($response->getCode());
    }
}
