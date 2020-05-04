<?php 
namespace Core\Db;

include_once(PATH_ROOT."/config/config.php");

class database {
    
    public $db;
	private $host     = _DB_SERVER_;
	private $username = _DB_USER_;
	private $password = _DB_PASSWD_;
    private $database = _DB_NAME_;
 
	public function __construct(){
        $this->db = null;

        try {
            //code...
            $this->db = mysqli_connect(
                $this->host, 
                $this->username, 
                $this->password, 
                $this->database
            );
        } catch (\Exception $e) {
            echo "Connection error: " .  $e->getMessage(), "\n";
        }
        
        return $this->db;
    }
} 