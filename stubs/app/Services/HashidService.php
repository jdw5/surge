<?php

namespace App\Services;

use Hashids\Hashids;


class HashidService
{
    /**
     * @var Hashids
     */
    private $hashids;

    /**
     * HashidService constructor.
     */
    public function __construct(string $salt = config('app.name'), int $length = 12)
    {
        $this->hashids = new Hashids($salt, $length);
    }

    /**
     * @param $id
     * @return string
     */
    public function encode($id)
    {
        return $this->hashids->encode($id);
    }

    /**
     * @param $hash
     * @return array
     */
    public function decode($hash)
    {
        if(is_int($hash))
            return $hash;
        return $this->hashids->decode($hash)[0];
    
    }
}