<?php

class User
{

    /**
     * @param int $id
     */
    private int $id;

    /**
     * @param string $lastname
     */
    private string $lastname;

    /**
     * @param string $firstname
     */
    private string $firstname;

    /**
     * @param string $username
     */
    private string $username;

    /**
     * @param string $password
     */
    private string $password;

    public function __construct()
    {
    }

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of lastname
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  void
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * Get the value of firstname
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  void
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * Get the value of username
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;

    }
}
