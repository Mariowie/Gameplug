<?php
include('./model/userModel.php');

    /**
     * @author Mario Herbers
     */
    class user
    {
        private $userModel;
        
        function __construct()
        {
            $this->userModel = new User_Model();            
        }
      
        /**
         * Checks if the user is in the database, and if
         * the openid provider tells us that the user
         * is the one that he stated he is
         * @param String $openId 
         * @return Boolean
         */
        public function loginUser($openId)
        {
            
        }
        
        /**
         * Adds a new user to the database
         * @param String $openId
         * @param String $nickname 
         * @return id
         */
        public function newUser($openId,$nickname)
        {
            
        }
        
        /**
         * return a list of users or only one user if the id
         * is specified
         * @param int $id
         * @return array(user(nickname,score,id)) 
         */
        public function getUsers($id)
        {
            
        }
    }

?>