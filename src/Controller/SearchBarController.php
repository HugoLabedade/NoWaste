<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchBarController extends AbstractController
{
    /**
     * @Route("/search/resultat", name="search_bar")
     */
    public function index(ArticleRepository $articleRepository, Request $request): Response
    {
        $recherche = $_POST['recherche'];

        $article= $articleRepository->search($recherche);

        return $this->render('search_bar/index.html.twig', [
            'article' => $article,
        ]);
    }
}
