<?php

function html_escape($html_escape)
{
    $html_escape = htmlspecialchars($html_escape, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return $html_escape;
}

if ($_SESSION['security_check'] == 0) {
    $user_id = $_SESSION['user_id'];
    $sql_statement = 'SELECT COUNT(*) FROM sessions
        WHERE user_id = ? AND ip = ? AND user_agent = ? AND hash = ? ;';
    $user_data = [$user_id, $_SERVER['REMOTE_ADDR'],
        html_escape($_SERVER['HTTP_USER_AGENT']),
        preg_replace('/[^0-9a-f]/', '', $_COOKIE['auth'])];

    // TODO: check it
    $n = (int)DataBase::getRow($sql_statement, $user_data);

    if ($n == 0) {
        header("Location: /auth/login?act=logout");
        exit();
    } else {
        $_SESSION['security_check'] = 1;
    }
}

//$n = mysql_result(mysql_query("SELECT COUNT(*) FROM `banned` WHERE `ip`='".$_SERVER['REMOTE_ADDR']."'"), 0);
//if ($n > 0) $_SESSION['security_check'] = 0;
