<?php

include(PATH_ROOT."core/Database.php");

class CreateATable extends \Database {
    protected $table_name = "table_a";
    
    function up() {
        $sql = "";
        if(mysqli_query($this->db, "DROP TABLE ". $sql)) {  
            echo "Table ". $this->table_name ." is deleted successfully\n";  
        } else {  
            echo "Table ". $this->table_name ." is not deleted successfully\n";
        }  
         mysqli_close($conn); 
    }
    
    function down() {
        if(mysqli_query($this->db, "DROP TABLE ". $this->table_name .";")) {  
            echo "Table ". $this->table_name ." is deleted successfully\n";  
        } else {  
            echo "Table ". $this->table_name ." is not deleted successfully\n";
        }  
         mysqli_close($conn); 
    }
}