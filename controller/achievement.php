<?php
include('./model/achievementModel.php');

    /**
     * @author Mario Herbers
     */
    class Achievement
    {
        private $achievementModel;
        
        function __construct()
        {
            $this->achievementModel = new Acievement_Model();            
        }

        
        /**
         * Adds a achievement to the database.
         * Table 'achievement'
         * @param int $gameId 
         * @param String $titel
         * @param String $description   
         * @param int $points 
         * @return void
         * 
         */
        public function newAchievement($gameId,$titel,$description,$points)        
        {                   
            $this->achievementModel->insertAchievement();           
        }
        
        /**
         *  Returns a array of achievements, from the database
         *  Table 'achievement'
         *  @param int id
         *  @param int gameId
         *  @param int userID
         *  @return  array(achievement(titel,description,score))
         */
        public function getAchievements($id,$gameId,$userId)
        {
            return $this->achievementModel->selectAchievements();            
        }
        
        /**
         * adds a new achievement to the user int the database
         * Table 'userachievements' 
         * @param int $id
         * @param int $userId
         * @param timestampe $date 
         * @return void
         */
        public function newUserAchievement($id,$userId,$date)
        {
            $this->achievementModel->insertAchievementUser($id,$userId,$date);
        }
        
        
    }

?>