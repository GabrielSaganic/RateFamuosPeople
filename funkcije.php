<html>
    <head>    
        <title>Rate famous people</title>
        <link rel="stylesheet" type="text/css" href="CSS.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <style>
            body
            {
                background-repeat: no-repeat;
                background-position: center center; 
                background-size: cover;
            }
        </style>
    </head>
    <?php
    
        #function input gets the file, row shape and file mode
        function input ($dat,$red,$how='a')
        {
            #opens the file
            $f=fopen($dat,$how);
            
            #locks the file so only one can be open in case we have multiple functions that want to access the file.
            flock($f,LOCK_EX);
            
            if(fwrite($f,$red)==false)
            {
                return false;
            }
            
            flock($f,LOCK_UN);
            fclose($f);
            return true;
        }
        
        #function average gets the data from the file and the size of array which contains pictures. Then it opens the file 
        #locks the file, sets the average[$i] and $counter to zero foreach row. The array $array then gets all data from each 
        #row of a file. Variable $sum sums up all grades of each picture and divdes it by how many users have graded 
        #the picture. Then it converts the $average to float and returns it.
        function average_f($dat,$a)
        {
            $grades=array();
            
            for($i=0;$i<$a;$i++)
            {  
                $f=fopen($dat,'r');
                flock($f,LOCK_EX);
                $grades[$i]=0;
                $brojac=0;
                
                while(($redak=fgets($f,4096))!==false)
                {
                    $polje=explode("\t",$redak);
                    $grades[$i]=$grades[$i]+$polje[$i];
                    $brojac++;
                }
                
                flock($f,LOCK_UN);      
                $grades[$i]=$grades[$i]/$brojac*10;
                fclose($f);  
            }
            
            $floats = array_map('floatval', $grades);
            return $floats;

        }
        
        #function printA multisorts the two arrays one containing the averages of each picture and the second one
        #contains the picture. This function helps us organise which picture has what rating.
        #then we print each picture and average with it, but the first picture whill have bigger shape than the others.
        function printA($average,$a,$images,$path)
        {
            array_multisort($average, SORT_DESC, $images);
            $br=0;
            
            foreach($images as $index=>$s)
            {
                echo '<form name="form1" method="POST" action ="">';
                    echo '<div class="text-center">';
                        echo '<table align="center" border="0" cellspacing="0" cellpadding="20">';
                            if($br==0)
                            {
                                echo '<tr>';
                                    echo '<td>';
                                        echo '<p class="font-weight-bold">'.$s.'';
                                        echo '</br>';
                                        echo '<div class="prvi">';
                                            echo '<img src="Slike/'.$path.''.$images[$index].'.jpg" class="img-thumbnail" alt="" width="250" />';        
                                        echo '</div>';
                                        echo '</br>';  
                                        echo '<p class="font-weight-bold">'.number_format($average[$index],2).'% </p>';                                           
                                    echo '</td>';
                                echo '</tr>';
                                $br++;
                            }
                            else
                            {    
                                echo '<tr>';
                                    echo '<td>';
                                        echo '<p class="font-weight-bold">'.$s.'</p>';
                                        echo '<div class="ostali">';
                                            echo '<img src="Slike/'.$path.''.$images[$index].'.jpg" class="img-thumbnail" alt="" width="150" />';        
                                        echo '</div>';
                                        echo '<p class="font-weight-bold">'.number_format($average[$index],2).'% </p>';      
                                    echo '</td>'; 
                                echo '</tr>';
                                           
                            }
                        echo '</table>';
                    echo '</div>';
                    echo '</br>'; 
                echo '</form>';
            }
        }

        #this function gets the user ip each time it has accessed our site so we can manage it and check if the user has been
        #more than twice in an interval less than 1 hour and tried to rate on the site again.
        function getUserIP()
        {
            $client  = @$_SERVER['HTTP_CLIENT_IP'];
            $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            $remote  = $_SERVER['REMOTE_ADDR'];
            
            if(filter_var($client, FILTER_VALIDATE_IP))
            {
                $ip = $client;
            }
            
            elseif(filter_var($forward, FILTER_VALIDATE_IP))
            {
                $ip = $forward;
            }
            
            else
            {
                $ip = $remote;
            }
            
            return $ip;
        }
        
        #simple function for deleting the user ip and time if the time limit of an hour has passed and he accessed the 
        #site again
        function delete($dir, $line)
        {
        $contents = file_get_contents($dir);
        $contents = str_replace($line, '', $contents);
        file_put_contents($dir, $contents);
        }
    ?>
</html>