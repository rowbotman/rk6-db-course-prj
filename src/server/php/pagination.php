<?php
/**
 * Get page by get-attribute
 * @param string $model
 * @param string $action
 * @param int $page
 */
function get_page($model = 'search', $action = 'index', $page = 1)
{
    $model_name = 'Model';
    $action_name = 'get_';
    $model_name .= $model;
    $action_name .= $action;

    $model_file = strtolower('Model_'.$model) . '.php';
    $model_path = "models/" . $model_file;
    if (file_exists($model_path)) {
        include "models/" . $model_file;
    }
    $getter = new $model_name(10, $page);

    if (method_exists($getter, $action_name)) {
        $data = $getter->$action_name();
        $json = json_encode($data);
        echo $json;
    } else {
        (new Router)->ErrorPage404();
        echo $action;
    }
}
