<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/search")
 */
class SearchBarController extends AbstractController
{
    /**
     * @Route("/resultat", name="search_bar")
     * @param $request
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ArticleRepository $articleRepository, Request $request) :Response
    {

        $recherche = $request->get('recherche');
        
        $article= $articleRepository->search($recherche);
        $user = $this->getUser();
        if ($user == null) {
            return $this->render('search_bar/index.html.twig', [
            'article' => $article,
        ]);
        } else {
            return $this->render('search_bar/index2.html.twig', [
            'article' => $article,
        ]);
        }
    }
}
