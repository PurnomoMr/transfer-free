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

        $result = $data->fetch_row();
        mysqli_close($this->db);

        return $result;
    }

    public function get_user_disborse_by_ud_code($ud_code) {
        $sql = "SELECT * FROM ".$this->table_name." WHERE 1=1 AND ud_code = ? limit 1";
        $process = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($process, "s", $ud_code);
        if(mysqli_stmt_execute($process)) {

        } else {
            
        }
    }
    
    public function getlatest_user_disborse($where, $data, $order_by) {
        $sql = "SELECT * FROM ".self::$table_name." WHERE 1=1 {$where} {$order_by} limit 1";
        $process = mysqli_prepare($this->db, $sql);

        $types = str_repeat('s', count($data));
        mysqli_stmt_bind_param($process, $types, ...$data);
        mysqli_stmt_execute($process);
        $data = mysqli_stmt_get_result($process);

        $result = $data->fetch_row();
        mysqli_close($this->db);

        return $result;
    }
    
    public static function create_user_disborse($data) {

    }

    public static function update_user_disborse($id, $data) {

    }
}
