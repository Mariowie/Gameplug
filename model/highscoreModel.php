<?php
    
    /**
     * @author Mario Herbers
     */
    
            /**
         * Inserts a new highscore
         * @param int $gameId
         * @param int $userId
         * @param int $score
         * @param Timestamp $date 
         * @return void
         */
         function insertHighscore($gameName,$userId,$score,$date,$developer)
        {
            $gameId = selectGames(-1,$gameName,$developer,-1);
            
            $gameId = $gameId[0]['id'];
            $database = new Database();            
            $currentHighscore = getHighestScore($gameId, $userId,$developer);
            if($currentHighscore >= $score)
            {
                return;
            }
            else
            {
                $insertSql = "INSERT INTO `highscores`(`gameId`,`userId`,`date`,`score`) 
                          VALUES('%s','%s','%s','%s')";                
                 $result = $database->query($insertSql,array($gameId,$userId,$date,$score)); 
                 updateUser($userId,"",calculateUserScore($userId)); 
            }
            //$database->query($insertSql,array($gameId,$userId,$date,$score));
            
            
            
        }
        
        /**
         *  selects highscores from a particlar game user or date, 
         *  more parameters mean more specific data     
         * @param int $gameId
         * @param int $userId
         * @param timestamp $date 
         * @return array(highscore(game.name, user.name,score,date))
         */
         function selectHighscores($gameName,$userId,$date,$developer)
        {
                $gameId = selectGames(-1,$gameName,$developer,-1);
                $gameId = ( sizeof($gameId) == 1)?$gameId[0]["id"]:-1;
                
                
            $WhereArray = array();
            if($gameId>0 )
            {
               $WhereArray["`highscores`.`gameid`"] = $gameId;
            }   
            
            if($userId > 0)
            {
                $WhereArray["`highscores`.`userId`"] = $userId;
            }
            
            if($date !="")
            {
                $WhereArray["`highscores`.`date`"] = $date;
            }
                
              $database = new Database();
                $sql = "SELECT `games`.`name` AS gameName,`games`.`developer`,
                                `games`.`id` AS gameid,`users`.`id` AS userid,`users`.`nickname` AS userName,
                                `highscores`.`score`,`highscores`.`date`
                        FROM `highscores`  
                        LEFT JOIN `games` ON `highscores`.`gameid` = `games`.`id`
                        LEFT JOIN `users` ON `highscores`.`userid` = `users`.`id`                     
                       ";
            
                $param = array();             
                 $result = $database->query($sql,$param,false,$WhereArray);
                 return $result;
        }
        
        /**
         * Delets a highscore
         * @param int $gameId
         * @param int $userId 
         * @return void
         */
         function deleteHighscore($gameName,$userId)
        {
        }
        
        /**
         *
         * @param int $gameId
         * @param int $userId
         * @return int 
         */
        function getHighestScore($gameName, $userId)
        {
             $gameId = selectGames(-1,$gameName,"",-1);
                $gameId = ( sizeof($gameId) == 1)?$gameId[0]["id"]:-1;
            $database = new Database();
            $highestSql = "SELECT `score`
                           FROM `highscores`                        
                           WHERE `gameId` = '%s' AND `userId` ='%s' 
                           ORDER BY `score` DESC
                           LIMIT 0,1 ";
            $result = $database->query($highestSql,array($gameId,$userId)); 
            $result = $database->resultArray($result);
            return (is_array($result))?(isset($result[0]['score']))?$result[0]['score']:0:0;
        }
        
        /**
         *
         * @param int $id userid
         */     
        function getHighscoresUser($id)
        {
             $games = selectGames(-1,"","",-1);
             
             $score = 0;
               
             foreach($games as $game)
             {
                $score += getHighestScore($game['id'],$id); 
                
             }
             return $score;
        }
    