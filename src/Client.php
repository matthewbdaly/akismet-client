<?php

namespace Matthewbdaly\AkismetClient;

use Matthewbdaly\AkismetClient\Exceptions\KeyNotSet;
use Matthewbdaly\AkismetClient\Exceptions\KeyInvalid;
use Matthewbdaly\AkismetClient\Exceptions\BlogNotSet;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;

class Client
{
    protected $key;

    protected $blog;

    protected $client;

    protected $messageFactory;

    public function __construct(HttpClient $client = null, MessageFactory $messageFactory = null)
    {
        $this->client = $client ?: HttpClientDiscovery::find();
        $this->messageFactory = $messageFactory ?: MessageFactoryDiscovery::find();
    }

    public function setKey(string $key)
    {
        $this->key = $key;
        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setBlog($blog)
    {
        $this->blog = $blog;
        return $this;
    }

    public function getBlog()
    {
        return $this->blog;
    }

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
}
