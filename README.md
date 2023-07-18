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
