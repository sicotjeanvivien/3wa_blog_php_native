<?php

class Category
{
    /**
     * @var int $id
     */
    private int $id;

    /**
     *@var string $name
     */
    private string $name;

    public function __construct()
    {
    }

    /**
     * Get $id
     *
     * @return  int 
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get *@var string $name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set *@var string $name
     *
     * @return  void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
