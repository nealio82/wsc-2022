<?php

namespace App\Controller;

use App\Repository\KittyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    #[Route('/match/{kittyId}', name: 'match')]
    public function __invoke(KittyRepository $kittyRepository, int $kittyId): Response
    {
        $match = $kittyRepository->find($kittyId);

        $this->addFlash(
            'notice',
            'You matched with ' . $match->getName()
        );

       return $this->redirectToRoute('suggest_kitty');
    }
}