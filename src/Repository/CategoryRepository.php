<?php

require_once dirname(__DIR__, 2) . "/lib/Repository/AbstractRepository.php";
require_once dirname(__DIR__) . "/Model/Category.php";
require_once dirname(__DIR__) . "/Model/Article.php";

class CategoryRepository extends AbstractRepository
{

    /**
     * @param User $user prend en paramètre un onject User
     * @return arrayCollection Category 
     */
    public function findByArticle(Article $article): mixed
    {
        $query = "SELECT id, name FROM category 
                  INNER JOIN article_category ON category.id = article_category.category_id 
                  WHERE article_category.article_id = :article_id;";
        $params = [":article_id" => $article->getId()];
        return $this->executeQuery($query, "Category", $params) ?? [];
    }

    /**
     * @return arrayCollection category
     */
    public function findAll(): mixed
    {
        $query = "SELECT * FROM category;";
        return $this->executeQuery($query, "Category");
    }

    /**
     * @param array ["categories1_id", categories2_id] $categories
     * @return mixed array|null|category
     */
    public function find(int $id): mixed
    {
        $query = "SELECT * FROM category WHERE id = :id;";
        $params = [":id" => $id];
        return  $this->executeQuery($query, "Category", $params);
    }
}
