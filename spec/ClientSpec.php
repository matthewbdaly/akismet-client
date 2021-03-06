<?php

namespace spec\Matthewbdaly\AkismetClient;

use Matthewbdaly\AkismetClient\Client;
use Matthewbdaly\AkismetClient\Exceptions\KeyNotSet;
use Matthewbdaly\AkismetClient\Exceptions\KeyInvalid;
use Matthewbdaly\AkismetClient\Exceptions\BlogNotSet;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ClientSpec extends ObjectBehavior
{
    function let (HttpClient $client, MessageFactory $messageFactory)
    {
        $this->beConstructedWith($client, $messageFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Client::class);
    }

    function it_can_set_the_key()
    {
        $this->setKey('foo');
        $this->getKey()->shouldReturn('foo');
    }

    function it_can_set_the_blog()
    {
        $this->setBlog('http://example.com');
        $this->getBlog()->shouldReturn('http://example.com');
    }

    function it_throws_an_exception_if_key_not_set()
    {
        $this->shouldThrow(KeyNotSet::class)->duringVerifyKey();
    }

    function it_throws_an_exception_if_blog_not_set()
    {
        $this->setKey('foo');
        $this->shouldThrow(BlogNotSet::class)->duringVerifyKey();
    }

    function it_can_verify_the_key(HttpClient $client, MessageFactory $messageFactory, RequestInterface $request, ResponseInterface $response, StreamInterface $stream)
    {
        $this->beConstructedWith($client, $messageFactory);
        $this->setKey('foo');
        $this->setBlog('http://example.com');
        $params = [
            'key' => 'foo',
            'blog' => urlencode('http://example.com')
        ];
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        $messageFactory->createRequest(
            'POST',
            'https://rest.akismet.com/1.1/verify-key',
            $headers,
            http_build_query($params),
            '1.1'
        )->willReturn($request);
        $client->sendRequest($request)->willReturn($response);
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn("valid");
        $this->verifyKey()->shouldReturn(true);
    }

    function it_can_handle_invalid_key(HttpClient $client, MessageFactory $messageFactory, RequestInterface $request, ResponseInterface $response, StreamInterface $stream)
    {
        $this->beConstructedWith($client, $messageFactory);
        $this->setKey('foo');
        $this->setBlog('http://example.com');
        $params = [
            'key' => 'foo',
            'blog' => urlencode('http://example.com')
        ];
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        $messageFactory->createRequest(
            'POST',
            'https://rest.akismet.com/1.1/verify-key',
            $headers,
            http_build_query($params),
            '1.1'
        )->willReturn($request);
        $client->sendRequest($request)->willReturn($response);
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn("invalid");
        $this->shouldThrow(KeyInvalid::class)->duringVerifyKey();
    }

    function it_can_set_the_user_ip()
    {
        $this->setIp('192.168.1.1')->shouldReturn($this);
    }

    function it_can_get_the_user_ip()
    {
        $this->getIp()->shouldReturn(null);
        $this->setIp('192.168.1.1')->shouldReturn($this);
        $this->getIp()->shouldReturn('192.168.1.1');
    }

    function it_can_set_the_user_agent()
    {
        $this->setAgent('Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6')->shouldReturn($this);
    }

    function it_can_get_the_user_agent()
    {
        $this->getAgent()->shouldReturn(null);
        $this->setAgent('Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6')->shouldReturn($this);
        $this->getAgent()->shouldReturn('Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6');
    }

    function it_can_set_the_referrer()
    {
        $this->setReferrer('http://www.google.com/')->shouldReturn($this);
    }

    function it_can_get_the_referrer()
    {
        $this->getReferrer()->shouldReturn(null);
        $this->setReferrer('http://www.google.com/')->shouldReturn($this);
        $this->getReferrer()->shouldReturn('http://www.google.com/');
    }

    function it_can_set_the_permalink()
    {
        $this->setPermalink('http://yourblogdomainname.com/blog/post=1')->shouldReturn($this);
    }

    function it_can_get_the_permalink()
    {
        $this->getPermalink()->shouldReturn(null);
        $this->setPermalink('http://yourblogdomainname.com/blog/post=1')->shouldReturn($this);
        $this->getPermalink()->shouldReturn('http://yourblogdomainname.com/blog/post=1');
    }

    function it_can_set_the_comment_type()
    {
        $this->setCommentType('comment')->shouldReturn($this);
    }

    function it_can_get_the_comment_type()
    {
        $this->getCommentType()->shouldReturn(null);
        $this->setCommentType('comment')->shouldReturn($this);
        $this->getCommentType()->shouldReturn('comment');
    }

    function it_can_set_the_comment_author()
    {
        $this->setCommentAuthor('Eric Smith')->shouldReturn($this);
    }

    function it_can_get_the_comment_author()
    {
        $this->getCommentAuthor()->shouldReturn(null);
        $this->setCommentAuthor('Eric Smith')->shouldReturn($this);
        $this->getCommentAuthor()->shouldReturn('Eric Smith');
    }

    function it_can_set_the_comment_author_email()
    {
        $this->setCommentAuthorEmail('eric@example.com')->shouldReturn($this);
    }

    function it_can_get_the_comment_author_email()
    {
        $this->getCommentAuthorEmail()->shouldReturn(null);
        $this->setCommentAuthorEmail('eric@example.com')->shouldReturn($this);
        $this->getCommentAuthorEmail()->shouldReturn('eric@example.com');
    }

    function it_can_set_the_comment_author_url()
    {
        $this->setCommentAuthorUrl('http://example.com')->shouldReturn($this);
    }

    function it_can_get_the_comment_author_url()
    {
        $this->getCommentAuthorUrl()->shouldReturn(null);
        $this->setCommentAuthorUrl('http://example.com')->shouldReturn($this);
        $this->getCommentAuthorUrl()->shouldReturn('http://example.com');
    }

    function it_can_set_the_comment_content()
    {
        $this->setCommentContent('Nice post')->shouldReturn($this);
    }

    function it_can_get_the_comment_content()
    {
        $this->getCommentContent()->shouldReturn(null);
        $this->setCommentContent('Nice post')->shouldReturn($this);
        $this->getCommentContent()->shouldReturn('Nice post');
    }

    function it_can_set_the_comment_date()
    {
        $this->setCommentDateGMT('1975-12-25T14:15:16-0500')->shouldReturn($this);
    }

    function it_can_get_the_comment_date()
    {
        $this->getCommentDateGMT()->shouldReturn(null);
        $this->setCommentDateGMT('1975-12-25T14:15:16-0500')->shouldReturn($this);
        $this->getCommentDateGMT()->shouldReturn('1975-12-25T14:15:16-0500');
    }

    function it_can_set_the_comment_post_modified_date()
    {
        $this->setCommentPostModifiedDate('1975-12-25T14:15:16-0500')->shouldReturn($this);
    }

    function it_can_get_the_comment_post_modified_date()
    {
        $this->getCommentPostModifiedDate()->shouldReturn(null);
        $this->setCommentPostModifiedDate('1975-12-25T14:15:16-0500')->shouldReturn($this);
        $this->getCommentPostModifiedDate()->shouldReturn('1975-12-25T14:15:16-0500');
    }

    function it_can_set_the_blog_lang()
    {
        $this->setBlogLang('en')->shouldReturn($this);
    }

    function it_can_get_the_blog_lang()
    {
        $this->getBlogLang()->shouldReturn(null);
        $this->setBlogLang('en')->shouldReturn($this);
        $this->getBlogLang()->shouldReturn('en');
    }

    function it_can_set_the_blog_charset()
    {
        $this->setBlogCharset('UTF-8')->shouldReturn($this);
    }

    function it_can_get_the_blog_charset()
    {
        $this->getBlogCharset()->shouldReturn(null);
        $this->setBlogCharset('UTF-8')->shouldReturn($this);
        $this->getBlogCharset()->shouldReturn('UTF-8');
    }

    function it_can_set_the_user_role()
    {
        $this->setUserRole('administrator')->shouldReturn($this);
    }

    function it_can_get_the_user_role()
    {
        $this->getUserRole()->shouldReturn(null);
        $this->setUserRole('administrator')->shouldReturn($this);
        $this->getUserRole()->shouldReturn('administrator');
    }

    function it_can_set_is_test()
    {
        $this->setIsTest(true)->shouldReturn($this);
    }

    function it_can_get_is_test()
    {
        $this->getIsTest()->shouldReturn(null);
        $this->setIsTest(true)->shouldReturn($this);
        $this->getIsTest()->shouldReturn(true);
    }

    function it_can_flush_params()
    {
        $this->setIp('192.168.1.1');
        $this->setAgent('Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6');
        $this->setReferrer('http://www.google.com/');
        $this->setPermalink('http://yourblogdomainname.com/blog/post=1');
        $this->setCommentType('comment');
        $this->setCommentAuthor('Eric Smith');
        $this->setCommentAuthorEmail('eric@example.com');
        $this->setCommentAuthorUrl('http://example.com');
        $this->setCommentContent('Nice post');
        $this->setCommentDateGMT('1975-12-25T14:15:16-0500');
        $this->setCommentPostModifiedDate('1975-12-25T14:15:16-0500');
        $this->setBlogLang('en');
        $this->setBlogCharset('UTF-8');
        $this->setUserRole('administrator');
        $this->setIsTest(true);
        $this->flush()->shouldReturn($this);
        $this->getIp()->shouldReturn(null);
        $this->getAgent()->shouldReturn(null);
        $this->getReferrer()->shouldReturn(null);
        $this->getPermalink()->shouldReturn(null);
        $this->getCommentType()->shouldReturn(null);
        $this->getCommentAuthor()->shouldReturn(null);
        $this->getCommentAuthorEmail()->shouldReturn(null);
        $this->getCommentAuthorUrl()->shouldReturn(null);
        $this->getCommentDateGMT()->shouldReturn(null);
        $this->getCommentPostModifiedDate()->shouldReturn(null);
        $this->getBlogLang()->shouldReturn(null);
        $this->getUserRole()->shouldReturn(null);
        $this->getIsTest()->shouldReturn(null);
        $this->getBlogCharset()->shouldReturn(null);
    }

    function it_can_check_a_comment_and_handle_a_spam_response(HttpClient $client, MessageFactory $messageFactory, RequestInterface $request, ResponseInterface $response, StreamInterface $stream)
    {
        // Construct object
        $this->beConstructedWith($client, $messageFactory);

        // Set key and blog
        $this->setKey('foo');
        $this->setBlog('http://example.com');

        // Set comment parameters
        $this->setIp('192.168.1.1');
        $this->setAgent('Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6');
        $this->setReferrer('http://www.google.com/');
        $this->setPermalink('http://yourblogdomainname.com/blog/post=1');
        $this->setCommentType('comment');
        $this->setCommentAuthor('Eric Smith');
        $this->setCommentAuthorEmail('eric@example.com');
        $this->setCommentAuthorUrl('http://example.com');
        $this->setCommentContent('Nice post');
        $this->setCommentDateGMT('1975-12-25T14:15:16-0500');
        $this->setCommentPostModifiedDate('1975-12-25T14:15:16-0500');
        $this->setBlogLang('en');
        $this->setBlogCharset('UTF-8');
        $this->setUserRole('administrator');
        $this->setIsTest(true);

        // Create request
        $params = [
            'blog' => 'http://example.com',
            'user_ip' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6',
            'referrer' => 'http://www.google.com/',
            'permalink' => 'http://yourblogdomainname.com/blog/post=1',
            'comment_type' => 'comment',
            'comment_author' => 'Eric Smith',
            'comment_author_email' => 'eric@example.com',
            'comment_author_url' => 'http://example.com',
            'comment_content' => 'Nice post',
            'comment_date_gmt' => '1975-12-25T14:15:16-0500',
            'comment_post_modified_gmt' => '1975-12-25T14:15:16-0500',
            'blog_lang' => 'en',
            'blog_charset' => 'UTF-8',
            'user_role' => 'administrator',
            'is_test' => true,
        ];
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        $messageFactory->createRequest('POST', 'https://foo.rest.akismet.com/1.1/comment-check', $headers, http_build_query($params), '1.1')->willReturn($request);
        $client->sendRequest($request)->willReturn($response);
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn("true");
        $this->check()->shouldReturn(true);
    }

    function it_can_check_a_comment_and_handle_a_ham_response(HttpClient $client, MessageFactory $messageFactory, RequestInterface $request, ResponseInterface $response, StreamInterface $stream)
    {
        // Construct object
        $this->beConstructedWith($client, $messageFactory);

        // Set key and blog
        $this->setKey('foo');
        $this->setBlog('http://example.com');

        // Set comment parameters
        $this->setIp('192.168.1.1');
        $this->setAgent('Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6');
        $this->setReferrer('http://www.google.com/');
        $this->setPermalink('http://yourblogdomainname.com/blog/post=1');
        $this->setCommentType('comment');
        $this->setCommentAuthor('Eric Smith');
        $this->setCommentAuthorEmail('eric@example.com');
        $this->setCommentAuthorUrl('http://example.com');
        $this->setCommentContent('Nice post');
        $this->setCommentDateGMT('1975-12-25T14:15:16-0500');
        $this->setCommentPostModifiedDate('1975-12-25T14:15:16-0500');
        $this->setBlogLang('en');
        $this->setBlogCharset('UTF-8');
        $this->setUserRole('administrator');
        $this->setIsTest(true);

        // Create request
        $params = [
            'blog' => 'http://example.com',
            'user_ip' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6',
            'referrer' => 'http://www.google.com/',
            'permalink' => 'http://yourblogdomainname.com/blog/post=1',
            'comment_type' => 'comment',
            'comment_author' => 'Eric Smith',
            'comment_author_email' => 'eric@example.com',
            'comment_author_url' => 'http://example.com',
            'comment_content' => 'Nice post',
            'comment_date_gmt' => '1975-12-25T14:15:16-0500',
            'comment_post_modified_gmt' => '1975-12-25T14:15:16-0500',
            'blog_lang' => 'en',
            'blog_charset' => 'UTF-8',
            'user_role' => 'administrator',
            'is_test' => true,
        ];
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        $messageFactory->createRequest('POST', 'https://foo.rest.akismet.com/1.1/comment-check', $headers, http_build_query($params), '1.1')->willReturn($request);
        $client->sendRequest($request)->willReturn($response);
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn("false");
        $this->check()->shouldReturn(false);
    }

    function it_can_mark_a_comment_as_spam(HttpClient $client, MessageFactory $messageFactory, RequestInterface $request, ResponseInterface $response, StreamInterface $stream)
    {
        // Construct object
        $this->beConstructedWith($client, $messageFactory);

        // Set key and blog
        $this->setKey('foo');
        $this->setBlog('http://example.com');

        // Set comment parameters
        $this->setIp('192.168.1.1');
        $this->setAgent('Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6');
        $this->setReferrer('http://www.google.com/');
        $this->setPermalink('http://yourblogdomainname.com/blog/post=1');
        $this->setCommentType('comment');
        $this->setCommentAuthor('Eric Smith');
        $this->setCommentAuthorEmail('eric@example.com');
        $this->setCommentAuthorUrl('http://example.com');
        $this->setCommentContent('Nice post');
        $this->setCommentDateGMT('1975-12-25T14:15:16-0500');
        $this->setCommentPostModifiedDate('1975-12-25T14:15:16-0500');
        $this->setBlogLang('en');
        $this->setBlogCharset('UTF-8');
        $this->setUserRole('administrator');
        $this->setIsTest(true);

        // Create request
        $params = [
            'blog' => 'http://example.com',
            'user_ip' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6',
            'referrer' => 'http://www.google.com/',
            'permalink' => 'http://yourblogdomainname.com/blog/post=1',
            'comment_type' => 'comment',
            'comment_author' => 'Eric Smith',
            'comment_author_email' => 'eric@example.com',
            'comment_author_url' => 'http://example.com',
            'comment_content' => 'Nice post',
            'comment_date_gmt' => '1975-12-25T14:15:16-0500',
            'comment_post_modified_gmt' => '1975-12-25T14:15:16-0500',
            'blog_lang' => 'en',
            'blog_charset' => 'UTF-8',
            'user_role' => 'administrator',
            'is_test' => true,
        ];
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        $messageFactory->createRequest('POST', 'https://foo.rest.akismet.com/1.1/submit-spam', $headers, http_build_query($params), '1.1')->willReturn($request);
        $client->sendRequest($request)->willReturn($response);
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn("Thanks for making the web a better place.");
        $this->spam()->shouldReturn(true);
    }

    function it_can_mark_a_comment_as_ham(HttpClient $client, MessageFactory $messageFactory, RequestInterface $request, ResponseInterface $response, StreamInterface $stream)
    {
        // Construct object
        $this->beConstructedWith($client, $messageFactory);

        // Set key and blog
        $this->setKey('foo');
        $this->setBlog('http://example.com');

        // Set comment parameters
        $this->setIp('192.168.1.1');
        $this->setAgent('Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6');
        $this->setReferrer('http://www.google.com/');
        $this->setPermalink('http://yourblogdomainname.com/blog/post=1');
        $this->setCommentType('comment');
        $this->setCommentAuthor('Eric Smith');
        $this->setCommentAuthorEmail('eric@example.com');
        $this->setCommentAuthorUrl('http://example.com');
        $this->setCommentContent('Nice post');
        $this->setCommentDateGMT('1975-12-25T14:15:16-0500');
        $this->setCommentPostModifiedDate('1975-12-25T14:15:16-0500');
        $this->setBlogLang('en');
        $this->setBlogCharset('UTF-8');
        $this->setUserRole('administrator');
        $this->setIsTest(true);

        // Create request
        $params = [
            'blog' => 'http://example.com',
            'user_ip' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6',
            'referrer' => 'http://www.google.com/',
            'permalink' => 'http://yourblogdomainname.com/blog/post=1',
            'comment_type' => 'comment',
            'comment_author' => 'Eric Smith',
            'comment_author_email' => 'eric@example.com',
            'comment_author_url' => 'http://example.com',
            'comment_content' => 'Nice post',
            'comment_date_gmt' => '1975-12-25T14:15:16-0500',
            'comment_post_modified_gmt' => '1975-12-25T14:15:16-0500',
            'blog_lang' => 'en',
            'blog_charset' => 'UTF-8',
            'user_role' => 'administrator',
            'is_test' => true,
        ];
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        $messageFactory->createRequest('POST', 'https://foo.rest.akismet.com/1.1/submit-ham', $headers, http_build_query($params), '1.1')->willReturn($request);
        $client->sendRequest($request)->willReturn($response);
        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn("Thanks for making the web a better place.");
        $this->ham()->shouldReturn(true);
    }

    function it_can_set_all_params_at_once()
    {
        $params = [
            'blog' => 'http://example.com',
            'user_ip' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6',
            'referrer' => 'http://www.google.com/',
            'permalink' => 'http://yourblogdomainname.com/blog/post=1',
            'comment_type' => 'comment',
            'comment_author' => 'Eric Smith',
            'comment_author_email' => 'eric@example.com',
            'comment_author_url' => 'http://example.com',
            'comment_content' => 'Nice post',
            'comment_date_gmt' => '1975-12-25T14:15:16-0500',
            'comment_post_modified_gmt' => '1975-12-25T14:15:16-0500',
            'blog_lang' => 'en',
            'blog_charset' => 'UTF-8',
            'user_role' => 'administrator',
            'is_test' => true,
        ];
        $this->setParams($params);
        $this->getBlog()->shouldReturn('http://example.com');
        $this->getIp()->shouldReturn('192.168.1.1');
        $this->getAgent()->shouldReturn('Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6');
        $this->getReferrer()->shouldReturn('http://www.google.com/');
        $this->getPermalink()->shouldReturn('http://yourblogdomainname.com/blog/post=1');
        $this->getCommentType()->shouldReturn('comment');
        $this->getCommentAuthor()->shouldReturn('Eric Smith');
        $this->getCommentAuthorEmail()->shouldReturn('eric@example.com');
        $this->getCommentAuthorUrl()->shouldReturn('http://example.com');
        $this->getCommentContent()->shouldReturn('Nice post');
        $this->getCommentDateGMT()->shouldReturn('1975-12-25T14:15:16-0500');
        $this->getCommentPostModifiedDate()->shouldReturn('1975-12-25T14:15:16-0500');
        $this->getBlogLang()->shouldReturn('en');
        $this->getBlogCharset()->shouldReturn('UTF-8');
        $this->getUserRole()->shouldReturn('administrator');
        $this->getIsTest()->shouldReturn(true);
    }
}
