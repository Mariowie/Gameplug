<?php
include('./model/gameModel.php');

    /**
     * @author Mario Herbers
     */
    class Game
    {
        
        private $gameModel;
        
        function __construct()
        {
            $this->gameModel = new Game_Model();            
        }

        /**
         * Registers a new game
         * @param int $id
         * @param String $gameDeveloper
         * @param String $name
         * @param Timestamp $releaseDate
         * @param String $downloadUrl 
         */
        public function newGame($id,$gameDeveloper,$name,$releaseDate,$downloadUrl)
        {
            
        }
        
        /**
         * Get games that comply to the set parameters
         * @param int $id
         * @param String $gameDeveloper
         * @param String $name
         * @param Timestamp $releaseDate 
         * @return array(game(id,name,gamedeveloper,releasedate,downloadUrl))
         */
        public function getGames($id,$gameDeveloper,$name,$releaseDate)
        {
            
        }
    }

?>
    