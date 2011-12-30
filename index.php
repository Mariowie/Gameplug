<?php
    ini_set("soap.wsdl_cache_enabled", "1"); // disabling WSDL cache
    //$client = new SoapClient("http://localhost/gameplug/webservice.php?wsdl");
    $website = new website();
   define('url',"http://".$_SERVER['SERVER_NAME'].'/gameplug');
    
    $url = explode("/", str_replace("gameplug/index.php/", "", $_SERVER["REQUEST_URI"]));
        
    if(isset($url[1]))
    {
        if($url[1] == "users")
        {
            if(!isset($url[2]))
            {
                
            }
            elseif (isset($url[2])) 
            {
                $url[2] = $url[2] + 0;
                if(is_int($url[2]))
                {
                    $website->users($url[2]);
                }
                else
                {
                    $website->users();
                }
            }
        }
        elseif ($url[1] == "games") 
        {
            $website->games();
        }
    }
    else 
    {
        $website->users();
    }

    class website
    {
        
        private $client = null;
        private $loader;
        private $twig;
        
        public function __construct()
        {
             require_once 'twig/lib/Twig/Autoloader.php';
          Twig_Autoloader::register();
          $this->client =  new SoapClient("http://localhost/gameplug/webservice.php?wsdl");  
          $this->loader = new Twig_Loader_Filesystem('views');
          $this->twig = new Twig_Environment($this->loader);
        }
        
        /**
         * Makes a page with al list of user
         * or a page of a single users
         * @param int $id 
         */
        public function users($id='all')
        {
            $id= ($id == 'all')?-1:$id;
            $users = $this->client->selectUsers("",$id);
            //echo sizeof($users);
            $content = "";
            if($id >=0)
            {
                
            }
            else 
            {
                $content = $this->twig->render('users.html.twig',array('url'=>url,'users'=>$users));
            }
            echo $this->twig->render('index.html.twig',array('url'=>url,'title'=>'Gameplug','tagline'=>'',
                'content'=>$content));
        }
        
        /**
         * Makes a page showing all of the games the user has
         * highscore / achievements of. Or show only detailed info
         * of one game that the user has played.
         * @param int $id
         * @param int $game 
         */
        public function userGames($id,$game='all')
        {
            
        }
        
        /**
         * Makes a page showing all of the highscore the user has
         * from one game
         * @param int $id
         * @param int $game 
         */
        public function userGameHighscores($id,$game)
        {
            
        }
        
        /**
         * Makes a page showing all of the achievements the user has
         * from one game
         * @param in $id
         * @param int $game 
         */
        public function userGameAchievement($id,$game)
        {
            
        }
        
        /**
         * Makes a page showing all registered games from the database,
         * or show a single game with more detailed info.
         * @param int $id 
         */
        public function games($id='all')
        {
            $id= ($id == 'all')?-1:$id;
            $games = $this->client->selectGame(-1,"","");
            //echo sizeof($users);
            $content = "";
            if($id >=0)
            {
                
            }
            else 
            {
                $content = $this->twig->render('games.html.twig',array('url'=>url,'games'=>$games));
            }
            echo $this->twig->render('index.html.twig',array('url'=>url,'title'=>'Gameplug','tagline'=>'',
                'content'=>$content)); 
        }
        
        /**
         * Makes a page showing all of the available achievements from 
         * a single game.
         * @param int $id 
         */
        public function gameAchievements($id)
        {
            
        }
        
        /**
         * Makes a page showing all of the highscores from 
         * a single game.
         * @param int $id 
         */
        public function gameHighscores($id)
        {
            
        }
    }

?>