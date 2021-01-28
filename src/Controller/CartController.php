<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart")
     */
    public function index(SessionInterface $session, ArticleRepository $articleRepository)
    {
        $panier = $session->get('panier', []);
        $panierAvecDonnees = [];

        foreach ($panier as $id => $quantity) {
            $panierAvecDonnees[] = [
                'article' => $articleRepository->find($id),
                'Quantité' => $quantity
            ];
        }

        $total = 0;

        foreach ($panierAvecDonnees as $produit) {
            $totalProduit = $produit['article']->getPrix() * $produit['Quantité'];
            $total += $totalProduit;
        }

        return $this->render('cart/index.html.twig', [
            'produits' => $panierAvecDonnees,
            'total' => $total,
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, SessionInterface $session, ArticleRepository $articleRepository)
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('tout_debut');
    }
    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute("cart");
    }

    /**
     * @Route("/panier/edit", name="cart_edit")
     */
    public function update(SessionInterface $session, ArticleRepository $articleRepository): Response
    {

        $user = $this->getUser();
        if($user == null){
            return $this->render('login2.html.twig');
        } else {

        $panier = $session->get('panier', []);
        foreach ($panier as $id => $quantity) {
            $entityManager = $this->getDoctrine()->getManager();
            $product = $entityManager->getRepository(Article::class)->find($id);
            $stockActuel= $articleRepository->find($id)->getStock();
            $product->setStock($stockActuel - $quantity);
            $entityManager->flush();
        }
        return $this->redirectToRoute('tout_debut');
        }
    }
}
