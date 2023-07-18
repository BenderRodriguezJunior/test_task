<?php
/**
 * Загружает данные пользователей из базы данных на основе переданных идентификаторов пользователей.
 *
 * @param string $user_ids Строка с идентификаторами пользователей, разделенными запятыми.
 * @return array Ассоциативный массив с идентификаторами пользователей в качестве ключей и их именами в качестве значений.
 */
function load_users_data(string $user_ids) : array {
    $user_ids = explode(',', $user_ids);
    $data = array();

    // Установка соединения с базой данных
    $db = mysqli_connect("localhost", "root", "123123", "database");

    // Подготовка SQL-запроса для получения данных пользователей
    $stmt = $db->prepare("SELECT id, name FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    // Получение данных для каждого идентификатора пользователя
    foreach ($user_ids as $user_id) {

        // Выполнение подготовленного выражения
        $stmt->execute();

        // Получение результата выборки
        $result = $stmt->get_result();

        // Обработка результатов выборки и формирование ассоциативного массива
        while ($row = $result->fetch_assoc()) {
            $data[$row['id']] = $row['name'];
        }
    }

    // Закрытие соединения с базой данных
    mysqli_close($db);

    return $data;
}

// Загрузка данных пользователей на основе переданных идентификаторов
$data = load_users_data($_GET['user_ids']);

// Вывод ссылок на пользователей
foreach ($data as $user_id => $name) {
    echo "<a href=\"/show_user.php?id=$user_id\">$name</a>";
}
