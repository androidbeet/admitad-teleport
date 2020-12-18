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
     * @link https://teleport.admitad.com/ru/instructionapi
     */
    public function getDestinationUrl()
    {
        $this->chek($this->url);

        $url = $this->prepare($this->url);

        try {
            $result = $this->client->request('GET', $url, [
                'query' => [
                    'country_code' => $this->countryCode
                ]
            ])->getBody();

            return json_decode($result->getContents(), true)[0];
        } catch (RequestException $e) {
            echo $e->getMessage();
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
     * Validate url
     *
     * @param null $url
     */
    private function chek($url = null)
    {
        // is empty
        if (empty($url)) {
            exit($this->badUrlMessage . ' : empty url');
        }

        // is valid url with protocol
        if (! filter_var($url, FILTER_VALIDATE_URL, 'FILTER_FLAG_SCHEME_REQUIRED')) {
            exit($this->badUrlMessage . ' : wrong url');
        }
    }

    /**
     * Convert web interface url to api url if need
     *
     * @param string $url
     * @return string|string[]
     */
    private function prepare(string $url)
    {
        // if web interface url
        if (strpos($url, self::G)) {
            return str_replace(self::G, self::TPT, $url);
        }

        // if api url
        if (strpos($url, self::TPT)) {
            return $url;
        }

        // is url doesnt have /g/ or /tpt/
        else {
            exit($this->badUrlMessage . ' : no segment in url');
        }
    }
}