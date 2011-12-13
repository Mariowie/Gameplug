<?php
	


    class Webservice
    {
        
        /**
         * Makes a page with al list of user
         * or a page of a single users
         * @param int $id 
         */
        public function users($id='all')
        {
            
        }
        
        /**
         * Makes a page showing all of the games the user has
         * highscore / achievements of. Or show only detailed info
         * of one game that the user has played.
         * @param int $id
         * @param int $game 
         */
        public function userGames($id,$game='all')
        {
            
        }
        
        /**
         * Makes a page showing all of the highscore the user has
         * from one game
         * @param int $id
         * @param int $game 
         */
        public function userGameHighscores($id,$game)
        {
            
        }
        
        /**
         * Makes a page showing all of the achievements the user has
         * from one game
         * @param in $id
         * @param int $game 
         */
        public function userGameAchievement($id,$game)
        {
            
        }
        
        /**
         * Makes a page showing all registered games from the database,
         * or show a single game with more detailed info.
         * @param int $id 
         */
        public function games($id='all')
        {
            
        }
        
        /**
         * Makes a page showing all of the available achievements from 
         * a single game.
         * @param int $id 
         */
        public function gameAchievements($id)
        {
            
        }
        
        /**
         * Makes a page showing all of the highscores from 
         * a single game.
         * @param int $id 
         */
        public function gameHighscores($id)
        {
            
        }
    }

?>