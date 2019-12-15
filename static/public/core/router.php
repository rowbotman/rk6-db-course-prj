<?php

class Router
{
    public static $prev_url = '/';

    /**
     *
     */
    static function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = 'Menu';
        $action_name = 'index';
        $current_url = $_SERVER['REQUEST_URI'];
        $without_symb = explode('?', $_SERVER['REQUEST_URI']);
        $routes = explode('/', $without_symb[0]);
        $is_auth = false;

        if ($routes[1] != 'ajax') {
            // получаем имя контроллера
            if (!empty($routes[1])) {
                $controller_name = $routes[1];
            }

            // получаем имя экшена
            if (!empty($routes[2])) {
                $action_name = $routes[2];
            }

            // добавляем префиксы
            $model_name = 'Model_' . $controller_name;
            $controller_name = 'Controller_' . $controller_name;
            $action_name = 'action_' . $action_name;

            // подцепляем файл с классом модели (файла модели может и не быть)

            $model_file = strtolower($model_name) . '.php';
            $model_path = "static/public/models/" . $model_file;

            if (file_exists($model_path)) {
                include "static/public/models/" . $model_file;
            }

            // подцепляем файл с классом контроллера
            $controller_file = strtolower($controller_name) . '.php';
            $controller_path = "static/public/controllers/" . $controller_file;
            if (file_exists($controller_path)) {
                include "static/public/controllers/" . $controller_file;
            } else {
                /*
                 * правильно было бы кинуть здесь исключение,
                 * но для упрощения сразу сделаем редирект на страницу 404
                 */
                (new Router)->ErrorPage404();
                echo '404 Not Found';
            }

            // создаем контроллер
            $controller = new $controller_name;
            $action = $action_name;

            if (method_exists($controller, $action)) {
                // вызываем действие контроллера
                self::$prev_url = '/' . $routes[1];
                $controller->$action();
            } else {
                // здесь также разумнее было бы кинуть исключение
                (new Router)->ErrorPage404();
                echo $action;
            }
        } else {
            include 'static/public/php/pagination.php';
            get_page($routes[2], $routes[3], $_GET['page']);
        }
    }

    function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}
