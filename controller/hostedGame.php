<?php
include('./model/hostedgameModel.php');

    /**
     * @author Mario Herbers
     */
    class HostedGame
    {
        private $hostedgameModel;
        
        function __construct()
        {
            $this->hostedgameModel = new Hostedgamemodel_Model();            
        }
      
        public function newHostedGame($userId,$gameId,$message,$ipaddress)
        {
            
        }
        
        public function updateHostedGame($id,$message,$amountOfPlayers,$waitingForPlayers)
        {
            
        }
        
        public function getHostedGames($id,$gameId,$userId)
        {
            
        }
        
        public function removeHostedGame($id)
        {
            
        }
    }

?>