<?php
$page = $_GET['page'];
$limit_l = ($page - 1) * 10;
$limit_h = $page * 10;
$sql = 'SELECT f.uid AS flight, MONTH(f.dep_date) AS month, t.class, COUNT(t.uid) AS tickets_num FROM ticket t
JOIN flight f ON (t.flight_id = f.uid) WHERE YEAR(f.dep_date) = ?
GROUP BY flight, month, t.class ORDER BY tickets_num DESC LIMIT '.$limit_l.','.$limit_h.';';
$data = DataBase::paramQuery($sql, 2012);
$json = json_encode($data);
echo $json;
//echo "[{\"text\": [ {\"row\": [{\"file\": \"hello page $page\"}]}, {\"row\": [{\"file\": \"hello page $page\"}]}]}]";
