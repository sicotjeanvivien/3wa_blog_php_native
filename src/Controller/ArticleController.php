<?php
require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__) . "/Repository/ArticleRepository.php";

class ArticleController extends AbstractController
{

    public function index(): string
    {
        $articles = [];
        $articleRepository =  new ArticleRepository();
        $articles = $articleRepository->findAll();
        return $this->renderView("/template/article/article_base.phtml", ["articles" => $articles]);
    }
}
