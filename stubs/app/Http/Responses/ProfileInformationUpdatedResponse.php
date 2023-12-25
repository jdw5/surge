<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\ProfileInformationUpdatedResponse as ProfileInformationUpdatedResponseContract;
use Laravel\Fortify\Fortify;

class ProfileInformationUpdatedResponse implements ProfileInformationUpdatedResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return redirect()->back()->with('toast', 'Your profile information has been updated');
    }
}
