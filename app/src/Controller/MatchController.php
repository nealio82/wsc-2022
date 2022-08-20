<?php

namespace App\Controller;

use App\Message\MatchNotification;
use App\Repository\KittyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    #[Route('/match/{kittyId}', name: 'match')]
    public function __invoke(
        KittyRepository $kittyRepository,
        MessageBusInterface $messageBus,
        int $kittyId
    ): Response
    {
        $match = $kittyRepository->find($kittyId);

        $messageBus->dispatch(new MatchNotification($kittyId));

        $this->addFlash(
            'notice',
            'You matched with ' . $match->getName()
        );

       return $this->redirectToRoute('suggest_kitty');
    }
}