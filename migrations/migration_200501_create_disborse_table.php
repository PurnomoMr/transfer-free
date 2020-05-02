<?php
namespace Migration;
define("PATH_ROOT", __DIR__ . '/../');
include_once(PATH_ROOT."core/Database.php");

class create_disborse_table extends \Core\Db\Database {
    protected $table_name = "disborse";
    
    function up() {
        $sql = "CREATE TABLE IF NOT EXISTS ". $this->table_name ." (
            id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            ud_id int(11) NOT NULL,
            ud_code int(11) NOT NULL,
            ds_status varchar(75) NOT NULL,
            created_date datetime NOT NULL,
            updated_date datetime DEFAULT NULL
          )";
        if(mysqli_query($this->db, $sql)) {  
            echo "Migration: ". self::class  ." has been successfully\n";  
        } else {  
            echo "Migration: ". self::class  ." has been failed\n";
        }  
        mysqli_close($this->db); 
    }
    
    function down() {
        if(mysqli_query($this->db, "DROP TABLE ". $this->table_name .";")) {  
            echo "Migration: ". self::class  ." is deleted successfully\n";  
        } else {  
            echo "Migration: ". self::class  ." is not deleted successfully\n";
        }  
        mysqli_close($this->db); 
    }
}