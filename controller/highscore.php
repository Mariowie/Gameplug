<?php
include('./model/highscoreModel.php');

    /**
     * @author Mario Herbers
     */
    class Highscore
    {
        private $highscoreModel;
        
        function __construct()
        {
            $this->highscoreModel = new Highscore_Model();            
        }
      
        public function newHighscore($userId,$gameId,$score,$date)
        {
            
        }
        
        public function getHighscores($userId,$gameId)
        {
            
        }
        
    }

?>