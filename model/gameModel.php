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
            if(sizeof(selectGames(-1,$name,$developer,-1))==0)
            {
                $database = new Database();
                $sql = "INSERT INTO `games` (`name`,`releaseDate`,`developer`,`downloadUrl`) 
                     VALUES('%s','%s','%s','%s')";
                $result = $database->query($sql,array($name,$releaseDate,$developer,$downloadUrl),true);
                return $result;
            }
            else
            {
                $result = selectGames(-1,$name,$developer,-1);
                return $result[0]['id'];
            }
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
         function selectGames($id,$name,$developer,$user)
        {
             
            $whereArray = array();
            if($id >= 0 )
            { 
                $whereArray["`games`.id`"] = $openId;
            }
            if($developer !="")
            {
                $whereArray["`games`.`developer`"] = array();
                $whereArray["`games`.`developer`"]["key"] = '"'.$developer.'"';
                $whereArray["`games`.`developer`"]["match"] = "LIKE";
            } 
            if($name !="")
            {
                $whereArray["`games`.`name`"] = $name;
            }
            if($user >=0)
            {
                $whereArray["`userachievements`.`userId`"] = $user;
            }
            
             $database = new Database();
             $sql = "SELECT `games`.`id`,`games`.`name`,`games`.`releaseDate`,`games`.`developer`,
                                `games`.`downloadUrl`,
                                COALESCE(  `highscore`.`score` , 0 ) AS highscore,
                                COALESCE(  `achievements`.`achievements` , 0 ) AS achievements   
                     FROM `games`
                     LEFT JOIN (
                                    SELECT `score`,  `gameid` , `userid`
                                    FROM  `highscores`                                     
                                    ORDER BY `score` DESC
                                    LIMIT 0,1
                                ) AS  `highscore` ON  `highscore`.`gameid` =  `games`.`id` 
                    LEFT JOIN (
                                    SELECT COUNT(*) AS `achievements`,  `gameId` ,`id`
                                    FROM  `achievements`                                     
                                    GROUP BY `gameId`
                                ) AS  `achievements` ON  `achievements`.`gameId` =  `games`.`id` 
                    LEFT JOIN ( 
                                    SELECT `userId`,`achievementId`
                                    FROM  `userachievements`
                                ) AS `userachievements` ON `userachievements`.`achievementId` = `achievements`.`id`
                    ";             

             
             $param= array();
             return $database->query($sql,$param,false,$whereArray);
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
  
