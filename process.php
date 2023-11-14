<?php

    $function = $_POST['function'];
    
    $log = array();
    
    switch($function) {
    
    	 case('getState'):
        	 if(file_exists('chat.txt')){
               $lines = file('chat.txt');
        	 }
				$username = $_POST['name'];
				$usersFile = 'users.txt';
				$file = file_get_contents($usersFile);
				if (!strpos($file,$username)) 
				fwrite(fopen($usersFile, 'a'), $username. "\n");
				$usersList = [];
				$users = file('users.txt');
				foreach ($users as $user_num => $user) {
					$usersList[] =  $user = str_replace("\n", "", $user);
				}
				$log['users'] = $usersList; 
				$log['currentUser'] = $username; 
            $log['state'] = count($lines); 
        	 break;	
    	
    	 case('update'):
        	$state = $_POST['state'];
			// $users = file('users.txt');
        	if(file_exists('chat.txt')){
        	   $lines = file('chat.txt');
        	 }
        	 $count =  count($lines);
	
				
        	 if($state == $count){
        		 $log['state'] = $state;
        		 $log['text'] = false;
        		 
        		 }
        		 else{
        			 $text= array();
        			 $log['state'] = $state + count($lines) - $state;
        			 foreach ($lines as $line_num => $line)
                       {
        				   if($line_num >= $state){
                         $text[] =  $line = str_replace("\n", "", $line);
        				   }
         
                        }

        			$log['text'] = $text; 
        		 }
        	  
             break;
    	 
    	 case('send'):
		  $nickname = htmlentities(strip_tags($_POST['nickname']));
			 $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			  $message = htmlentities(strip_tags($_POST['message']));
			  
			  $regExIban="/[A-Za-z]{2}\s?[0-9]{2}\s?[A-Za-z]{1}\s?[0-9]{10}/";
   
		 if(($message) != "\n"){
		     
		     if(preg_match($regExIban, $message)) 
		       $message = preg_replace($regExIban, '*****', $message);

         
                
			 if(preg_match($reg_exUrl, $message, $url)) {
       			$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
				} 
			 

             	 fwrite(fopen('chat.txt', 'a'), "<span>". $nickname . "</span>" . $message = str_replace("\n", " ", $message) . "\n"); 


				  
			// 	  $usersFile = 'users.txt';
		
			// 	  $file = file_get_contents($usersFile);
				
			//  if (!strpos($file,$nickname)) 
		  	//    fwrite(fopen($usersFile, 'a'), $nickname.";". "\n");
			
	      //   $utenti=explode(";",$file);
			// $log['utenti']=$utenti;
			   
		 }
        	 break;
    	
    }
    
    echo json_encode($log);

?>