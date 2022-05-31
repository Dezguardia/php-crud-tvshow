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
    /**Ajouter un contenu CSS dans $this->head
     * @param string $css
     */
    public function appendCss(string $css): void
    {
        $style = "<style>".$css."</style>";
        $this->appendToHead($style);
    }
    /**Ajouter l'URL d'un script CSS dans $this->head
     * @param string $url L'URL du script CSS
     */
    public function appendCssUrl(string $url): void
    {
        $link = '<link rel="stylesheet" href="'.$url.'">';
        $this->appendToHead($link);
    }

}
