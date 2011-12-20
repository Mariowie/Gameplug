<?php
        /**
         *
         * @param id $id
         * @param String $name
         * @param timestamp $releaseDate
         * @param String $developer
         * @param String $downloadUrl 
         */
         function insertGame($id,$name,$releaseDate,$developer,$downloadUrl)
        {

        }

        /**
         *
         * @param id $id
         * @param String $name
         * @param timestamp $releaseDate
         * @param String $developer
         * @param String $downloadUrl 
         */
         function updateGame($id,$name,$releaseDate,$developer,$downloadUrl)
        {

        }
        
        /**
         *
         * @param int $id
         * @param String $name
         * @param String $developer 
         * @return array(game(name,releaseDate,developer,downloadUrl))
         */
         function selectGame($id,$name,$developer)
        {
            return array(array("name"=>'mario',"releaseDate"=>1212312,"developer"=>"ik","downloadUrl"=>"googleIt"),array("name"=>'mario',"releasDate"=>1212312,"developer"=>"ik","downloadUrl"=>"googleIt"));
        }
        
        /**
         * deletes a game
         * @param int $id
         * @return void 
         */
         function deleteGame($id)
        {
 
        }
    /**
     * @author Mario Herbers
     */
    class Game_Model extends Database
    { 

    }    
?>    