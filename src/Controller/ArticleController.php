<?php
require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__) . "/Repository/ArticleRepository.php";
require_once dirname(__DIR__) . "/Repository/CategoryRepository.php";
require_once dirname(__DIR__) . "/service/Service.php";

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
            $userRepository = new UserRepository();
            $categoryRepository = new CategoryRepository();
            $article = $articleRepository->find($_GET["id"]);
            $user = $userRepository->find($article->getUser_id());
            $categories = $categoryRepository->findByArticle($article);
        }
        return $this->renderView("/template/article/article_show.phtml", [
            "article" => $article,
            "user" => $user,
            "categories" => $categories
        ]);
    }

    /**
     * @Route article_add
     */
    public function add()
    {
        // Checked if user is connected
        if (
            Service::checkIfUserIsConnected()
        ) {
            $error = null;
            $message =  "";
            $categoryRepository = new CategoryRepository();
            $articleRepository = new ArticleRepository();
            if (
                !empty($_POST)
                && isset($_POST["title"], $_POST["content"], $_POST["categories"])
                && $_FILES["img"]
            ) {
                if (
                    strlen($title = trim($_POST["title"]))
                    && strlen($content = trim($_POST["content"]))
                    && count($categories = $_POST["categories"])
                    && $filePath = Service::moveFile($_FILES["img"])
                ) {
                    $article =  new Article();
                    $article->setTitle($title);
                    $article->setContent($content);
                    $article->setDate_published((new DateTime("now"))->format("Y-m-d H:i:s"));
                    $article->setUser_id($_SESSION["user_id"]);
                    $article->setFile_path_image($filePath);
                    $articleRepository->add($article);
                    $article = $articleRepository->findLast();
                    $categories = Service::checkCategoriesExist($_POST["categories"]);

                    foreach ($categories as $key => $category) {
                        $articleRepository->insertCategory($article, $category);
                    }
                    header("Location: /?page=article");
                }
            }
            return $this->renderView("/template/article/article_add.phtml", [
                "error" => $error,
                "message" => $message,
                "categories" => $categoryRepository->findAll()
            ]);
        }
        header("Location: /?page=home");
    }
}
