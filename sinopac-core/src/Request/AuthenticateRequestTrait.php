<?php

namespace VeryBuy\Payment\SinoPac\Request;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response as HttpCode;
use VeryBuy\Payment\SinoPac\AuthenticateToken;
use VeryBuy\Payment\SinoPac\Exceptions\TokenException;

trait AuthenticateRequestTrait
{
    /**
     * @var string
     */
    protected $headerAuthentcate = 'WWW-Authenticate';

    /**
     * @param  Response $response
     * @return boolean
     */
    protected function isCorrectResponse(Response $response): bool
    {
        return ($response->getStatusCode() === HttpCode::HTTP_UNAUTHORIZED) and ($response->hasHeader($this->headerAuthentcate));
    }

    /**
     * @param  Response $response
     * @return AuthenticateToken
     */
    protected function pasreToken(Response $response): AuthenticateToken
    {
        list($authenticate) = $response->getHeader($this->headerAuthentcate);

        $token = Collection::make($authenticate)->flatMap(function ($item) {
            $item = str_replace('Digest', '', $item);

            return explode(',', $item);
        })->flatMap(function ($item) {
            list($key, $value) = explode('=', trim($item));

            return [$key => trim($value, '"')];
        })->all();

        return new AuthenticateToken($token);
    }

    /**
     * @return Response|TokenException
     */
    protected function registerToken()
    {
        try {
            $response = $this
                ->getClient()
                ->get($this->request->getUri());
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        if ($this->isCorrectResponse($response)) {
            return $this->pasreToken($response);
        }

        throw new TokenException('Token get failed. Notify SinoPac Bank');
    }
}
