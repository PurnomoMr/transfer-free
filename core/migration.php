<?php


define("PATH_ROOT", __DIR__ . '/../');

class Migration {

    protected static function read_all()
    {
        $filename = [];
        $dir = PATH_ROOT."/migrations/";
        
        if (is_dir($dir)){
            if ($dh = opendir($dir)){
                while (($file = readdir($dh)) !== false){
                    $ext = explode('.', $file);
                    if ($file == '.' || $file == '..' || $file == "index.php") {
                        continue;
                    }
                    
                    if($ext[1] == "php"){
                        $filename[] = $file;
                    }
                }
            }
        }
        
        return $filename;
    }

    public static function up($migration_filename = null) {
        $load_class .= "\Migration\\";
        if(isset($migration_filename)) {
            
            include_once(PATH_ROOT."/migrations/".$migration_filename .".php");
            $load_class .= substr($migration_filename, 17);
            $migration = new $load_class;

            $migration->up();
        } else {
            $filename = self::read_all();
            foreach($filename as $class_name)
            {   
                $class = explode('.php', substr($class_name, 17))[0];
                include_once(PATH_ROOT."/migrations/".$class_name);
                $load_class .= $class;
                $migration = new $load_class;
                
                $migration->up();
                $load_class = "\Migration\\";
            }
        }

    }


    public static function down() {
        $load_class .= "\Migration\\";
        if(isset($migration_filename)) {
            
            include_once(PATH_ROOT."/migrations/".$migration_filename .".php");
            $load_class .= substr($migration_filename, 17);
            $migration = new $load_class;

            $migration->down();
        } else {
            $filename = self::read_all();
            foreach($filename as $class_name)
            {   
                $class = explode('.php', substr($class_name, 17))[0];
                include_once(PATH_ROOT."/migrations/".$class_name);
                $load_class .= $class;
                $migration = new $load_class;
                
                $migration->down();
            }
        }
    }

}
