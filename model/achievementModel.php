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
       function selectAchievements($gameId,$id)
       {
 
           $database = new Database();
           if($gameId>=0 && $id >= 0)
           {
                $sql = "SELECT `achievements`.`id`,`achievements`.`titel` AS title,`achievements`.`description` ,`achievements`.`points`,`games`.`name` AS gameName, COALESCE(userachievement.`times`,0) AS achieved
                       FROM `achievements` LEFT JOIN `games` 
                       ON `achievements`.gameId = `games`.id
                       LEFT JOIN 
                                (
                                    SELECT COUNT(*) AS times,`achievementId`
                                    FROM `userachievements`
                                    GROUP BY `achievementId`
                                ) AS userachievement ON userachievement.`achievementId` = `achievements`.`id`
                       WHERE `games`.id = '%s' AND `achievements`.id = '%s'";
                $result =$database->query($sql,array($gameId,$id));
                $array = $database->resultArray($result);
                return $array; 
           }
           elseif($gameId >= 0 || $id >= 0)
           {
               if($gameId >= 0 )
               {
                    $sql = "SELECT `achievements`.`id`,`achievements`.`titel` AS title,`achievements`.`description` ,`achievements`.`points`,`games`.`name` AS gameName, COALESCE(userachievement.`times`,0) AS achieved
                       FROM `achievements` LEFT JOIN `games` 
                       ON `achievements`.gameId = `games`.id
                       LEFT JOIN 
                                (
                                    SELECT COUNT(*) AS times,`achievementId`
                                    FROM `userachievements`
                                    GROUP BY `achievementId`
                                ) AS userachievement ON userachievement.`achievementId` = `achievements`.`id`
                       WHERE `games`.id = '%s'";
                    $result =$database->query($sql,array($gameId));
                    $array = $database->resultArray($result);
                    return $array; 
               }
               elseif( $id >= 0)
               {
                    $sql = "SELECT `achievements`.`id`,`achievements`.`titel` AS title,`achievements`.`description` ,`achievements`.`points`,`games`.`name` AS gameName, COALESCE(userachievement.`times`,0) AS achieved
                            FROM `achievements` LEFT JOIN `games` 
                            ON `achievements`.gameId = `games`.id
                            LEFT JOIN 
                                    (
                                        SELECT COUNT(*) AS times,`achievementId`
                                        FROM `userachievements`
                                        GROUP BY `achievementId`
                                    ) AS userachievement ON userachievement.`achievementId` = `achievements`.`id`
                            WHERE `achievements`.id = '%s'";
                    $result =$database->query($sql,array($id));
                    $array = $database->resultArray($result);
                    return $array;   
               }
           }
            else 
            {
                $sql = "SELECT `achievements`.`id`,`achievements`.`titel` AS title,`achievements`.`description` ,`achievements`.`points`,`games`.`name` AS gameName, COALESCE(userachievement.`times`,0) AS achieved
                        FROM `achievements` LEFT JOIN `games` 
                        ON `achievements`.gameId = `games`.id
                        LEFT JOIN 
                                (
                                    SELECT COUNT(*) AS times,`achievementId`
                                    FROM `userachievements`
                                    GROUP BY `achievementId`
                                ) AS userachievement ON userachievement.`achievementId` = `achievements`.`id`
                       ";
                    $result =$database->query($sql,array());
                    $array = $database->resultArray($result);
                    return $array;  
            }
       }
       
       /**
         *  function inserts achievement, and returns id.
         * 
         * @param int $gameId
         * @param string $titel
         * @param string $description
         * @param int $points 
         * @return int id
         */                
       function insertAchievement($gameId, $titel, $description, $points)
       {
            $database = new Database();
             $sql = "INSERT INTO `achievements` (`gameId`,`titel`,`description`,`points`) 
                     VALUES('%s','%s','%s','%s')";
             $result = $database->query($sql,array($gameId,$titel,$description,$points),true);
             return $result;
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
       function updateAchievement($id,$gameId,$title,$description,$points)
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
       function insertAchievementUser($userId,$achievementId,$date)
       {
            $database = new Database();
            $sql = "INSERT INTO `userachievements` (`userId`,`achievementId`,`dateOfAchieving`) 
                    VALUES('%s','%s','%s')";
            $result = $database->query($sql,array($userId,$achievementId,$date),true);
            updateUser($userId,"",calculateUserScore($userId)); 
            return;
       }
       
       /**
        * selects the achievements of a user
        * @param int $userId
        * @param int $gameId optional
        * @return ARRAY
        */
       function selectAchievementsUser($userId, $gameId) 
       {
            $database = new Database();
            if($userId >= 0 && $gameId >= 0)
            {    
                $sql = "SELECT `achievements`.`id`,`achievements`.`titel` AS title,`achievements`.`description` ,`achievements`.`points`,`games`.`name` AS gameName,COALESCE(count.`times`,0) AS achieved,COALESCE(`userachievements`.`dateOfAchieving`,0) AS date,`games`.id AS gameId
                        FROM `achievements` 
                        LEFT JOIN `userachievements` ON `achievements`.`id` = `userachievements`.`achievementId`
                        LEFT JOIN `games` ON `achievements`.gameId = `games`.id
                        LEFT JOIN 
                                (
                                    SELECT COUNT(*) AS times,`achievementId`
                                    FROM `userachievements`
                                    GROUP BY `achievementId`
                                ) AS count ON count.`achievementId` = `achievements`.`id`
                        WHERE `userachievements`.`userId` = '%s' AND `games`.`id` = '%s'";
                $result =$database->query($sql,array($userId,$gameId));
                $array = $database->resultArray($result);
                return $array;
            }
            elseif($userId >= 0 || $gameId >= 0)
            {
                if($userId >= 0 )
                {
                    $sql = "SELECT `achievements`.`id`,`achievements`.`titel` AS title,`achievements`.`description` ,`achievements`.`points`,`games`.`name` AS gameName,COALESCE(count.`times`,0) AS achieved,COALESCE(`userachievements`.`dateOfAchieving`,0) AS date,`games`.id AS gameId
                            FROM `achievements` 
                            LEFT JOIN `userachievements` ON `achievements`.`id` = `userachievements`.`achievementId`
                            LEFT JOIN `games` ON `achievements`.gameId = `games`.id
                            LEFT JOIN 
                                    (
                                        SELECT COUNT(*) AS times,`achievementId`
                                        FROM `userachievements`
                                        GROUP BY `achievementId`
                                    ) AS count ON count.`achievementId` = `achievements`.`id`
                            WHERE `userachievements`.`userId` = '%s'";
                    $result =$database->query($sql,array($userId));
                    $array = $database->resultArray($result);
                    return $array;
                }
                elseif($gameId >= 0)
                {
                    $sql = "SELECT `achievements`.`id`,`achievements`.`titel` AS title,`achievements`.`description` ,`achievements`.`points`,`games`.`name` AS gameName,COALESCE(count.`times`,0) AS achieved,COALESCE(`userachievements`.`dateOfAchieving`,0) AS date,`games`.id AS gameId
                            FROM `achievements` 
                            LEFT JOIN `userachievements` ON `achievements`.`id` = `userachievements`.`achievementId`
                            LEFT JOIN `games` ON `achievements`.gameId = `games`.id
                            LEFT JOIN 
                                    (
                                        SELECT COUNT(*) AS times,`achievementId`
                                        FROM `userachievements`
                                        GROUP BY `achievementId`
                                    ) AS count ON count.`achievementId` = `achievements`.`id`
                            WHERE `games`.`id` = '%s'";
                    $result =$database->query($sql,array($gameId));
                    $array = $database->resultArray($result);
                    return $array;
                }
                
            }
            else 
            {
                $sql = "SELECT `achievements`.`id`,`achievements`.`titel` AS title,`achievements`.`description` ,`achievements`.`points`,`games`.`name` AS gameName,COALESCE(count.`times`,0) AS achieved,COALESCE(`userachievements`.`dateOfAchieving`,0) AS date,`games`.id AS gameId
                        FROM `achievements` 
                        LEFT JOIN `userachievements` ON `achievements`.`id` = `userachievements`.`achievementId`
                        LEFT JOIN `games` ON `achievements`.gameId = `games`.id
                        LEFT JOIN 
                                (
                                    SELECT COUNT(*) AS times,`achievementId`
                                    FROM `userachievements`
                                    GROUP BY `achievementId`
                                ) AS count ON count.`achievementId` = `achievements`.`id`";
                $result =$database->query($sql,array());
                $array = $database->resultArray($result);
                return $array; 
            }

       }
       
       function achievementScore($id)
       {
           $userAchievements  = selectAchievementsUser($id,-1);
           
           $score = 0;
           
           foreach($userAchievements as $achievement)
           {
               $score += $achievement['points'];
           }
           
           return $score;
       }
       

