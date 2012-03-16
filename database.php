<?php

/**
 * @author Mario Herbers
 */
class Database {
    

    
    public function __construct()
    {
        $database = 'gameplug';
        mysql_connect('localhost', 'root', '');
        mysql_select_db($database);
    }
    
    /**
     *  
     * @param int $type
     * @param array Array(table-> $query 
     */
    public  function query($sql,$vars = array(),$insert = false)
    {      
       $query = $sql;    
       if(is_scalar($vars))
            {
                    $vars = array($vars);
            }

            if(count($vars) > 0)
            {
                    $args = array($sql);

                    foreach($vars as $v)
                    {
                            $args[] = mysql_real_escape_string($v);
                    }

                    $query = call_user_func_array('sprintf', $args);
            }
           $result= mysql_query($query);
           //echo $query;
           return (!$insert)?$result:mysql_insert_id();
    }
    
    
    public function resultArray($result)
    {
        $array = array();
                            if(is_resource($result))
                    {    
                         if(mysql_num_rows($result)!=0) 
                         {     while($row=mysql_fetch_assoc($result))
                             {
                                $array[]=$row;
                             }
                         }
                    }
        return $array;
    }
    
}


