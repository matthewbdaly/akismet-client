<?php

namespace spec\Matthewbdaly\AkismetClient;

use Matthewbdaly\AkismetClient\Client;
use Matthewbdaly\AkismetClient\Exceptions\KeyNotSet;
use Matthewbdaly\AkismetClient\Exceptions\BlogNotSet;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClientSpec extends ObjectBehavior
{
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

    function it_can_verify_the_key()
    {
        $this->setKey('foo');
        $this->setBlog('http://example.com');
        $this->verifyKey()->shouldReturn(true);
    }
}
