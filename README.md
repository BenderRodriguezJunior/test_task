## Задача №2 ##
Имеется строка:

https://www.somehost.com/test/index.html?param1=4&param2=3&param3=2&param4=1&param5=3

Напишите функцию, которая:
1. удалит параметры со значением “3”;
2. отсортирует параметры по значению;
3. добавит параметр url со значением из переданной ссылки без параметров (в примере:
   /test/index.html);
4. сформирует и вернёт валидный URL на корень указанного в ссылке хоста.
   В указанном примере функцией должно быть возвращено:

https://www.somehost.com/?param4=1&param3=2&param1=4&url=%2Ftest%2Findex.html

### Решение: ###

[Файл с решением.](https://github.com/BenderRodriguezJunior/test_task/blob/main/src/task_2.php)

```php
<?php
function processURL($url): string {
    // Удаляем параметры со значением "3"
    $urlParts = parse_url($url);
    parse_str($urlParts['query'], $params);
    $params = array_filter($params, function ($value) {
        return $value !== '3';
    });

    // Сортируем параметры по значению
    asort($params);

    // Добавляем параметр "url" со значением из переданной ссылки без параметров
    $path = $urlParts['path'];
    $params['url'] = $path;

    // Формируем и возвращаем валидный URL на корень указанного в ссылке хоста
    $query = http_build_query($params);
    $result = $urlParts['scheme'] . '://' . $urlParts['host'] . '/?' . $query;
    return $result;
}

$url = "https://www.somehost.com/test/index.html?param1=4&param2=3&param3=2&param4=1&param5=3";
$expected_output = "https://www.somehost.com/?param4=1&param3=2&param1=4&url=%2Ftest%2Findex.html";
$actual_output = processURL($url);

var_dump($actual_output == $expected_output);

echo $actual_output;
```
---
## Задача №3 ##
Напишите код в парадигме ООП, соответствующий следующей структуре.  
__Сущности:__ Пользователь, Статья

__Связи:__
- Один пользователь может написать несколько статей.
- У каждой статьи может быть только один пользователь-автор.

__Функциональность:__
- возможность для пользователя создать новую статью;
- возможность получить автора статьи;
- возможность получить все статьи конкретного пользователя;
- возможность сменить автора статьи.

Если вы применили какие-либо паттерны при написании, укажите какие и с какой целью.  
Код, реализующий конкретную функциональность, не требуется, только общая структура классов и методов.  
Код должен быть прокомментирован в стиле PHPDoc.

### Решение: ###

[Файл с решением.](https://github.com/BenderRodriguezJunior/test_task/blob/main/src/task_3.php)

```php
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
```
---
## Задача №4 ##

Проведите рефакторинг, исправьте баги и продокументируйте в стиле PHPDoc код,
приведённый ниже (таблица users здесь аналогична таблице users из задачи №1).  
_Примечание: код написан исключительно в тестовых целях, это не "жизненный пример" :)_

```php
<?php
function load_users_data($user_ids) {
    $user_ids = explode(',', $user_ids);
    foreach ($user_ids as $user_id) {
        $db = mysqli_connect("localhost", "root", "123123", "database");
        $sql = mysqli_query($db, "SELECT * FROM users WHERE id=$user_id");
        while ($obj = $sql->fetch_object()) {
            $data[$user_id] = $obj->name;
        }
        mysqli_close($db);
    }
    return $data;
}

// Как правило, в $_GET['user_ids'] должна приходить строка
// с номерами пользователей через запятую, например: 1,2,17,48
$data = load_users_data($_GET['user_ids']);
foreach ($data as $user_id => $name) {
    echo "<a href=\"/show_user.php?id=$user_id\">$name</a>";
}
```

### Решение: ###

В представленном коде могут быть следующие недостатки:

- код не использует подготовленные выражения для выполнения SQL-запросов с параметрами;
- код не выполняет валидацию и обработку входных данных;
- подключение к БД устанавливается для каждого user_id в цикле foreach, что приводит к излишней нагрузке на БД;
- отсутствует контроль над доступом к данным;
- при использовании fetch_object() отсутствует проверка, что результат запроса содержит объект, 
что может спровоцировать ошибку если запрос вернет пустой результат или данные другого типа;

[Файл с решением.](https://github.com/BenderRodriguezJunior/test_task/blob/main/src/task_4.php)

Внесены следующие изменения:

- подключение к базе данных вынесено за пределы цикла, чтобы избежать множественных подключений;
- добавлено использование подготовленных выражений (Prepared Statements);
- результат запроса получается в виде массива вместо использования объекта;
- подключение к базе данных закрывается после использования;
- добавлено $data = array() перед циклом для избежания возможных ошибок, если нет пользователей в запросе;