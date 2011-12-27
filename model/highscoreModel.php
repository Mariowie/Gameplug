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
         function insertHighscore($gameId,$userId,$score,$date)
        {
            $database = new Database();            
            $currentHighscore = getHighestScore($gameId, $userId);
            if($currentHighscore >= $score)
            {
                return;
            }
            else
            {
                $insertSql = "INSERT INTO `highscores`(`gameId`,`userId`,`date`,`score`) 
                          VALUES('%s','%s','%s','%s')";
                calculateUserScore($id);
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
         function selectHighscore($gameId,$userId,$date)
        {
              $database = new Database();
                $sql = "SELECT `games`.`name`,`users`.`nickname`,`highscores`.`score`,`highscores`.`date`
                        FROM `highscores`  
                        LEFT JOIN `games` ON `highscores`.`gameid` = `games`.`id`
                        LEFT JOIN `users` ON `highscores`.`userid` = `users`.`id`                     
                       ";
                $sql.=($gameId>0||$userId > 0|| $date >0)?"WHERE":'';
                $sql.=($gameId>0)?"`games`.`gameId` = '%s'":"";
                $sql.=($gameId>0 && ($userId > 0 || $date >0))?"AND":"";
                $sql.=($userId > 0)?"`users`.`userId` ='%s'":"";
                $sql.=($date>0 && $userId >0)?" AND `highscores`.`date` = '%s'":'';
                $sql.=($date>0 && $userId <0)?" `highscores`.`date` = '%s'":'';
                
                $param = array();
                ($gameId>0)?array_push($param, $gameId):'';
                ($userId > 0)?array_push($param, $userId ):'';
                ($date>0)?array_push($param, $date):'';
                 $result = $database->resultArray($database->query($sql,$param));
        }
        
        /**
         * Delets a highscore
         * @param int $gameId
         * @param int $userId 
         * @return void
         */
         function deleteHighscore($gameId,$userId)
        {
            echo achievementScore($userId);
            echo getHighscoresUser($userId);
        }
        
        /**
         *
         * @param int $gameId
         * @param int $userId
         * @return int 
         */
        function getHighestScore($gameId, $userId)
        {
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
             $games = selectGame(-1,"","");
             
             $score = 0;
               
             foreach($games as $game)
             {
                $score += getHighestScore($game['id'],$id); 
                
             }
             return $score;
        }
    