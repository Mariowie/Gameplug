<?php
    include('./database.php');
    
    /**
     * @author Mario Herbers
     */
    class Highscore_Model extends Database
    { 
        /**
         * Inserts a new highscore
         * @param int $gameId
         * @param int $userId
         * @param int $score
         * @param Timestamp $date 
         * @return void
         */
        public function insertHighscore($gameId,$userId,$score,$date)
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
        public function selectHighscore($gameId,$userId,$date)
        {
            
        }
        
        /**
         * Delets a highscore
         * @param int $gameId
         * @param int $userId 
         * @return void
         */
        public function deleteHighscore($gameId,$userId)
        {
            
        }
    }    
?>    