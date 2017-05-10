<?php

namespace VeryBuy\Payment\SinoPac\Request;

use VeryBuy\Payment\SinoPac\AuthenticateToken;

trait EncryptVerifyCodeTrait
{
    /**
     * @var integer
     */
    protected $key;

    /**
     * @return string
     */
    protected function authenticate(): string
    {
        $token = $this->registerToken();

        return strtr('Digest realm="{realm}", nonce="{nonce}", uri="{uri}", verifycode="{verifyCode}", qop="{qop}", cnonce="{cnonce}"', [
            '{realm}' => $token->realm,
            '{nonce}' => $token->nonce,
            '{uri}' => $this->request->getUri(),
            '{verifyCode}' => $this->encrypt($token),
            '{qop}' => $token->qop,
            '{cnonce}' => $token->cnonce(),
        ]);
    }

    /**
     * @param  AuthenticateToken $token
     * @return string
     */
    protected function encrypt(AuthenticateToken $token): string
    {

        return $this->hash256(strtr('{ha1}:{nonce}:{cnonce}:{qop}:{message}:{ha2}', [
            '{ha1}' => $this->hash1($token),
            '{nonce}' => $token->nonce,
            '{cnonce}' => $token->cnonce(),
            '{qop}' => $token->qop,
            '{message}' => $this->getRequestContent(),
            '{ha2}' => $this->hash2()
        ]));
    }

    /**
     * @return string
     */
    public function getRequestContent(): string
    {
        return str_replace(["\n", '<?xml version="1.0"?>'], "", $this->toXml([
            'ShopNO' => $this->companyId,
            'KeyNum' => $this->key,
        ] + $this->request->validate()->toArray(), $this->request->getXmlHeader()));
    }

    /**
     * @return string
     */
    protected function getRandomKey(): string
    {
        // $this->key = random_int(1, 3);
        $this->key = random_int(1, 1);

        $flag = strtr('KeyData{flag}', [
            '{flag}' => $this->key
        ]);

        return $this->keys[$flag];
    }

    /**
     * @param  AuthenticateToken $token
     * @return string
     */
    protected function hash1(AuthenticateToken $token): string
    {
        return $this->hash256(strtr('{username}:{realm}:{keyData}', [
            '{username}' => $this->companyId,
            '{realm}' => $token->realm,
            '{keyData}' => $this->getRandomKey(),
        ]));
    }

    /**
     * @return string
     */
    protected function hash2(): string
    {
        return $this->hash256(strtr('{method}:{uri}', [
            '{method}' => 'POST',
            '{uri}' => $this->request->getUri(),
        ]));
    }

    /**
     * @param  string $encryptString
     * @return string
     */
    protected function hash256(string $encryptString): string
    {
        dump($encryptString);

        return hash('sha256', $encryptString);
    }
}
