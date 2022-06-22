<?php
require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__) . "/Repository/ArticleRepository.php";
require_once dirname(__DIR__) . "/Repository/CategoryRepository.php";

class ArticleController extends AbstractController
{

    /**
     * @Route articles
     */
    public function index(): string
    {
        $articles = [];
        $articleRepository =  new ArticleRepository();
        $articles = $articleRepository->findAll();

        return $this->renderView("/template/article/article_base.phtml", ["articles" => $articles]);
    }

    /**
     * @Route show
     */
    public function show()
    {
        $article = null;
        if (isset($_GET["id"])) {
            $articleRepository = new ArticleRepository();
            $article = $articleRepository->find($_GET["id"]);
            $userRepository = new UserRepository();
            $user = $userRepository->find($article->getUser_id());
            $categoryRepository = new CategoryRepository();
            $categories = $categoryRepository->findByArticle($article);
        }
        return $this->renderView("/template/article/article_show.phtml", [
            "article" => $article,
            "user" => $user,
            "categories" => $categories
        ]);
    }
}
