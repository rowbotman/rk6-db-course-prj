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
        if (isset($_POST['firstName']) and isset($_POST['lastName']) or isset($_GET['user_id'])) {
            $user = null;
            if (!isset($_GET['user_id'])) {
                $first_name = $_POST['firstName'];
                $last_name = $_POST['lastName'];
                $sql_statement = 'SELECT uid, role, pass FROM profile WHERE firstName = ? AND lastName = ?;';
                $user = DataBase::getRow($sql_statement, [$first_name, $last_name]);
                if ($user == null) {
                    $this->view->render('change_view.php', 'base_view.php', ['validate' => true]);
                    exit();
                }
            } else {
                $user['uid'] = $_GET['user_id'];
            }

            $sql_statement = 'SELECT uid, cur_value, ticket_id, bonus_date FROM detail WHERE profile_id = ? ORDER BY bonus_date;';
            $details = DataBase::paramQuery($sql_statement, [$user['uid']]);
            $arr = $this->model->get_update_list();
            $arr['data'] = $details;
            $arr['user_id'] = $user['uid'];
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
        if (isset($_POST['value']) and isset($_POST['ticket_id'])) {
            $user_id = $_POST['user_id'];
            $ticket_id = $_POST['ticket_id'];
            $value = $_POST['value'];
            $sql_statement = 'SELECT uid FROM ticket WHERE uid = ? ;';
            $ticket_check = DataBase::getRow($sql_statement, [$ticket_id]);
            if (!$ticket_check) {
                $this->view->render('add_row_view.php', 'base_view.php',
                    ['user_id' => $user_id, 'validate' => true]);
                exit();
            }
            $sql_statement = 'INSERT INTO detail (profile_id, ticket_id, cur_value) VALUES (?, ?, ?)';
            DataBase::insertQuery($sql_statement, [$user_id, $ticket_id, $value]);
            header('Location: http://coursacheit.com/change/update?user_id='.$user_id);
//            $arr['user'] = $user;
//            $this->view->render('update_view.php', 'base_view.php', $arr);
        } else {
            $user_id = $_GET['user_id'];
            $this->view->render('add_row_view.php', 'base_view.php', ['user_id' => $user_id]);
        }
    }

}