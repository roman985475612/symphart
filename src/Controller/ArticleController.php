<?php

namespace App\Controller;

use App\Entity\Article;
//use http\Env\Request;
use Symfony\Component\Form\Extension\Core\Type\{TextType, TextareaType, SubmitType};
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ArticleController extends AbstractController {
    /**
     * @Route("/", name="article_list")
     * Method({"GET"})
     */
    public function index() {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/new", name="article_new")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $article = new Article();

        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('body', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, [
                'label' => 'Создать',
                'attr' => ['class' => 'btn btn-primary mt-3']])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render('articles/new.html.twig', [
           'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/{id}/update", name="article_update")
     * Method({"GET", "POST"})
     */
    public function update(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('body', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, [
                'label' => 'Создать',
                'attr' => ['class' => 'btn btn-primary mt-3']])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render('articles/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/{id}/show", name="article_show")
     */
    public function show($id) {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        return $this->render('articles/show.html.twig', ['article' => $article]);
    }

    /**
     * @Route("/article/{id}/delete", name="article_delete")
     * Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('article_list');
    }
}
