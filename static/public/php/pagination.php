<?php
//$page = $_GET['page'];
//$limit_l = ($page - 1) * 10;
//$limit_h = $page * 10;
//$sql = 'SELECT f.uid AS flight, MONTH(f.dep_date) AS month, t.class, COUNT(t.uid) AS tickets_num FROM ticket t
//JOIN flight f ON (t.flight_id = f.uid) WHERE YEAR(f.dep_date) = ?
//GROUP BY flight, month, t.class ORDER BY tickets_num DESC LIMIT '.$limit_l.','.$limit_h.';';
//$data = DataBase::paramQuery($sql, 2012);
//$json = json_encode($data);
//echo $json;
//echo "[{\"text\": [ {\"row\": [{\"file\": \"hello page $page\"}]}, {\"row\": [{\"file\": \"hello page $page\"}]}]}]";
/**
 * Get page by get-attribute
 * @param string $model
 * @param string $action
 * @param int $page
 */
function get_page($model = 'search', $action = 'index', $page = 1)
{
    //if ($controller == 'searc$controllerh') {
    //        $model_name +=
    //    } elseif ($controller == 'report') {
    //        // do something else
    //    } else {
    //        // redirect on 404 page1
    //    }
//$current_url = $_SERVER['REQUEST_URI'];
//$without_symb = explode('?', $_SERVER['REQUEST_URI']);
//$routes = explode('/', $without_symb[0]);
    $model_name = 'Model';
    $action_name = 'get_';
    $model_name .= $model;
    $action_name .= $action;

//    if (!empty($routes[1])) { // todo: add default parameter in function
//    }
    $model_file = strtolower('Model_'.$model) . '.php';
    $model_path = "static/public/models/" . $model_file;
    if (file_exists($model_path)) {
        include "static/public/models/" . $model_file;
    }
    $getter = new $model_name(10, $page);

    if (method_exists($getter, $action_name)) {
        // вызываем действие контроллера
        $data = $getter->$action_name();
        $json = json_encode($data);
        echo $json;
    } else {
        // здесь также разумнее было бы кинуть исключение
        (new Router)->ErrorPage404();
        echo $action;
    }
}
