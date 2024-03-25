<?php

namespace App\Http\Responses;

use App\Filament\Resources\ResearchResource;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse extends \Filament\Http\Responses\Auth\LoginResponse
{
public function toResponse($request): RedirectResponse|Redirector
{
// Here, you can define which resource and which page you want to redirect to
    $role=auth()->user()->role_id;
    $path='/';
    if ($role==1)$path='/';
    if ($role==2)$path='/my-researches';
    if ($role==3)$path='/teacher-researches';
    if ($role==4)$path='/research';
return redirect($path);
}
}
