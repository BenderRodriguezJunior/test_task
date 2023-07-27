<?php

class Article
{
    private string $art_title;
    private string $art_content;
    private string $art_author;
    private int $art_author_id;

    public function __construct(string $title, string $content, object $User)
    {
        $this->art_title = $title;
        $this->art_content = $content;
        $this->art_author = $User->getName();
        $this->art_author_id = $User->getId();
    }

    public function get_title(): string
    {
        return $this->art_title;
    }

    public function get_author(): string
    {
        return $this->art_author;
    }

    public function get_author_id(): int
    {
        return $this->art_author_id;
    }

    public function get_content(): string
    {
        return $this->art_content;
    }

    function set_author($User): void
    {
        $this->art_author = $User->getName();
        $this->art_author_id = $User->getId();
    }
}

class User
{
    private int $user_id;
    private string $name;

    private array $storage;

    public function __construct($name)
    {
        $this->name = $name;
        $this->user_id = spl_object_id($this);
        $this->storage = [];
    }

    public function getId():string
    {
        return $this->user_id;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getArticles():array
    {
        return $this->storage;
    }

    public function makeArticle($title, $content): object
    {
        $user_art = new Article($title, $content, $this);
        $this->storage[] = $user_art;
        return $user_art;

    }

    public function changeAuthor(object $Article, object $User): void
    {
        if ($this->user_id == $Article->get_author_id()) {
            $Article->set_author($User);
            $User->storage[] = $Article;
            foreach ($this->storage as $key => $item){
                if ($item == $Article){
                    unset($this->storage[$key]);
                }
            }

        } else {
            var_dump("Статья не принадлежит автору.");
        }
    }
}


$user1 = new User('Гомер');
$user2 = new User('Эзоп');
$user3 = new User('Евклид');

var_dump($user1);
var_dump($user2);
var_dump($user3);

$first_art = $user1->makeArticle("Заголовок 1", "бла-бла-бла");
$second_art = $user2->makeArticle("Заголовок 2", "бла-бла-бла-бла");
$third_art = $user3->makeArticle("Заголовок 3", "бла-бла-бла-бла-бла");

$user1->changeAuthor($first_art, $user2);
$user2->changeAuthor($second_art, $user3);
$user3->changeAuthor($third_art, $user1);

var_dump($user1);
var_dump($user2);
var_dump($user3);