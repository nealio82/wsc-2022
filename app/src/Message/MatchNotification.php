<?php

namespace App\Message;

class MatchNotification
{
    public function __construct(
        public readonly int $kittyId
    )
    {
    }
}