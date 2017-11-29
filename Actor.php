<!DOCTYPE html>
<html>
    <head>  
        <link rel="stylesheet" type="text/css" href="CSS.css">
        <title>Rate famous people</title>
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
    <body background="pozadina.jpg">
        <nav class="navbar sticky-top navbar-light bg-light">          
            <a class="navbar-brand" href="index.php"><h1 class="font-weight-light">Rate Famous People</h1></a>
            <a class="navbar-brand" href="Actor.php">Actors</a>
            <a class="navbar-brand" href="Singer.php">Musicians</a>
            <a class="navbar-brand" href="Politic.php">Politicians</a>
            <a class="navbar-brand" href="AllRatings.php">All ratings</a>
        </nav>
        <?php   
            #Hello the comments are read as following:
            #First we have a comment about a code piece
            #Second we have the code piece beneath it and so forth
            
            #First we included functions.php which we used later in the program.
            include 'funkcije.php';
            
            #defined \t and \n for easier output to files.            
            define('TAB',"\t");
            define('END',"\n");
            
            #Defined $grades array for later use.
            $grades = array();
            
            #path to our pictures directory.
            $dir='Slike/Actor/';   
            
            #$dir scans dirs with pictures and puts them in $dir_array arrray, so we can add more pictures later 
            #and change nothing.  
            $dir_array= scandir($dir);
            $images=array();
            
            #Defined counter set to zero which helps us put every element one after another in array.
            $counter=0;
            
            #Defined $check set as true to help us with error handling(when the user didn't rate a picture).
            $check=True;
            
            #foreach loop removes . .. and grade.txt from the array and leaves only pictures.
            foreach($dir_array as $p)
            {
                if($p!='.' && $p!='..' && $p!="ocjene.txt")
                {
                    #Here we removed .jpg from picture names because we used the names above the pictures.
                    $images[$counter]=substr($p, 0, strlen($p)-4);
                    $counter++;
                }
            }
            
            #arr_size defined for easy manupulation of array size for multiple loops later on.
            $arr_size = count($images);
            
            #defined a coutner to save each input value with a 
            #different key so we can access each key and take the value
            $counter=0;
            
            #if(!$_POST) checks if we don't have any data stored in files. 
            #If we do not we have to input some data first.
            if(!$_POST)
            {
                #this loop goes thorugh all pictures and makes dinamical list for each.
                foreach($images as $s)
                {
                    echo '<form name="form1" method="POST" action ="">';
                        echo '<div class="text-center">';
                            echo '<p class="font-weight-bold">'.$s.'</p>';
                            echo '<img src="Slike/Actor/'.$s.'.jpg" class="img-thumbnail" alt="" width="300" />';
                        echo '</div>';
                        
                        echo '</br>';

                        echo '<div class="text-center">';
                            echo '<select  name="br-'.$counter.'" class="custom-select" required >';
                                echo '<option selected>Rate me</option>';
                                #makes a dinamical select list from 1 to 10.
                                for($j=1; $j<11; $j++)
                                {
                                    echo '<option value="'.$j.'">'.$j.'</option>';
                                }
                            echo '</select>';    
                        echo '</div>';
                        
                        echo '</br>';
                        $counter++;
                    }  

                    echo '</br>';  
                    
                    echo '<div class="text-center">';            
                        echo '<input name="submit" class="btn btn-success" type="submit" value="Submit">';
                    echo '</div>';
                    
                echo '</form>';
            }
            
            #else if we have some data or we pressed submit button.
            else
            {
                $fileip='actorip.txt';
                
                #getUserIP() gets the user ip and stores it in $ip.
                $ip=getUserIP();
                
                #gets the time of taking the users ip.
                $time=time();
                   
                #checks if file exists if not it creates it and closes it.
                if(!file_exists("actorip.txt"))
                {
                    $f1=fopen("actorip.txt","w");
                    fclose($f1);
                }
                
                #set sameip_exists to false;
                $sameip = false;
                
                #opens a file with r+ permission which makes it so we can read and write in file.
                $f1=fopen("actorip.txt","r+");
                
                #another check for file if it exists just to be sure.
                if(file_exists("actorip.txt"))
                {
                    #while lopp which puts elements of a file in an array and we added a max size of that file to 4096.
                    while(($row=fgets($f1,4096)) !==false) 
                    {
                        $array1= explode("\t",$row); 
                        #if 1st element of a file has the same ip as the one currently accessing the site and the time of 1 hour has
                        #not passed yet we block the user until one hour limit has passed.
                        if($array1[0]==$ip && $time+0<=$array1[1]+3600)
                        {
                            $sameip=true; 
                            break;
                        } 
                        #After the wait time of 1 hour has passed and the same ip accessed the site, the time for ip has been deleted
                        #and the new current time gets added in the file.
                        else if($array1[0]==$ip && $time+0>=$array1[1]+3600)
                        {
                            delete($fileip, $row);
                        }
                    }
                }
                
                #closes the file from up above
                fclose($f1);
                
                #for loop fetches data from the select list which had rating for each picture from 1 to 10.
                for($i=0; $i<$arr_size;$i++)
                {
                    #Checks if all pictures from a category have been rated, if not it outputs an error and
                    #makes a link to go back and rate again.
                    if($_POST['br-'.$i]=="Rate me")
                    {                  
                        echo '<font color="Crimson"> Error, did not rated '.($i+1).'. picture!</br></font>';
                        $check=false;                 
                    }
                }
                
                #If we have the same ip in our file and it hasn't been an hour yet,
                # we block the user for 1 hour so he can't rate for the time beeing.
                if($sameip)
                {
                    echo'<font size="10" >Ooop, You have already rated once. </br>Come back after 1 hour! </font>';
                }
                
                #If the user has rated all pictures then we proceed to outputing the data to a file.
                else if($check)
                {
                    #each row of file actorip.txt has ip written then tab then time and that ends the row.
                    $redip =$ip.TAB.$time.END;
                    
                    #calls a function input() which takes 2 parameters. First file we want to store our data in
                    #second how we want to type our data in the file.
                    input($fileip,$redip); 
                    
                    #defined average array for storing our percent for each user rating.
                    $average=array();
                    
                    #checks if file doesn't exist, if it doesn't it makes the file and closes it
                    if(!file_exists("Slike/Actor/ocjene.txt"))
                    {
                        $f=fopen("Slike/Actor/ocjene.txt","w");
                        fclose($f);
                    }
                    
                    $file='Slike/Actor/ocjene.txt';
                    
                    #this for loop fetches the data from our select list for each picture and saves it in a file
                    #in a way we descriped it in $row variable
                    for($i=0;$i<$arr_size;$i++)
                    {
                        $grades[]= $_POST['br-'.$i];
                        $row2 =$grades[$i].TAB;
                        input($file,$row2);             
                    } 
                    
                    #then we end the row for each user.
                    $row2=END;
                    input($file,$row2); 
                    
                    $path='Actor/';
                    
                    #we call a function ocjena() with two parameters. First file we want to access, second 
                    #the size of array that contains pictures.
                    #the function then returns the average grade for each picture.
                    $average=average_f($file,$arr_size);
                    
                    #function printA() with 4 parameters outputs the average of a category. First parameter is average 
                    #for all pictures in that category. Second is array size, third all pictures, and foruth the 
                    #path to pictures and grades
                    printA($average,$arr_size,$images,$path); 
                    
                    echo '<div class="text-center">';      
                         echo '<a href="Singer.php" class="btn btn-info">Next</a>';
                    echo '</div>';
                    echo '</br>';
                }  
                
                #If the user didn't choose grades for all pictures then it outputs all places the user missed and sets up
                #a link to the page(acts as a refresh)
                else 
                {
                    echo '<a href="Actor.php">Return</a>';
                }
            } 
            echo '</br>';
        ?>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    </body>
    <footer class="footer">  
        Created by: Dario Ognjanovic & Gabriel Saganic
        </br>
        Contact information: <a href="mailto:dognjanovic@student.uniri.hr">
        dognjanovic@student.uniri.hr</a>      
    </footer>
</html>

