<?php
namespace Migration;
define("PATH_ROOT", __DIR__ . '/../');
include_once(PATH_ROOT."core/Database.php");

class create_user_disborse_table extends \Core\Db\Database {
    protected $table_name = "user_disborse";
    
    function up() {
        $sql = "CREATE TABLE IF NOT EXISTS ". $this->table_name ." (
            id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            ud_code int(11) NOT NULL,
            ud_bank_code varchar(75) NOT NULL,
            ud_account_no varchar(255) NOT NULL,
            ud_date datetime NOT NULL,
            ud_amount int(11) NOT NULL,
            ud_beneficiary_name varchar(150) NOT NULL,
            ud_status varchar(150) NOT NULL,
            ud_remark text,
            ud_receipt varchar(50) DEFAULT NULL,
            ud_time_served datetime DEFAULT NULL,
            ud_fee int(11) NOT NULL,
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