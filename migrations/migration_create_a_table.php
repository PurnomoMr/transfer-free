<?php
namespace Migration;
define("PATH_ROOT", __DIR__ . '/../');
include(PATH_ROOT."core/Database.php");

class create_a_table extends \Core\Db\Database {
    protected $table_name = "user_disborse";
    
    function up() {
        $sql = "CREATE TABLE IF NOT EXISTS ". $this->table_name ." (
            id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            ud_bank_code varchar(75) NOT NULL,
            ud_account_no varchar(255) NOT NULL,
            ud_date datetime NOT NULL,
            ud_amount int(11) NOT NULL,
            ud_beneficiary_name varchar(150) NOT NULL,
            ud_remark text,
            ud_receipt varchar(50) DEFAULT NULL,
            ud_time_served datetime DEFAULT NULL,
            ud_fee int(11) NOT NULL,
            created_date datetime NOT NULL,
            updated_date datetime DEFAULT NULL
          )";
        if(mysqli_query($this->db, $sql)) {  
            echo "Create table ". $this->table_name ." has been successfully\n";  
        } else {  
            echo "Create table ". $this->table_name ." has been failed\n";
        }  
        mysqli_close($this->db); 
    }
    
    function down() {
        if(mysqli_query($this->db, "DROP TABLE ". $this->table_name .";")) {  
            echo "Table ". $this->table_name ." is deleted successfully\n";  
        } else {  
            echo "Table ". $this->table_name ." is not deleted successfully\n";
        }  
        mysqli_close($this->db); 
    }
}