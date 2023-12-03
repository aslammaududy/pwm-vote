<?php

namespace App\Filament\Responses;

use App\Filament\Resources\CandidateResource;

class LoginResponse implements \Filament\Http\Responses\Auth\Contracts\LoginResponse
{

    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {
        if (!auth()->user()->is_admin) {
            return redirect()->intended(CandidateResource::getUrl('vote'));
        }

        return redirect()->intended();
    }
}
