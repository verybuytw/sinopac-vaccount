<?php

namespace VeryBuy\Payment\SinoPac;

class AuthenticateToken
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var int|null
     */
    protected $cnonce;

    public function __construct(array $token)
    {
        $this->token = $token;
    }

    /**
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->token[$name];
    }

    /**
     * @return int
     */
    public function cnonce(): int
    {
        if (!$this->cnonce) {
            $this->cnonce = random_int(123400, 9999999);
        }

        return $this->cnonce;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_merge($this->token, [
            'cnonce' => $this->cnonce
        ]);
    }
}
