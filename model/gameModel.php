<?php
        /**
         *
         * @param id $id
         * @param String $name
         * @param timestamp $releaseDate
         * @param String $developer
         * @param String $downloadUrl 
         */
         function insertGame($name,$releaseDate,$developer,$downloadUrl)
        {
             $database = new Database();
             $sql = "INSERT INTO `games` (`name`,`releaseDate`,`developer`,`downloadUrl`) 
                     VALUES('%s','%s','%s','%s')";
             $result = $database->query($sql,array($name,$releaseDate,$developer,$downloadUrl),true);
             return $result;
        }

        /**
         *
         * @param id $id
         * @param String $name
         * @param timestamp $releaseDate
         * @param String $developer
         * @param String $downloadUrl 
         */
         function updateGame($id,$name,$releaseDate,$developer,$downloadUrl)
        {

        }
        
        /**
         *
         * @param int $id
         * @param String $name
         * @param String $developer 
         * @return array(game(id,name,releaseDate,developer,downloadUrl))
         */
         function selectGame($id,$name,$developer)
        {
             $database = new Database();
             $sql = "SELECT `id`,`name`,`releaseDate`,`developer`,`downloadUrl`
                     FROM `games`";
             $sql.=($id>=0 || $name !="" || $developer != "")?" WHERE ":"";
             $sql.=($id >= 0)?"`id` = '%s'":""; 
             $sql.=($id>=0 && ($name !="" || $database!=""))?" AND ":""; 
             $sql.=($name != "")?"`name`LIKE '%s'":"";
             $sql.=($developer!="" &&($name != ""|| $id >= 0))?" AND":"";
             $sql.=($developer !="")?"`developer` LIKE '%s'":"";
             
             
             $param= array();
             ($id >= 0)?array_push($param, $id):"";
             ($name != "")?array_push($param, $name):"";
             ($developer != "")?array_push($param, $developer):"";
            
             return $database->resultArray($database->query($sql,$param));
        }
        
        /**
         * deletes a game
         * @param int $id
         * @return void 
         */
         function deleteGame($id)
        {
 
        }
    /**
     * @author Mario Herbers
     */
  
