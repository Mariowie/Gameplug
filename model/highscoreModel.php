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
            
        }
        
        /**
         * Delets a highscore
         * @param int $gameId
         * @param int $userId 
         * @return void
         */
         function deleteHighscore($gameId,$userId)
        {
            
        }
    class Highscore_Model extends Database
    { 

    }    
?>    