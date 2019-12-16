<?php


class ModelUpdate extends Model
{
    public function get_delete($id)
    {
        $sql = 'DELETE FROM detail WHERE uid = ?;';
        if (isset($id)) {
            DataBase::insertQuery($sql, [$id]);
        }
        return [['' => 'OK']];
    }
}