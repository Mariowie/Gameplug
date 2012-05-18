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
    public  function query($sql,$vars = array(),$insert = false,$WhereArray = array())
    {      
       
       
      
       $size = count($WhereArray);
       $whereclause = "";
       //echo $size;
       if($size > 0)
       {
           $whereclause .= "WHERE ";
           $pos = 1;
           
           foreach($WhereArray as $key => $value)
           {              
               if(is_array($value))
               {
                   $whereclause .=  mysql_real_escape_string($key)." ".$value['match']." ".$value['key']." ";
               }
                else 
                {
                    $whereclause .=  mysql_real_escape_string($key)."=".mysql_real_escape_string($value);
                }
               
               if($pos < $size)
               {
                  $whereclause .= "AND"; 
               }
              $pos++; 
           }
       }
       $sql.=$whereclause; 
       //echo $sql;
       	if(!is_array($vars)){
			$vars = array($vars);
		}
		$nVars = count($vars);
		if(count($vars) > 0){
			$args = array($sql);
			foreach($vars as $v){
				$args[] = mysql_real_escape_string($v);
			}
			$sql = call_user_func_array('sprintf', $args);
		}
		error_log("|Query| Got query $sql");
		$qResult = mysql_query($sql);
		// Check if result is true or false.
		if(is_bool($qResult)){
			// If result = false, report the mysql error.
			if(!$qResult){
				error_log("|Query| An exception occurred while trying to execute query: ".mysql_error());
			} else {
				// If not, check if it was an insert query.
				if($insert){
					return mysql_insert_id();
				}
			}
			// If it was an update/delete query, return the query result (true/false).
			return $qResult;
		} else if(is_resource($qResult)){
			// If result was a resource, return the resulting data from the db.
                        $array = array();
			 if(mysql_num_rows($qResult)!=0) 
                         {     while($row=mysql_fetch_assoc($qResult))
                             {
                                $array[]=$row;
                             }
                         }
                         return $array;
		}
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

