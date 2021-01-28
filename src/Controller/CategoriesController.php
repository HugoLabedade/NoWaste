<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories/{categorie}", name="categories")
     */
    public function categorie(string $categorie, Article $article, ArticleRepository $articleRepository): Response
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->findBy([
            'categorie' => $categorie
        ]);

        $user = $this->getUser();
        if ($user == null) {
            return $this->render('categories/index2.html.twig', [
                'articles' => $article,
            ]);
        } else {
        return $this->render('categories/index.html.twig', [
            'articles' => $article,
        ]);
        }
    }
}
