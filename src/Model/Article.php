<?php

class Article
{
    /**
     * @var int $id
     */
    private int $id;

    /**
     *@var string|null $title 
     */
    private ?string $title;

    /**
     * @var string|null $content
     */
    private ?string $content;

    /**
     * @var string|null $date_published
     */
    private string $date_published;

    /**
     * @var int|null $user_id reference User(id)
     */
    private int $user_id;

    /**
     * Get the value of id
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * Get the value of content
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Get the value of date_published
     */
    public function getDate_published(): DateTime
    {
        return new DateTime($this->date_published);
    }

    /**
     * Set the value of date_published
     *
     * @return  self
     */
    public function setDate_published(string $date_published): void
    {
        $this->date_published = $date_published;
    }

    /**
     * Get the value of user_id
     */
    public function getUser_id(): int
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id(int $user_id): void
    {
        $this->user_id = $user_id;
    }
}
