<?php

require_once dirname(__DIR__) . "/Model/Article.php";
require_once dirname(__DIR__) . "/Model/Category.php";

class ArticleCategoryRepository extends AbstractRepository
{
    /**
     * @param Article $article
     */
    public function deleteByArticle(Article $article)
    {
        // supprime les lignes de article_category lié à l'article supprimé
        $query = "DELETE FROM article_category WHERE article_id = :article_id;";
        $params = [
            ":article_id" => $article->getId()
        ];
        $this->executeQuery($query, "article", $params);
    }
}
