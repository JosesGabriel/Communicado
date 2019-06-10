<?php

// defined('BASEPATH') OR exit('No direct script access allowed');

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

class JWTBuilder 
{

    private $key;
    private $signer;
    private $time;
    private $validator;
    protected $token;
    protected $entities = [
        'arbitrage' => 'https://arbitrage.ph',
        'vyndue' => 'https://vyndue.com',
    ];

    public function __construct()
    {
        $this->key = '864v2wg542s6s62t6qrcwxsdx9d2z6qq';
        $this->signer = new Sha256();
        $this->time = time();
        $this->token = new Builder();
        $this->validator = new ValidationData();
    }

    //region Getters

    /**
     * @param String $entity
     * @return String
     */
    public function getEntity($entity)
    {
        return $this->entities[$entity];
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getToken()
    {
        return $this->token;
    }
    //endregion Getters

    //region Setters

    /**
     * Wrapper for withClaim method
     * 
     * @param String $key
     * @param String $value
     * @return JWTBuilder
     */
    public function setTokenClaim($key, $value)
    {
        $this->token->withClaim($key, $value);
        return $this;
    }

    /**
     * Sets specific params for login token to arbitrage that will ask arbitrage for the current logged in user
     * 
     * @param String $for url
     * @return JWTBuilder
     */
    public function setLoginToken($for)
    {
        $this->token
            ->permittedFor($this->entities[$for]);
        return $this;
    }

    /**
     * Set the token
     *
     * @param String $token JWT token
     * @return JWTBuilder
     */
    public function setToken($token)
    {
        $this->token = (new Parser())->parse((string) $token);
        return $this;
    }

    //endregion Setters

    /**
     * Generates a generic token
     */
    public function generateToken()
    {
        $time = $this->time;
        return $this->token
                    ->issuedBy($this->entities['vyndue'])
                    ->canOnlyBeUsedAfter($time + 60)
                    ->expiresAt($time + 3600)
                    ->getToken($this->signer, new Key($this->key));
    }

    public function validateLoginToken()
    {
        $this->validator->setIssuer($this->entities['arbitrage']);
        return $this->validateToken();
    }

    protected function validateToken()
    {
        $time = $this->time;
        $this->validator->setCurrentTime($time + 61);
        $this->validator->setAudience($this->entities['vyndue']);
        return $this->token->validate($this->validator) && $this->token->verify($this->signer, $this->key);
    }

}