<?php
    
    
    /**
     * @author Mario Herbers
     */
    
       /**
        * selects achievements with game id or only a specific achievement.
        * @return array(achievement(id,game.name,titel,description,points))  
        * @param int $gameId
        * @param int $id 
        */
       function selectAchievement($gameId,$id)
       {
           $array = array();
           $database = new database();
           array_push($array,array('id'=>1,'gameName'=>'test','titel'=>'achievement','description'=>'desc','points'=>123));
           array_push($array,array('id'=>2,'gameName'=>'wax','titel'=>'drasdf','description'=>'weewrew','points'=>333));
           return $array;
       }
       
       /**
         *  function inserts achievement, and returns id.
         * 
         * @param int $gameId
         * @param string $titel
         * @param string $description
         * @param int $points 
         * @return int id
         */
       function insertAchievement($gameId, $titel, $description, $points)
       {
           return 91;
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
       function updateAchievement($id,$gameId,$title,$description,$points)
       {
           
       }
       
       /**
        * removes achievement
        * @param int $id 
        * @return void
        */
       function deleteAchievement($id)
       {
           
       }
       
       /**
        * insert a new user achievement
        * @param int $userId
        * @param int $achievementId
        * @param timestamp $date
        * @return void
        */
       function insertAchievementUser($userId,$achievementId,$date)
       {
           
       }
       
       /**
        * selects the achievements of a user
        * @param int $userId
        * @param int $gameId 
        * @return void
        */
       function selectAchievementUser($userId, $gameId) 
       {
          
       }
       
    class Achievement_Model// extends Database
    {      
        
            

    }

?>