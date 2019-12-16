<?php
require_once('static/public/models/model_search.php');

class Controller_Change extends Controller
{
    static private $limit = 10;

    public function __construct()
    {
        Controller::__construct();
        $this->model = new ModelSearch(10, 0);
        $this->view = new View();
    }

    public function action_index()
    {
//        session_start();
        $this->view->render('change_view.php', 'base_view.php', ['auth' => true]);
    }

    public function action_update()
    {
        if (isset($_POST['firstName']) and isset($_POST['lastName'])) {
            $first_name = $_POST['firstName'];
            $last_name = $_POST['lastName'];
            $sql_statement = 'SELECT uid, role, pass FROM profile WHERE firstName = ? AND lastName = ?;';
            $user = DataBase::getRow($sql_statement, [$first_name, $last_name]);
            if ($user == null) {
                $this->view->render('change_view.php', 'base_view.php', ['validate' => true]);
                exit();
            }
            $sql_statement = 'SELECT uid, cur_value, ticket_id, bonus_date FROM detail WHERE profile_id = ? ORDER BY bonus_date;';
            $details = DataBase::paramQuery($sql_statement, [$user['uid']]);
            $arr = $this->model->get_update_list();
            $arr['data'] = $details;
            if ($details != null) {
                $arr['has'] = true;
            }
            $arr['user'] = $user;
            $this->view->render('update_view.php', 'base_view.php', $arr);
        } else {
            header('Location', '/change');
        }
    }

    public function action_add()
    {
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            if ($action == 'add') {

            }
            $arr['user'] = $user;
            $this->view->render('update_view.php', 'base_view.php', $arr);
        } else {
            header('Location', '/change');
        }
    }

}