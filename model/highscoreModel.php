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
        function insertHighscore($gameName,$userId,$score,$date)
        {
            $gameId = selectGames(-1,$gameName,"",-1);
            $gameId = $gameId[0]['id'];
			error_log("|InsertHighscore| Function parameters: \"$gameName\", \"$userId\", \"$score\", \"$date\"");
            $database = new Database();
            $currentHighscore = getHighestScore($gameId, $userId);
			error_log("|InsertHighscore| Current highscore: $currentHighscore, provided \"highscore\": $score");
            if($currentHighscore >= $score)
            {
				error_log("|InsertHighscore| No new highscore, exiting");
                return;
            }
            else
            {
				error_log("|InsertHighscore| New highscore, inserting into database and updating user");
                $insertSql = "INSERT INTO `highscores`(`gameId`,`userId`,`date`,`score`) VALUES('%s','%s','%s','%s')";
				$result = $database->query($insertSql,array($gameId,$userId,$date,$score));
				if($result){
					error_log("|InsertHighscore| Added new highscore to database (query result: $result)");
				} else {
					error_log("|InsertHighscore| Failed to add new highscore to database (query result: $result)");
				}
				updateUser($userId,"",calculateUserScore($userId));
            }
        }
        
        /**
         *  selects highscores from a particlar game user or date, 
         *  more parameters mean more specific data     
         * @param int $gameId
         * @param int $userId
         * @param timestamp $date 
         * @return array(highscore(game.name, user.name,score,date))
         */
         function selectHighscores($gameName,$userId,$date)
        {
                $gameId = selectGames(-1,$gameName,"",-1);
                $gameId = ( sizeof($gameId) == 1)?$gameId[0]["id"]:-1;
                
              $database = new Database();
                $sql = "SELECT `games`.`name` AS gameName,`games`.`id` AS gameid,`users`.`id` AS userid,`users`.`nickname` AS userName,`highscores`.`score`,`highscores`.`date`
                        FROM `highscores`  
                        LEFT JOIN `games` ON `highscores`.`gameid` = `games`.`id`
                        LEFT JOIN `users` ON `highscores`.`userid` = `users`.`id`                     
                       ";
                $sql.=($gameId>0||$userId > 0|| $date !="")?" WHERE ":'';
                $sql.=($gameId>0)?"`highscores`.`gameid` = '%s'":"";
                $sql.=($gameId>0 && ($userId > 0 || $date >0))?" AND ":"";
                $sql.=($userId > 0)?"`highscores`.`userId` ='%s'":"";
                $sql.=($date !="" && $userId >0)?" AND `highscores`.`date` = '%s'":'';
                $sql.=($date !="" && $userId <0)?" `highscores`.`date` = '%s'":'';
                
                $param = array();
                ($gameId>0)?array_push($param, $gameId):'';
                ($userId > 0)?array_push($param, $userId ):'';
                ($date>0)?array_push($param, $date):'';
                 $result = $database->resultArray($database->query($sql,$param));
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
    