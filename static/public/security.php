<?php

function html_escape($html_escape)
{
    $html_escape = htmlspecialchars($html_escape, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return $html_escape;
}

//$n = mysql_result(mysql_query("SELECT COUNT(*) FROM `banned` WHERE `ip`='".$_SERVER['REMOTE_ADDR']."'"), 0);
//if ($n > 0) $_SESSION['security_check'] = 0;
