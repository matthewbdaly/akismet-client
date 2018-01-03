<?php

namespace Matthewbdaly\AkismetClient;

use Matthewbdaly\AkismetClient\Exceptions\KeyNotSet;
use Matthewbdaly\AkismetClient\Exceptions\KeyInvalid;
use Matthewbdaly\AkismetClient\Exceptions\BlogNotSet;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;

/**
 * API client
 */
class Client
{
    /**
     * API key
     *
     * @var $key
     */
    protected $key;

    /**
     * Blog
     *
     * @var $blog
     */
    protected $blog;

    /**
     * IP address
     *
     * @var $ip
     */
    protected $ip;

    /**
     * User agent string
     *
     * @var $agent
     */
    protected $agent;

    /**
     * Referrer
     *
     * @var $referrer
     */
    protected $referrer;

    /**
     * HTTPlug client
     *
     * @var $client
     */
    protected $client;

    /**
     * HTTPlug message factory
     *
     * @var $messageFactory
     */
    protected $messageFactory;

    /**
     * Constructor
     *
     * @param HttpClient     $client         HTTPlug client instance.
     * @param MessageFactory $messageFactory HTTPlug message factory instance.
     * @return void
     */
    public function __construct(HttpClient $client = null, MessageFactory $messageFactory = null)
    {
        $this->client = $client ?: HttpClientDiscovery::find();
        $this->messageFactory = $messageFactory ?: MessageFactoryDiscovery::find();
    }

    /**
     * Set API key
     *
     * @param string $key API key.
     * @return Client
     */
    public function setKey(string $key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Get API key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set blog URL
     *
     * @param string $blog The blog URL.
     * @return Client
     */
    public function setBlog(string $blog)
    {
        $this->blog = $blog;
        return $this;
    }

    /**
     * Get blog URL
     *
     * @return string
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * Verify currently set key against the API
     *
     * @return boolean
     * @throws KeyNotSet Key is not set.
     * @throws BlogNotSet Blog is not set.
     * @throws KeyInvalid Key is not valid.
     */
    public function verifyKey()
    {
        if (!$this->key) {
            throw new KeyNotSet;
        }
        if (!$this->blog) {
            throw new BlogNotSet;
        }
        $url = 'https://rest.akismet.com/1.1/verify-key';
        $request = $this->messageFactory->createRequest(
            'POST',
            $url,
            ['key' => $this->key, 'blog' => urlencode($this->blog)],
            null,
            '1.1'
        );
        $response = $this->client->sendRequest($request);
        $data = $response->getBody()->getContents();
        if ($data == 'invalid') {
            throw new KeyInvalid;
        }
        return true;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setAgent($agent)
    {
        $this->agent = $agent;
        return $this;
    }

    public function getAgent()
    {
        return $this->agent;
    }

    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;
        return $this;
    }

    public function getReferrer()
    {
        return $this->referrer;
    }
}
