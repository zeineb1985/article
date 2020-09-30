<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog")
     */
    public function index(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findByCategory();
        dump($articles);die;
        $articles = $articleRepository->findAll();
        return $this->render('blog/index.html.twig', [

            'articles' => $articles
        ]);
    }

    /**
     * @Route("/create-article", name="create-article")
     */
    public function newArticle(Request $request)
    {

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if (($form->isSubmitted()) && ($form->isValid())) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('blog');

        }
        return $this->render('blog/new.html.twig', [
            'form' => $form->createView()

        ]);


    }

}
