<?php
namespace Migration;
define("PATH_ROOT", __DIR__ . '/../');
include_once(PATH_ROOT."core/Database.php");

class add_index_disborse_table extends \Core\Db\Database {
    protected $table_name = "disborse";
    
    function up() {
        $sql = "ALTER TABLE ". $this->table_name ."
            ADD KEY ud_id (ud_id),
            ADD KEY ud_code (ud_code);
          ";
        if(mysqli_query($this->db, $sql)) {  
            echo "Migration: ". self::class ." has been successfully\n";  
        } else {  
            echo "Migration: ". self::class  ." has been failed\n";
        }  
        mysqli_close($this->db); 
    }
    
    function down() {
        if(mysqli_query($this->db, "ALTER TABLE ". $this->table_name ." DROP INDEX ud_id, ud_code;")) {  
            echo "Migration: ". self::class  ." is deleted successfully\n";  
        } else {  
            echo "Migration: ". self::class  ." is not deleted successfully\n";
        }  
        mysqli_close($this->db); 
    }
}