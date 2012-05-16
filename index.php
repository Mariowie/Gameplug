<?php
    ini_set("soap.wsdl_cache_enabled", "1"); // disabling WSDL cache
   
    $website = new website();
   define('url',"http://".$_SERVER['SERVER_NAME'].'/gameplug');
    // get the slugs in the URI
    $url = explode("/", str_replace("gameplug/index.php/", "", $_SERVER["REQUEST_URI"]));    
    if(isset($url[1]))
    {
       // if the first slug is users
        if($url[1] == "users")
        { 
            // if the second slug doesn't exist
            if(!isset($url[2]))
            {
                // show all the users
                return $website->users();
            }
            // if the second slug is set
            elseif (isset($url[2])) 
            {               
                $url[2] = $url[2] + 0;
                // check if second slug is a integer
                // if it is show the user page of the 
                // user with this id
                if(is_int($url[2]))
                {
                    return $website->users($url[2]);
                }
                // there isn't a usable user id thus all the users
                // will be shown
                else
                {
                    return $website->users();
                }
            }
        }
        elseif ($url[1] == "games") 
        {
            if(!isset($url[2]) && !isset($url[3]))
            {
                return $website->games();
            }
            elseif (isset($url[2]) && isset($url[3])) 
            {
                $url[2] = $url[2];
                if(is_string($url[2])&& is_string($url[3]))
                {
                    return $website->games($url[3],$url[2]);
                }
                else
                {
                    return $website->games();
                }
            }
            else
            {
                return $website->games();
            }
        }
        elseif ($url[1]=="") 
        {
            return $website->users();
        }
         return $website->users();
    }
    else 
    {
        return $website->users();
    }


/**
*  Class website deals with the presentation of the webpages
*/ 

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
            $userRequest = $this->client->selectUsers("",$id);
            $users = (sizeof($userRequest)==0)?$this->client->selectUsers("",-1):$userRequest;
            $id = (sizeof($userRequest)==0)?-1:$id;
            $content = "";
            if($id >=0)
            {
                
                $highscores = $this->client->selectHighscores("",$id,"","");
                $highscoreTemplate = $this->twig->render('highscores.html.twig',
                                                            array(
                                                                    'highscores'=>$highscores,
                                                                    'subject' =>$users[0],
                                                                    'url'=>url
                                                                ));
                $achievements = $this->client->selectAchievementsUser($id,-2);
                $achievementsTemplate = $this->twig->render('achievements.html.twig',
                                                            array(
                                                                    'achievements'=>$achievements,
                                                                    'subject' =>$users[0],
                                                                    'url'=>url,
                                                                    'subjectIsUser'=>true
                                                                ));
                $content = $this->twig->render('user.html.twig',
                                array(
                                        'nickname'=>$users[0]->nickname,
                                        'ranking'=>$users[0]->rank,
                                        'score'=>$users[0]->score,
                                        'highscore'=>sizeof($highscores),
                                        'listOfHighscores' => $highscoreTemplate,
                                        'listOfAchievements' => $achievementsTemplate,
                                       
                                        
                                            
                        ));
            }
            else 
            {
                $content = $this->twig->render('users.html.twig',array('url'=>url,'users'=>$users));
            }
            echo $this->twig->render('index.html.twig',array('url'=>url,'title'=>'Gameplug','tagline'=>'',
                'content'=>$content, 'users' => 'active',
                                        'games' => 'inactive',));
        }
        
        
        /**
         * Makes a page showing all registered games from the database,
         * or show a single game with more detailed info.
         * @param int $id 
         */
        public function games($id='all',$developer = "")
        {

            $id= ($id == 'all')?-1:$id;
            $id = str_replace("%20", " ", $id);
            echo $id;
            $gameRequest = $this->client->selectGames(-1,$id,$developer,-1); 
            
            $id = (sizeof($gameRequest)<=0)?"":$id;
            
            $games = (sizeof($gameRequest)<=0)?$this->client->selectGames(-1,$id,"",-1):$gameRequest;
            $content = "";
            if($id !="")
            {
                $highscores = $this->client->selectHighscores($id,-1,"",$developer);
                $achievements = $this->client->selectAchievements($id,-1,"",$developer); 
                $achievementsAchieved = $this->twig->render('achievementAchieved.html.twig',
                    array('listOfAchievements'=>$achievements,
                        'chartAchieved'=>'achievedChar'));
                $achievementsScore = $this->twig->render('achievementScore.html.twig',
                    array('listOfAchievements'=>$achievements,
                        'chartScore'=>'scoreChar'));
                $highscoresTemplate = $this->twig->render('highscoresOverview.html.twig',
                    array(
                        'releaseDate' => $games[0]->releaseDate,
                        'listOfHighscores'=>$highscores,
                        'highscoreChart'=>'highscoreChart',
                        'gameName'=>$games[0]->name));
                $content = $this->twig->render('game.html.twig',
                                array(
                                        'gameName'=>$games[0]->name,
                                        'downloadUrl'=>$games[0]->downloadUrl,
                                        'highscore'=>$games[0]->highscore,
                                        'releaseDate' => $games[0]->releaseDate,
                                        'AmountOfhighscores' => sizeof($highscores),
                                        'achievements'=>$games[0]->achievements,
                                        'listOfAchievements'=>$achievements,
                                        'listOfHighscores'=>$highscores,
                                        'developer'=>$games[0]->developer,
                                        'chartAchieved'=>'achievedChar',
                                        'chartScore'=>'scoreChar',
                                        'highscoreChart'=>'highscoreChart',
                                        'script'=>$achievementsAchieved.$achievementsScore.$highscoresTemplate 
                                )
                        );
                
            }
            else 
            {
                $content = $this->twig->render('games.html.twig',array('url'=>url,'games'=>$games));
            }
            echo $this->twig->render('index.html.twig',array('url'=>url,'title'=>'Gameplug','tagline'=>'',
                'content'=>$content, 'users' => 'inactive',
                                        'games' => 'active',)); 
        }       
    }

?>