<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaires;
use App\Form\ArticleType;
use App\Form\CommentaireFormType;
use App\Form\SearchArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleController extends AbstractController

{
    /**
     * @Route("/debut", name="tout_debut")
     */
    public function index(ArticleRepository $articleRepository, Request $request): Response
    {
        $form = $this->createForm(SearchArticleType::class);
        $search = $form->handleRequest($request);

        $user = $this->getUser();
        if ($user == null) {
            return $this->render('article/index2.html.twig', [
                'article' => $articleRepository->findAll(),
                'form' => $form->createView()
            ]);
        } else {
        return $this->render('article/index3.html.twig', [
            'article' => $articleRepository->findAll(),
            'form' => $form->createView()
        ]);
        }
    }
    /**
     * @Route("/crud", name="article_index")
     */
    public function crud(ArticleRepository $articleRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser()->getId();
        if($user != '3'){
            return $this->redirectToRoute('tout_debut');
        } else {
            return $this->render('article/index.html.twig', [
                'articles' => $articleRepository->findAll(),
            ]);
        }

    }

    /**
     * @Route("/article/new", name="article_nouveau", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $article->setImage($newFilename);
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_vue", methods={"GET", "POST"})
     */
    public function show(int $id, Article $article, ArticleRepository $articleRepository, Request $request): Response
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->findOneBy([
            'id' => $id
        ]);
        $commentaire = new Commentaires();
        $form = $this->createForm(CommentaireFormType::class, $commentaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $commentaire->setArticle($article);
            $commentaire->setCreatedAt(new \DateTime('now'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();
        }

        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Article::class)->find($id);
        $stock = $articleRepository->find($id)->getStock();


        $user = $this->getUser();
        if ($user == null) {
        if ($stock == 0) {
            return $this->render('article/show2.html.twig', [
                'article' => $article,
                'formComment' => $form->createView(),
            ]);
        } else {
            return $this->render('article/show.html.twig', [
                'article' => $article,
                'formComment' => $form->createView(),
            ]);
        }
        } else {
            if ($stock == 0) {
                return $this->render('article/show4.html.twig', [
                    'article' => $article,
                    'formComment' => $form->createView(),
                ]);
            } else {
                return $this->render('article/show3.html.twig', [
                    'article' => $article,
                    'formComment' => $form->createView(),
                ]);
            }
        }
    }

    /**
     * @Route("/article/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}/delete", name="article_delete", methods={"GET"})
     */
    public function delete(Request $request, Article $article): Response
    {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
    

        return $this->redirectToRoute('article_index');
    }
}
