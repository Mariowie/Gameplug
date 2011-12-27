<?php
    
    /**
     * @author Mario Herbers
     */


         /**
         * Returns a single user
         * @param string $openId
         * @param int $id 
         * @return array(nickname,openid,score)
         */
        function selectUsers($openId,$id)
        {
             $database = new Database();
            if($openId=="" && $id == -1)
                {                   
                    $sql =  "SELECT * FROM `users` ";                    
                    $result =$database->query($sql,array());
                    $array = $database->resultArray($result);
                    return $array;          
                }
            elseif($openId != "" && $id >= 0)
                {                   
                    $sql =  "SELECT * FROM `users` where `openid` = '%s' AND `id` = '%s'";                    
                    $result =$database->query($sql,array($openId,$id));
                    $array = $database->resultArray($result);
                    return $array; 
                }
            elseif($openId !="" || $id >= 0)
                {
                    if($openId !="" )
                    {
                        $sql =  "SELECT * FROM `users` where `openid` = '%s'";                    
                        $result =$database->query($sql,array($openId));
                        $array = $database->resultArray($result);
                        return $array;  
                    }
                    elseif($id >= 0)
                    {
                        $sql =  "SELECT * FROM `users` where `id` = '%s'";                    
                        $result =$database->query($sql,array($id));
                        $array = $database->resultArray($result);
                        return $array; 
                    }
                }   
        }
        
        /**
         * Inserts a new user into the database
         * @param string $openId
         * @param string $nickname 
         * @returns int 
         */
        function insertUser($openId,$nickname)
        {
            $database = new Database();
            $sql =  "INSERT INTO `users`(`nickname`,`openId`) VALUES('%s','%s');";
            return $database->query($sql,array($nickname,$openId),true);                        
        }
        
        /**
         * updates an user
         * @param int $id
         * @param string $nickname
         * @param int $score 
         * @return void
         */
         function updateUser($id,$nickname,$score)
        {
            $database = new Database();
            if($nickname != "" && $score >= 0)
            {
                $sql = "UPDATE `users` SET `nickname`='%s',`score`='%s' WHERE `id` = '%s'";
                $database->query($sql,array($nickname,$score,$id));
                return null;
            }
            elseif($nickname != "" || $score >= 0)
            {
                if($nickname != "")
                {
                    $sql = "UPDATE `users` SET `nickname`='%s' WHERE `id` = '%s'";
                    $database->query($sql,array($nickname,$id));
                    return null;
                }
                elseif ($score) 
                {
                    $sql = "UPDATE `users` SET `score`='%s' WHERE `id` = '%s'";
                    $database->query($sql,array($score,$id));
                    return null;
                }
            }

                
        }  
        
        /**
         *  recalculates the overall score of a user 
         * @param int $id user ID 
         * @return usertTotal score
         */
        function calculateUserScore($id)
        {
            $score  = achievementScore($id);                          
            $score += getHighscoresUser($id);
            return $score;
        }
   