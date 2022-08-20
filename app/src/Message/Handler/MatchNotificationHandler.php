<?php

namespace App\Message\Handler;

use App\Entity\Kitty;
use App\Message\MatchNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class MatchNotificationHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function __invoke(
        MatchNotification $message,
    )
    {
        $kitty = $this->entityManager
            ->getRepository(Kitty::class)
            ->find($message->kittyId);

        $kitty->incrementMatches();

        $this->entityManager->persist($kitty);
        $this->entityManager->flush();
    }
}