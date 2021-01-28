<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;

class ReportingController extends AbstractController
{
    /**
     * @Route("/reporting", name="reporting")
     */
    public function crud(ArticleRepository $articleRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser()->getId();
        /* dd($user); */
        if ($user != '3') {
            return $this->redirectToRoute('tout_debut');
        } else {
            return $this->render('article/index.html.twig', [
                'articles' => $articleRepository->findAll(),
            ]);
        }

        


    }
}
