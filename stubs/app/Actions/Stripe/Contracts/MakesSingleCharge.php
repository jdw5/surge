<?php

namespace App\Actions\Stripe\Contracts;

interface MakesSingleCharge
{
    /**
     * Make the charge against the user
     *
     * @param  array  $input
     * @return \Illuminate\Foundation\Auth\User
     */
    public function charge(array $input);
}
