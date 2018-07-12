<?php

namespace JK\Bitstamp\Client;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;

/**
 * Class BaseClient
 * @package JK\Bitstamp\Client
 */
abstract class BaseClient
{

    /**
     * Base API URL
     */
    const BASE_URL = 'https://www.bitstamp.net/api/';

    /**
     * Current API Version
     */
    const VERSION = 'v2';

    /**
     * Default Currency Pair
     */
    const CURRENCY_PAIR_DEFAULT = 'btcusd';

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var int
     */
    protected $nonce;

    /**
     * @var array
     */
    protected $supportedPairs = ['btcusd', 'btceur', 'eurusd', 'xrpusd', 'xrpeur', 'xrpbtc', 'ltcusd', 'ltceur', 'ltcbtc', 'ethusd', 'etheur', 'ethbtc', 'bchusd', 'bcheur', 'bchbtc'];

    /**
     * BaseClient constructor.
     * @param null $id
     * @param null $key
     * @param null $secret
     */
    public function __construct($id = null, $key = null, $secret = null)
    {
        $this->id = $id;
        $this->key = $key;
        $this->secret = $secret;
        $this->nonce = self::getNonce();
        $this->baseUrl = self::getBaseUrl();
        $this->client = new Client([
            'base_uri' => $this->baseUrl
        ]);
    }

    /**
     * @return string
     */
    protected static function getBaseUrl()
    {
        return (self::BASE_URL . self::VERSION . '/');
    }

    /**
     * @return int
     */
    protected static function getNonce()
    {
        return time();
    }

    /**
     * @param $message
     * @param $secret
     * @return string
     */
    protected static function sign($message, $secret)
    {
        return hash_hmac('sha512', $message, $secret);
    }

    /**
     * @param $uri
     * @return array|mixed
     */
    protected function get($uri)
    {
        try {

            $response = $this->client->request('GET', $uri);

            return self::parseResponse($response);

        } catch (RequestException $e) {

            return self::parseException($e);

        }
    }

    /**
     * @param $uri
     * @param array $params
     * @return array|mixed
     */
    protected function post($uri, $params = [])
    {
        try {

            // Message to be signed
            $message = ($this->nonce . $this->id . $this->key);

            // Default params
            $params += [
                'key' => $this->key,
                'signature' => self::sign($message, $this->secret),
                'nonce' => $this->nonce
            ];

            $response = $this->client->request('POST', $uri, [
                'form_params' => $params
            ]);

            return self::parseResponse($response);

        } catch (RequestException $e) {

            return self::parseException($e);

        }
    }

    /**
     * @param RequestException $e
     * @return array
     */
    protected function parseException(RequestException $e)
    {
        $payload = ['message' => $e->getMessage(), 'code' => $e->getCode()];

        if ($e->hasResponse()) {

            $payload['message'] = $e->getResponse()->getReasonPhrase();

        }

        return $payload;
    }

    /**
     * @param Response $response
     * @param bool $assoc
     * @return mixed
     */
    protected function parseResponse(Response $response, $assoc = true)
    {
        return json_decode($response->getBody(), $assoc);
    }


}