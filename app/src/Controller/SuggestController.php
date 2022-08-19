<?php

namespace App\Controller;

use App\Repository\KittyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuggestController extends AbstractController
{
    #[Route('/suggest', name: 'suggest_kitty')]
    public function __invoke(KittyRepository $kittyRepository): Response
    {
        return $this->render('suggestion.html.twig', [
            'kitty' => $kittyRepository->findRandomKitty()
        ]);
    }
}