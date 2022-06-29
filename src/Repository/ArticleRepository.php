<?php

require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__) . "/Model/Article.php";

class ArticleRepository extends AbstractRepository
{

    /**
     * @param string $id article 
     * @return Article|null
     */
    public function find(string $id)
    {
        $query = "SELECT * FROM article WHERE id = :id";
        $params = [":id" => $id];

        return  $this->executeQuery($query, "Article", $params);
    }

    /**
     * @return array collection Article
     */
    public function findAll()
    {
        $query = "SELECT * FROM article;";
        return $this->executeQuery($query, "Article");
    }

    /**
     * @param Article $article
     * @return void
     */
    public function add(Article $article)
    {
        $query = "INSERT INTO article(title, content, date_published, user_id, file_path_image) 
                  VALUES(:title, :content, :date_published, :user_id, :file_path_image);";
        $params = [
            ":title" => $article->getTitle(),
            ":content" => $article->getContent(),
            ":date_published" => $article->getDate_published()->format("Y-m-d H:i:s"),
            ":user_id" => $article->getUser_id(),
            ":file_path_image" => $article->getFile_path_image()
        ];

        return $this->executeQuery($query, "Article", $params);
    }

    /**
     * @param string $id article 
     * @return Article|null
     */
    public function findLast()
    {
        $query = "SELECT * FROM article ORDER BY id DESC LIMIT 1;";
        return  $this->executeQuery($query, "Article");
    }

    /**
     * @param Article $article 
     * @param Category $category
     * @return void
     */
    public function insertCategory(Article $article, Category $category)
    {
        $query = "INSERT INTO article_category(article_id, category_id) 
                  VALUES(:article_id, :category_id);";
        $params = [
            ":article_id" => $article->getId(),
            "category_id" => $category->getId()
        ];
        return  $this->executeQuery($query, "", $params);
    }

    /**
     * @param Article $article
     */
    public function deleted(Article $article)
    {
        // supprime la ligne de l'article
        $query = "DELETE FROM article WHERE id = :id";
        $params = [
            ":id" => $article->getId()
        ];
        return $this->executeQuery($query, "article", $params);
    }

    /**
     * @param Article $article
     */
    public function update(Article $article)
    {
        $query = "UPDATE article SET 
                    title = :title, 
                    content = :content, 
                    file_path_image= :file_path_image 
                WHERE id = :id;";
        $params = [
            ":id" => $article->getId(),
            ":title" => $article->getTitle(),
            ":content" => $article->getContent(),
            ":file_path_image" => $article->getFile_path_image()
        ];
        return $this->executeQuery($query, "Article", $params);
    }
}
