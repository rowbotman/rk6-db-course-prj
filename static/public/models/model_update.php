<?php


class ModelUpdate extends Model
{
    public function get_delete($id)
    {
        $sql = 'DELETE FROM detail WHERE uid = ?;';
        if (isset($id)) {
            DataBase::insertQuery($sql, [$id]);
        }
        return ['status' => 'OK'];
    }

    public function get_update($id, $cur_value, $ticket_id, $bonus_date)
    {
        $sql = 'UPDATE detail SET cur_value = ?, ticket_id = ?, bonus_date = ? WHERE uid = ?;';
        if (isset($id)) {
            DataBase::insertQuery($sql, [$cur_value, $ticket_id, $bonus_date, $id]);
        }
        return ['status' => 'OK'];
    }
}