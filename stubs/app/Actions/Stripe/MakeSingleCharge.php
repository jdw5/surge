<?php

namespace App\Actions\Stripe;

use App\Actions\Stripe\Contracts\MakesSingleCharge;

class MakeSingleCharge implements MakesSingleCharge
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function charge(array $input)
    {
        //
    }
}
