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
     * Permalink
     *
     * @var $permalink
     */
    protected $permalink;

    /**
     * Comment type
     *
     * @var $commentType
     */
    protected $commentType;

    /**
     * Comment author
     *
     * @var $commentAuthor
     */
    protected $commentAuthor;

    /**
     * Comment author email
     *
     * @var $commentAuthorEmail
     */
    protected $commentAuthorEmail;

    /**
     * Comment author url
     *
     * @var $commentAuthorUrl
     */
    protected $commentAuthorUrl;

    /**
     * Comment content
     *
     * @var $commentContent
     */
    protected $commentContent;

    /**
     * Comment date GMT
     *
     * @var $commentDateGMT
     */
    protected $commentDateGMT;

    /**
     * Comment post modified date
     *
     * @var $commentPostModifiedDate
     */
    protected $commentPostModifiedDate;

    /**
     * Blog language
     *
     * @var $blogLang
     */
    protected $blogLang;

    /**
     * Blog charset
     *
     * @var $blogCharset
     */
    protected $blogCharset;


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

    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;
        return $this;
    }

    public function getPermalink()
    {
        return $this->permalink;
    }

    public function setCommentType($type)
    {
        $this->commentType = $type;
        return $this;
    }

    public function getCommentType()
    {
        return $this->commentType;
    }

    public function setCommentAuthor($author)
    {
        $this->commentAuthor = $author;
        return $this;
    }

    public function getCommentAuthor()
    {
        return $this->commentAuthor;
    }

    public function setCommentAuthorEmail($email)
    {
        $this->commentAuthorEmail = $email;
        return $this;
    }

    public function getCommentAuthorEmail()
    {
        return $this->commentAuthorEmail;
    }

    public function setCommentAuthorUrl($url)
    {
        $this->commentAuthorUrl = $url;
        return $this;
    }

    public function getCommentAuthorUrl()
    {
        return $this->commentAuthorUrl;
    }

    public function setCommentContent($content)
    {
        $this->commentContent = $content;
        return $this;
    }

    public function getCommentContent()
    {
        return $this->commentContent;
    }

    public function setCommentDateGMT($date)
    {
        $this->commentDateGMT = $date;
        return $this;
    }

    public function getCommentDateGMT()
    {
        return $this->commentDateGMT;
    }

    public function setCommentPostModifiedDate($date)
    {
        $this->commentPostModifiedDate = $date;
        return $this;
    }

    public function getCommentPostModifiedDate()
    {
        return $this->commentPostModifiedDate;
    }

    public function setBlogLang($lang)
    {
        $this->blogLang = $lang;
        return $this;
    }

    public function getBlogLang()
    {
        return $this->blogLang;
    }

    public function setBlogCharset($charset)
    {
        $this->blogCharset = $charset;
        return $this;
    }

    public function getBlogCharset()
    {
        return $this->blogCharset;
    }
}
