<?php
include('./model/gameModel.php');

    /**
     * @author Mario Herbers
     */
    class Game
    {
        /**
         *
         * @param id $id
         * @param String $name
         * @param timestamp $releasDate
         * @param String $developer
         * @param String $downloadUrl 
         */
        public function insertGame($id,$name,$releasDate,$developer,$downloadUrl)
        {

        }

        
        public function updateGame($id,$name,$releasDate,$developer,$downloadUrl)
        {

        }
        
        /**
         *
         * @param int $id
         * @param String $name
         * @param String $developer 
         * @return array(game(name,releaseDate,developer,downloadUrl))
         */
        public function selectGame($id,$name,$developer)
        {

        }
        
        /**
         * deletes a game
         * @param int $id
         * @return void 
         */
        public function deleteGame($id)
        {

        }
    }

?>
    