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
    /**Ajouter un contenu JS dans $this->head
     * @param string $js
     */
    public function appendJs(string $js): void
    {
        $script= '<script type="text/javascript">'.$js.'</script>';
        $this->appendToHead($script);
    }

    /**Ajouter l'URL d'un script JS dans $this->head
     * @param string $js
     */
    public function appendJsUrl(string $js): void
    {
        $script= '<script type="text/javascript" src="'.$js.'"></script>';
        $this->appendToHead($script);
    }
    /**Ajouter un contenu dans $this->body
     * @param string $content
     */
    public function appendContent(string $content): void
    {
        $this->body.=$content;
    }
    /**Produire la page web complète
     * @return string
     */
    public function toHTML(): string
    {
        return '<!doctype html><html lang="fr"><head>'.$this->head.'<meta charset="utf-8"><meta name="viewport"><title>'.$this->title.'</title></head><body>'.$this->body.'<div id="foot"> '.$this->getLastModification().'</div></body></html>';
    }
    /**Donner la date et l'heure de la dernière modification du script principale
     * @return string
     */
    public static function getLastModification(): string
    {
        $date= date("d/m/Y");
        $min= date("H:m:s");
        return "<div style='text-align: right'>Dernière modification de cette page le $date à $min</div>";
    }

}
