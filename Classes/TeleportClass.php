<?php

namespace Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TeleportClass
{
    /**
     * Web interface ad url segment
     */
    const G = '/g/';

    /**
     * API ad url segment
     */
    const TPT = '/tpt/';

    /**
     * Bad url massage
     */
    public $badUrlMessage = 'Please provide valid Admitad ad url';

    /**
     * Admitad ad url
     */
    private $url;

    /**
     * Country ISO code
     */
    private $countryCode;

    /**
     * Guzzle
     */
    private $client;

    /**
     * TeleportClass constructor.
     * @param null $url
     * @param null $countryCode
     */
    public function __construct($url = null, $countryCode = null)
    {
        if (isset($url)) {
            $this->url = $url;
        }

        if (isset($countryCode)) {
            $this->countryCode = $countryCode;
        }

        $this->client = new Client;
    }

    /**
     * Returns the jump url
     *
     * @link https://teleport.admitad.com/ru/instructionapi
     */
    public function open()
    {
        $url = $this->prepare($this->url);

        try {
            $result = $this->client->request('GET', $url, [
                'query' => [
                    'country_code' => $this->countryCode
                ]
            ])->getBody();

            return json_decode($result->getContents(), true)[0];
        } catch (RequestException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Example: https://ad.admitad.com/g/1e8d114494b7e165239416525dc3e8/
     * Except example: fas.st, ali.ski
     *
     * @param null $url
     * @return $this
     */
    public function setUrl($url) : TeleportClass
    {
         $this->url = $url;

         return $this;
    }

    /**
     * Example: ru, en
     *
     * @param string $countryCode
     * @return $this
     */
    public function setCountryCode(string $countryCode): TeleportClass
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Validate and convert url
     *
     * @param string $url
     * @return string|string[]
     */
    private function prepare(string $url)
    {
        // empty url
        if (empty($url)) {
            exit($this->badUrlMessage . ' : empty url');
        }

        // invalid url
        if (! filter_var($url, FILTER_VALIDATE_URL, 'FILTER_FLAG_SCHEME_REQUIRED')) {
            exit($this->badUrlMessage . ' : wrong url');
        }

        // convert web interface to api url
        if (strpos($url, self::G)) {
            return str_replace(self::G, self::TPT, $url);
        }

        // api url
        if (strpos($url, self::TPT)) {
            return $url;
        }

        // url doesnt have /g/ or /tpt/
        else {
            exit($this->badUrlMessage . ' : no segment in url');
        }
    }
}