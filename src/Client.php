<?php

namespace Matthewbdaly\AkismetClient;

use Matthewbdaly\AkismetClient\Exceptions\KeyNotSet;

class Client
{
    protected $key;

    public function verifyKey()
    {
        if (!$this->key) {
            throw new KeyNotSet;
        }
        return true;
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
}
