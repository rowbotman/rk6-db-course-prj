<h1>Создать новый отчет</h1>
<p>
<table>
    <tr>
        <td>Год</td>
        <td>Проект</td>
        <td>Описание</td>
    </tr>
    <?php

    foreach($data as $row)
    {
        echo '<tr><td>'.$row['Year'].'</td><td>'.$row['Site'].'</td><td>'.$row['Description'].'</td></tr>';
    }
    ?>
</table>
</p>