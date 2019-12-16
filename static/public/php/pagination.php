<?php
/**
 * Get page by get-attribute
 * @param string $model
 * @param string $action
 * @param int $page
 */
function get_page($model = 'search', $action = 'index')
{
    $model_name = 'Model';
    $action_name = 'get_';
    $model_name .= $model;
    $action_name .= $action;

    $model_file = strtolower('Model_'.$model) . '.php';
    $model_path = "static/public/models/" . $model_file;
    if (file_exists($model_path)) {
        include "static/public/models/" . $model_file;
    }
    $getter = null;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        $getter = new $model_name(10, $page);
    } else {
        $getter = new $model_name();
    }

    if (method_exists($getter, $action_name)) {
        $data = null;
        if (isset($_GET['ticket_id'])) {
            $data = $getter->$action_name($_GET['ticket_id']);
        } else {
            $data = $getter->$action_name();
        }
        $json = json_encode($data);
        echo $json;
    } else {
        (new Router)->ErrorPage404();
        echo $action;
    }
}

function delete_row($model = 'update', $action = 'delete', $id)
{
    $model_name = 'Model';
    $action_name = '';
    $model_name .= $model;
    $action_name .= $action;

    $model_file = strtolower('Model_'.$model) . '.php';
    $model_path = "static/public/models/" . $model_file;
    if (file_exists($model_path)) {
        include "static/public/models/" . $model_file;
    }
    $getter = new $model_name();

    if (method_exists($getter, $action_name)) {
        $data = $getter->$action_name($id);
        $json = json_encode($data);
        echo $json;
    } else {
        (new Router)->ErrorPage404();
        echo $action;
    }
}
