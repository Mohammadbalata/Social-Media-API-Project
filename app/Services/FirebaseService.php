<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected Factory $firebase;

    public function __construct(Factory $firebase)
    {
        $this->firebase = $firebase;
    }

    public function getAuth(): \Kreait\Firebase\Contract\Auth
    {
        return $this->firebase->createAuth();
    }

    public function getMessaging(): \Kreait\Firebase\Contract\Messaging
    {
        return $this->firebase->createMessaging();
    }
}
