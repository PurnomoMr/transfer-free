<?php
namespace Models;
include_once(PATH_ROOT."/core/Database.php");

class Model_user_disborse extends \Core\Db\Database
{
    protected static $table_name = "user_disborse";
    
    public function get_user_disborse($id) {
        $sql = "SELECT * FROM ".self::$table_name." WHERE 1=1 AND id = ? limit 1";
        $process = mysqli_prepare($this->db, $sql);
        
        mysqli_stmt_bind_param($process, "s", $id);
        mysqli_stmt_execute($process);
        $data = mysqli_stmt_get_result($process);

        $result = $data->fetch_object();

        return $result;
    }

    public function get_user_disborse_by_ud_code($ud_code) {
        $sql = "SELECT * FROM ".self::$table_name." WHERE 1=1 AND ud_code = ? limit 1";
        $process = mysqli_prepare($this->db, $sql);
        
        mysqli_stmt_bind_param($process, "s", $ud_code);
        mysqli_stmt_execute($process);
        $data = mysqli_stmt_get_result($process);

        $result = $data->fetch_object();

        return $result;
    }
    
    public function getlatest_user_disborse($where, $data, $order_by) {
        $sql = "SELECT * FROM ".self::$table_name." WHERE 1=1 {$where} {$order_by} limit 1";
        $process = mysqli_prepare($this->db, $sql);

        $types = str_repeat('s', count($data));
        $process->bind_param($types, ...$data);
        $process->execute();
        $data = $process->get_result();

        $result = $data->fetch_object();

        return $result;
    }
    
    public function create_user_disborse($data) {
        $data_columns = implode(", ",array_keys($data));
        $data_values = array_values($data);
        $values  = str_repeat('?, ', count($data_values) - 1)."?";
        $sql = "INSERT INTO ".self::$table_name." ($data_columns) VALUES ($values); ";
        $process = mysqli_prepare($this->db, $sql);

        $types = str_repeat('s', count($data_values));
        $process->bind_param($types,  ...$data_values);
        $process->execute();

        return $process->insert_id;
    }

    public function update_user_disborse($id, $data) {
        $data_columns = implode(" = ? , ",array_keys($data))." = ? ";
        $data_values = array_values($data);
        $data_values[count($data_values) + 1] = $id;
        $sql = "UPDATE ".self::$table_name." SET {$data_columns} WHERE id = ? ; ";
        $process = mysqli_prepare($this->db, $sql);
        
        $types = str_repeat('s', count($data_values));
        $process->bind_param($types,  ...$data_values);
        $process->execute();

        return $process->insert_id;
    }
}
