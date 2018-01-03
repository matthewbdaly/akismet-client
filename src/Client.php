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
     * User role
     *
     * @var $userRole
     */
    protected $userRole;

    /**
     * Is test
     *
     * @var $isTest
     */
    protected $isTest;

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
     * Set IP address
     *
     * @param string $ip The IP address.
     * @return Client
     */
    public function setIp(string $ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * Get IP address
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set user agent
     *
     * @param string $agent The user agent.
     * @return Client
     */
    public function setAgent(string $agent)
    {
        $this->agent = $agent;
        return $this;
    }

    /**
     * Get user agent
     *
     * @return string
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set referrer
     *
     * @param string $referrer The referrer.
     * @return Client
     */
    public function setReferrer(string $referrer)
    {
        $this->referrer = $referrer;
        return $this;
    }

    /**
     * Get referrer
     *
     * @return string
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * Set permalink
     *
     * @param string $permalink The permalink.
     * @return Client
     */
    public function setPermalink(string $permalink)
    {
        $this->permalink = $permalink;
        return $this;
    }

    /**
     * Get permalink
     *
     * @return string
     */
    public function getPermalink()
    {
        return $this->permalink;
    }

    /**
     * Set comment type
     *
     * @param string $type The comment type - can be comment, forum-post, reply, blog-post, contact-form, signup, message or a custom type.
     * @return Client
     */
    public function setCommentType(string $type)
    {
        $this->commentType = $type;
        return $this;
    }

    /**
     * Get comment type
     *
     * @return string
     */
    public function getCommentType()
    {
        return $this->commentType;
    }

    /**
     * Set comment author
     *
     * @param string $author The comment author's name.
     * @return Client
     */
    public function setCommentAuthor(string $author)
    {
        $this->commentAuthor = $author;
        return $this;
    }

    /**
     * Get comment author
     *
     * @return string
     */
    public function getCommentAuthor()
    {
        return $this->commentAuthor;
    }

    /**
     * Set comment author email
     *
     * @param string $email The comment author's email address.
     * @return Client
     */
    public function setCommentAuthorEmail(string $email)
    {
        $this->commentAuthorEmail = $email;
        return $this;
    }

    /**
     * Get comment author email
     *
     * @return string
     */
    public function getCommentAuthorEmail()
    {
        return $this->commentAuthorEmail;
    }

    /**
     * Set comment author URL
     *
     * @param string $url The comment author's URL.
     * @return Client
     */
    public function setCommentAuthorUrl(string $url)
    {
        $this->commentAuthorUrl = $url;
        return $this;
    }

    /**
     * Get comment author URL
     *
     * @return string
     */
    public function getCommentAuthorUrl()
    {
        return $this->commentAuthorUrl;
    }

    /**
     * Set comment content
     *
     * @param string $content The comment content.
     * @return Client
     */
    public function setCommentContent(string $content)
    {
        $this->commentContent = $content;
        return $this;
    }

    /**
     * Get comment content
     *
     * @return string
     */
    public function getCommentContent()
    {
        return $this->commentContent;
    }

    /**
     * Set comment date in GMT
     *
     * @param string $date The date of the comment in ISO-8601 format.
     * @return Client
     */
    public function setCommentDateGMT(string $date)
    {
        $this->commentDateGMT = $date;
        return $this;
    }

    /**
     * Get comment date in GMT
     *
     * @return string
     */
    public function getCommentDateGMT()
    {
        return $this->commentDateGMT;
    }

    /**
     * Set date for when post last modified
     *
     * @param string $date The date of the comment in ISO-8601 format.
     * @return Client
     */
    public function setCommentPostModifiedDate(string $date)
    {
        $this->commentPostModifiedDate = $date;
        return $this;
    }

    /**
     * Get date for when post last modified
     *
     * @return string
     */
    public function getCommentPostModifiedDate()
    {
        return $this->commentPostModifiedDate;
    }

    /**
     * Set blog language
     *
     * @param string $lang The blog language.
     * @return Client
     */
    public function setBlogLang(string $lang)
    {
        $this->blogLang = $lang;
        return $this;
    }

    /**
     * Get blog language
     *
     * @return string
     */
    public function getBlogLang()
    {
        return $this->blogLang;
    }

    /**
     * Set blog charset
     *
     * @param string $charset The blog charset.
     * @return Client
     */
    public function setBlogCharset(string $charset)
    {
        $this->blogCharset = $charset;
        return $this;
    }

    /**
     * Get blog charset
     *
     * @return string
     */
    public function getBlogCharset()
    {
        return $this->blogCharset;
    }

    /**
     * Set user role
     *
     * @param string $role The user role.
     * @return Client
     */
    public function setUserRole(string $role)
    {
        $this->userRole = $role;
        return $this;
    }

    /**
     * Get user role
     *
     * @return string
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * Set is test
     *
     * @param boolean $isTest Is this a test or not.
     * @return Client
     */
    public function setIsTest(bool $isTest)
    {
        $this->isTest = $isTest;
        return $this;
    }

    /**
     * Get is test
     *
     * @return string
     */
    public function getIsTest()
    {
        return $this->isTest;
    }

    /**
     * Flush the currently set parameters
     *
     * @return Client
     */
    public function flush()
    {
        $this->ip = null;
        $this->agent = null;
        $this->referrer = null;
        $this->permalink = null;
        $this->commentType = null;
        $this->commentAuthor = null;
        $this->commentAuthorEmail = null;
        $this->commentAuthorUrl = null;
        $this->commentContent = null;
        $this->commentDateGMT = null;
        $this->commentPostModifiedDate = null;
        $this->blogLang = null;
        $this->blogCharset = null;
        $this->userRole = null;
        $this->isTest = null;
        return $this;
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
            ['key' => $this->getKey(), 'blog' => urlencode($this->getBlog())],
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

    /**
     * Check the currently set comment to see if it is spam
     *
     * @return boolean
     * @throws KeyNotSet Key is not set.
     * @throws BlogNotSet Blog is not set.
     */
    public function check()
    {
        if (!$this->key) {
            throw new KeyNotSet;
        }
        if (!$this->blog) {
            throw new BlogNotSet;
        }
        $url = 'https://'.$this->getKey().'.rest.akismet.com/1.1/comment-check';
        $params = $this->getParams();
        $request = $this->messageFactory->createRequest(
            'POST',
            $url,
            $params,
            null,
            '1.1'
        );
        $response = $this->client->sendRequest($request);
        $data = $response->getBody()->getContents();
        if ($data == 'true') {
            return true;
        }
        return false;
    }

    /**
     * Submit comment as spam
     *
     * @return boolean
     * @throws BlogNotSet Blog is not set.
     * @throws KeyNotSet Key is not set.
     */
    public function spam()
    {
        if (!$this->key) {
            throw new KeyNotSet;
        }
        if (!$this->blog) {
            throw new BlogNotSet;
        }
        $url = 'https://'.$this->getKey().'.rest.akismet.com/1.1/submit-spam';
        $params = $this->getParams();
        $request = $this->messageFactory->createRequest(
            'POST',
            $url,
            $params,
            null,
            '1.1'
        );
        $response = $this->client->sendRequest($request);
        $data = $response->getBody()->getContents();
        if ($data == 'Thanks for making the web a better place.') {
            return true;
        }
        return false;
    }

    /**
     * Submit comment as ham
     *
     * @return boolean
     * @throws BlogNotSet Blog is not set.
     * @throws KeyNotSet Key is not set.
     */
    public function ham()
    {
        if (!$this->key) {
            throw new KeyNotSet;
        }
        if (!$this->blog) {
            throw new BlogNotSet;
        }
        $url = 'https://'.$this->getKey().'.rest.akismet.com/1.1/submit-ham';
        $params = $this->getParams();
        $request = $this->messageFactory->createRequest(
            'POST',
            $url,
            $params,
            null,
            '1.1'
        );
        $response = $this->client->sendRequest($request);
        $data = $response->getBody()->getContents();
        if ($data == 'Thanks for making the web a better place.') {
            return true;
        }
        return false;
    }

    /**
     * Get the currently set parameters
     *
     * @return array
     */
    protected function getParams()
    {
        return [
            'blog' => $this->getBlog(),
            'user_ip' => $this->getIp(),
            'user_agent' => $this->getAgent(),
            'referrer' => $this->getReferrer(),
            'permalink' => $this->getPermalink(),
            'comment_type' => $this->getCommentType(),
            'comment_author' => $this->getCommentAuthor(),
            'comment_author_email' => $this->getCommentAuthorEmail(),
            'comment_author_url' => $this->getCommentAuthorUrl(),
            'comment_content' => $this->getCommentContent(),
            'comment_date_gmt' => $this->getCommentDateGMT(),
            'comment_post_modified_gmt' => $this->getCommentPostModifiedDate(),
            'blog_lang' => $this->getBlogLang(),
            'blog_charset' => $this->getBlogCharset(),
            'user_role' => $this->getUserRole(),
            'is_test' => $this->getIsTest()
        ];
    }

    /**
     * Set parameters in bulk
     *
     * @param array $params Parameters to set.
     * @return Client
     */
    public function setParams(array $params)
    {
        array_key_exists('key', $params) ? $this->setKey($params['key']) : null;
        array_key_exists('blog', $params) ? $this->setBlog($params['blog']) : null;
        array_key_exists('user_ip', $params) ? $this->setIp($params['user_ip']) : null;
        array_key_exists('user_agent', $params) ? $this->setAgent($params['user_agent']) : null;
        array_key_exists('referrer', $params) ? $this->setReferrer($params['referrer']) : null;
        array_key_exists('permalink', $params) ? $this->setPermalink($params['permalink']) : null;
        array_key_exists('comment_type', $params) ? $this->setCommentType($params['comment_type']) : null;
        array_key_exists('comment_author', $params) ? $this->setCommentAuthor($params['comment_author']) : null;
        array_key_exists('comment_author_email', $params) ? $this->setCommentAuthorEmail($params['comment_author_email']) : null;
        array_key_exists('comment_author_url', $params) ? $this->setCommentAuthorUrl($params['comment_author_url']) : null;
        array_key_exists('comment_content', $params) ? $this->setCommentContent($params['comment_content']) : null;
        array_key_exists('comment_date_gmt', $params) ? $this->setCommentDateGMT($params['comment_date_gmt']) : null;
        array_key_exists('comment_post_modified_gmt', $params) ? $this->setCommentPostModifiedDate($params['comment_post_modified_gmt']) : null;
        array_key_exists('blog_lang', $params) ? $this->setBlogLang($params['blog_lang']) : null;
        array_key_exists('blog_charset', $params) ? $this->setBlogCharset($params['blog_charset']) : null;
        array_key_exists('user_role', $params) ? $this->setUserRole($params['user_role']) : null;
        array_key_exists('is_test', $params) ? $this->setIsTest($params['is_test']) : null;
        return $this;
    }
}
