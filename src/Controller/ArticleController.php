<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController {
    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function index() {
        return $this->render('articles/index.html.twig', [
            'name' => 'Роман',
            'articles' => ['Статья 1', 'Статья 2']
        ]);
    }
}
