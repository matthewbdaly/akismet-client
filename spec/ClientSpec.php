<?php

namespace spec\Matthewbdaly\AkismetClient;

use Matthewbdaly\AkismetClient\Client;
use Matthewbdaly\AkismetClient\Exceptions\KeyNotSet;
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

    function it_can_verify_the_key()
    {
        $this->setKey('foo');
        $this->verifyKey()->shouldReturn(true);
    }

    function it_throws_an_exception_if_key_invalid()
    {
        $this->shouldThrow(KeyNotSet::class)->duringVerifyKey();
    }
}
