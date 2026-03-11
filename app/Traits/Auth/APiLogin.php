<?php

namespace App\Traits\Auth;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

trait APiLogin
{
    // This trait can be used to handle API login functionality

    public function generateToken(Authenticatable $user):string
    {
        return  $user->createToken('my-app-token')->plainTextToken;

    }

    public function revokeToken(Authenticatable $user):void
    {
        $user->tokens()->delete();
    }

   public function checkCredentials(array $credentials ):?Authenticatable
   {
       return $this->userService->findByEmail($credentials['email']);
   }
}