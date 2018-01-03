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
        $messageFactory->createRequest('POST', 'https://rest.akismet.com/1.1/verify-key', ['key' => 'foo', 'blog' => urlencode('http://example.com')], null, '1.1')->willReturn($request);
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
        $messageFactory->createRequest('POST', 'https://rest.akismet.com/1.1/verify-key', ['key' => 'foo', 'blog' => urlencode('http://example.com')], null, '1.1')->willReturn($request);
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
}
