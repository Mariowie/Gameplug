<?php
    
    
    /**
     * @author Mario Herbers
     */
    
       /**
        * selects achievements with game id or only a specific achievement.
        * @return array(achievement(id,game.name,titel,description,points))  
        * @param int $gameId
        * @param int $id 
        */
       function selectAchievements($gameName,$id,$name,$developer)
       {
            $gameId = selectGames(-1,$gameName,$developer,-1);
            $gameId = ( sizeof($gameId) == 1)?$gameId[0]["id"]:-1;
            
            
            $whereArray = array();
            if($gameId >= 0 != ""  )
            { 
                $whereArray["`games`.id`"] = $openId;
            }
            if($id >= 0)
            {
                $whereArray["`achievements`.id`"] = $id;
            } 
            if($name !="")
            {
                $whereArray["`achievements`.`titel`"] = $name;
            }
            
           $database = new Database();
           $sql = "SELECT `achievements`.`id`,`achievements`.`titel` AS title,`achievements`.`description` ,
                            `achievements`.`points`,`games`.`name` AS gameName,`games`.`developer`, 
                            COALESCE(userachievement.`times`,0) AS achieved
                    FROM `achievements` LEFT JOIN `games` 
                    ON `achievements`.gameId = `games`.id
                    LEFT JOIN 
                    (
                        SELECT COUNT(*) AS times,`achievementId`
                        FROM `userachievements`
                        GROUP BY `achievementId`
                    ) AS userachievement ON userachievement.`achievementId` = `achievements`.`id`
                       ";
            $result =$database->query($sql,array(),false,$whereArray);
            
            return $result;                                 
       }
       
       /**
         *  function inserts achievement, and returns id.
         * 
         * @param int $gameId
         * @param string $titel
         * @param string $description
         * @param int $points 
         * @param string $developer
         * @return int id
         */                
       function insertAchievement($id,$gameName, $titel, $description, $points,$developer)
       {
            $gameId = selectGames(-1,$gameName,$developer,-1);
                $gameId = ( sizeof($gameId) == 1)?$gameId[0]["id"]:-1;
            if(sizeof(selectAchievements($gameName,$id,""))==0)
            {
                $database = new Database();
                 $sql = "INSERT INTO `achievements` (`id`,`gameId`,`titel`,`description`,`points`) 
                         VALUES('%s','%s','%s','%s','%s')";
                 $result = $database->query($sql,array($id,$gameId,$titel,$description,$points),true);
                 return $result;
            }
             else 
            {

            }
       }
       
              /**
        * updates an achievement
        * @param int $id
        * @param int $gameId
        * @param string $title
        * @param string $description
        * @param int $points
        * @return void
        */
       function updateAchievement($id,$gameName,$title,$description,$points)
       {
           
       }
       
       /**
        * removes achievement
        * @param int $id 
        * @return void
        */
       function deleteAchievement($id)
       {
           
       }
       
       /**
        * insert a new user achievement
        * @param int $userId
        * @param int $achievementId
        * @param timestamp $date
        * @return void
        */
       function insertAchievementUser($userId,$achievementId,$gameName,$date,$developer)
       {
           $dateNew = date("d-m-Y h:i:s", strtotime($date));       
            $gameId = selectGames(-1,$gameName,$developer,-1);
                $gameId = ( sizeof($gameId) == 1)?$gameId[0]["id"]:-1;
            $database = new Database();
            $sql = "INSERT INTO `userachievements` (`userId`,`achievementId`,`gameid`,`dateOfAchieving`) 
                    VALUES('%s','%s','%s','%s')";
            $result = $database->query($sql,array($userId,$achievementId,$gameId,$dateNew),true);
            updateUser($userId,"",calculateUserScore($userId)); 
            return;
       }
       
       /**
        * selects the achievements of a user
        * @param int $userId
        * @param int $gameId optional
        * @return ARRAY
        */
       function selectAchievementsUser($userId, $gameName,$developer) 
       {
            $database = new Database();
            $gameId = selectGames(-1,$gameName,$developer,-1);
                $gameId = ( sizeof($gameId) == 1)?$gameId[0]["id"]:-1;
        // TODO compress sql 
                
            $WhereArray = array();
            if($userId >= 0 )
            {
               $WhereArray["`userachievements`.`userId`"] = $userId;
            }   
            
            if($gameId >= 0)
            {
                $WhereArray["`games`.`id`"] = $gameId;
            }
                $sql = "SELECT `achievements`.`id`,`achievements`.`titel` AS title,`achievements`.`description` ,
                                `achievements`.`points`,`games`.`name` AS gameName,`games`.`developer`,
                                COALESCE(count.`times`,0) AS achieved,
                                COALESCE(`userachievements`.`dateOfAchieving`,0) AS date,`games`.id AS gameId
                        FROM `achievements` 
                        LEFT JOIN `userachievements` ON `achievements`.`id` = `userachievements`.`achievementId`
                        LEFT JOIN `games` ON `achievements`.gameId = `games`.id
                        LEFT JOIN 
                                (
                                    SELECT COUNT(*) AS times,`achievementId`
                                    FROM `userachievements`
                                    GROUP BY `achievementId`
                                ) AS count ON count.`achievementId` = `achievements`.`id`";
                
                $array =$database->query($sql,array($userId,$gameId),false,$WhereArray);
                return $array;

       }
       
       function achievementScore($id)
       {
           $userAchievements  = selectAchievementsUser($id,-1,"");
           
           $score = 0;
           
           foreach($userAchievements as $achievement)
           {
               $score += $achievement['points'];
           }
           
           return $score;
       }
       

