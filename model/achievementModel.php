<?php
    include('./database.php');
    
    /**
     * @author Mario Herbers
     */
    class Achievement_Model extends Database
    {        
        /**
         *  function inserts achievement, and returns id.
         * 
         * @param int $gameId
         * @param string $titel
         * @param string $description
         * @param int $points 
         * @return int id
         */
       public function insertAchievement($gameId, $titel, $description, $points)
       {
           
       }
       
       /**
        * selects achievements with game id or only a specific achievement.
        * @return array(achievement(id,game.name,titel,description,points))  
        * @param int $gameId
        * @param int $id 
        */
       public function selectAchievement($gameId,$id)
       {
           
       }
       
       /**
        * updates an achievement
        * @param int $id
        * @param int $gameId
        * @param string $title
        * @param string $description
        * @param int $points
        * @return void
        */
       public function updateAchievement($id,$gameId,$title,$description,$points)
       {
           
       }
       
       /**
        * removes achievement
        * @param int $id 
        * @return void
        */
       public function deleteAchievement($id)
       {
           
       }
       
       /**
        * insert a new user achievement
        * @param int $userId
        * @param int $achievementId
        * @param timestamp $date
        * @return void
        */
       public function insertAchievementUser($userId,$achievementId,$date)
       {
           
       }
       
       /**
        * selects the achievements of a user
        * @param int $userId
        * @param int $gameId 
        * @return void
        */
       public function selectAchievementUser($userId, $gameId) 
       {
          
       }
    }

?>