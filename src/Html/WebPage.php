<?php
declare(strict_types=1);
namespace Html;

class WebPage
{
    private string $head;
    private string $title;
    private string $body;

    /**
     * WebPage constructor.
     * @param string $title Titre de la page
     */
    public function __construct(string $title = "")
    {
        $this->title = $title;
        $this->head = "";
        $this->body = "";
    }

    /**
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**Affecter le titre de la page
     * @param string $title le titre
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    /**Ajouter un contenu dans $this->body
     * @param string $content
     */
    public function appendToHead(string $content): void
    {
        $this->head.=$content;
    }

}
