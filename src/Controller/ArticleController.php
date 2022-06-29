<?php
require_once dirname(__DIR__, 2) . "/lib/Controller/AbstractController.php";
require_once dirname(__DIR__) . "/Repository/ArticleRepository.php";
require_once dirname(__DIR__) . "/Repository/CategoryRepository.php";
require_once dirname(__DIR__) . "/Repository/ArticleCategoryRepository.php";
require_once dirname(__DIR__) . "/service/Service.php";

class ArticleController extends AbstractController
{

    /**
     * @var ArticleRepository $articleRepository
     */
    private ArticleRepository $articleRepository;

    /**
     * @var CategoryRepository $categoryRepository
     */
    private CategoryRepository $categoryRepository;
   
    /**
     * @var ArticleCategoryRepository $articleCategoryRepository
     */
    private ArticleCategoryRepository $articleCategoryRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->articleCategoryRepository = new ArticleCategoryRepository();
    }

    /**
     * @Route articles
     */
    public function index(): string
    {
        return $this->renderView("/template/article/article_base.phtml", [
            "articles" => $this->articleRepository->findAll()
        ]);
    }

    /**
     * @Route show
     */
    public function show()
    {
        $article = null;
        if (isset($_GET["id"])) {
            $userRepository = new UserRepository();
            $categoryRepository = new CategoryRepository();
            $article = $this->articleRepository->find($_GET["id"]);
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
                    $this->articleRepository->add($article);
                    $article = $this->articleRepository->findLast();
                    $categories = Service::checkCategoriesExist($_POST["categories"]);

                    foreach ($categories as $key => $category) {
                        $this->articleRepository->insertCategory($article, $category);
                    }
                    header("Location: /?page=article");
                }
            }
            return $this->renderView("/template/article/article_add.phtml", [
                "error" => $error,
                "message" => $message,
                "categories" => $this->categoryRepository->findAll()
            ]);
        }
        header("Location: /?page=home");
    }

    /**
     * @Route article_deleted
     */
    public function deleted()
    {
        if (
            Service::checkIfUserIsConnected()
            && isset($_GET["article_id"])
            && $article = $this->articleRepository->find($_GET["article_id"])
        ) {
            //supprime l'image lié à l'article 
            unlink(dirname(__DIR__, 2) . "/public/" . $article->getFile_path_image());
            // supprime l'article
            $this->articleCategoryRepository->deleteByArticle($article);
            $this->articleRepository->deleted($article);
            // Redirect vers la page listant les articles 
            header("Location: /?page=article");
        }
    }

    /**
     * @Route article_update 
     */
    public function update()
    {
        // Vérification de l'existence de l'article passé en paramètre d'url et déclaration, assignation de article 
        if (
            isset($_GET["article_id"])
            && $article = $this->articleRepository->find($_GET["article_id"])
        ) {
            // Vérification validé des data pour l'article
            if (
                $_POST
                && isset($_POST["title"], $_POST["content"], $_POST["categories"])
                && strlen($title = trim($_POST["title"]))
                && strlen($content = trim($_POST["content"]))
                && count($categories = $_POST["categories"])
            ) {
                $article->setTitle($title);
                $article->setContent($content);
                if ($_FILES["img"]["size"]) {
                    $file_path_image = Service::moveFile($_FILES["img"]);
                    if ($file_path_image) {
                        unlink(dirname(__DIR__, 2) . "/public/" . $article->getFile_path_image());
                        $article->setFile_path_image($file_path_image);
                    }
                }
                $this->articleRepository->update($article);
                // suppression des article_category 
                $this->articleCategoryRepository->deleteByArticle($article);
                // création des nouveaux article_category 
                $categories = Service::checkCategoriesExist($_POST["categories"]);
                foreach ($categories as $key => $category) {
                    $this->articleRepository->insertCategory($article, $category);
                }
                
            }
            return $this->renderView(
                "/template/article/article_update.phtml",
                [
                    "article" => $article,
                    "categories" => $this->categoryRepository->findAll(),
                    "article_category" => $this->categoryRepository->findByArticle($article)
                ]
            );
        }
        header("Location: /?page=home");
    }
}
