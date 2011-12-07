<?php
    include('./database.php');
    
    /**
     * @author Mario Herbers
     */
    class User_Model extends Database
    { 
        /**
         * Returns a single user
         * @param String $openId
         * @param int $id 
         * @return array(nickname,openid,score)
         */
        public function selectUsers($openId,$id)
        {
            
        }
        
        /**
         * Inserts a new user into the database
         * @param String $openId
         * @param String $nickname 
         * @returns int id
         */
        public function insertUser($openId,$nickname)
        {
            
        }
        
        /**
         * updates an user
         * @param int $id
         * @param String $nickname
         * @param int $score 
         * @return void
         */
        public function updateUser($id,$nickname,$score)
        {
            
        }
    }    
?>    