<?php


class Controller_Change extends Controller
{
    public function __construct()
    {
        Controller::__construct();
        $this->view = new View();
    }

    public function action_index()
    {
        $this->view->render('change_view.php', 'base_view.php');
    }

    public function action_update()
    {
        if (isset($_POST['firstName']) and isset($_POST['lastName'])) {
            $first_name = $_POST['firstName'];
            $last_name = $_POST['lastName'];
            $sql_statement = 'SELECT * FROM profile WHERE firstName = ? AND lastName = ?;';
            $user = DataBase::getRow($sql_statement, [$first_name, $last_name]);
            if ($user == null) {
                $this->view->render('change_view.php', 'base_view.php', ['validate' => true]);
                exit();
            }
            $this->view->render('update_view.php', 'base_view.php', ['user' => $user]);
        } else {
            header('Location', '/change');
        }
    }
}