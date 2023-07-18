<?php
class User {
    /**
     * @var int Идентификатор пользователя.
     */
    private $user_id;

    /**
     * @var string Имя пользователя.
     */
    private $name;

    /**
     * Конструктор пользователя.
     *
     * @param int    $user_id Идентификатор пользователя.
     * @param string $name    Имя пользователя.
     */
    public function __construct($user_id, $name) {
        $this->user_id = $user_id;
        $this->name = $name;
    }

    /**
     * Создание новой статьи пользователем.
     *
     * @param string $title   Заголовок статьи.
     * @param string $content Содержимое статьи.
     *
     * @return Article Созданная статья.
     */
    public function createArticle($title, $content) {
        $article = new Article($title, $content, $this);
        return $article;
    }

    /**
     * Получение всех статей пользователя.
     *
     * @return array Список статей пользователя.
     */
    public function getArticles() {
        // Реализация получения статей пользователя
    }
}

class Article {
    /**
     * @var string Заголовок статьи.
     */
    private $title;

    /**
     * @var string Содержимое статьи.
     */
    private $content;

    /**
     * @var User Автор статьи.
     */
    private $author;

    /**
     * Конструктор статьи.
     *
     * @param string $title   Заголовок статьи.
     * @param string $content Содержимое статьи.
     * @param User   $author  Автор статьи.
     */
    public function __construct($title, $content, $author) {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
    }

    /**
     * Получение автора статьи.
     *
     * @return User Автор статьи.
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Смена автора статьи.
     *
     * @param User $new_author Новый автор статьи.
     */
    public function changeAuthor($new_author) {
        $this->author = $new_author;
    }
}