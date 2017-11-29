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
            include 'funkcije.php';
            $averageA=array();
            #Defined $averageA array for later use. 
            $averageS=array();
            #Defined $averageS array for later use. 
            $averageP=array();
            #Defined $averageP array for later use. 
            
            $dirA='Slike/Actor/';  
            #$dir scans dirs with pictures and puts them in $dir_array arrray, so we can add more pictures later 
            #and change nothing.   
            $arrayA= scandir($dirA);
            $picturesA=array();
            $tmp=0;
            foreach($arrayA as $pA)
            {
                if($pA!='.' && $pA!='..' && $pA!="ocjene.txt")
                {
                    $picturesA[$tmp]=substr($pA, 0, strlen($pA)-4);
                    $tmp++;
                }
            }
            $arr_sizeA = count($picturesA);
            
            $dirS='Slike/Singer/';          
            $arrayS= scandir($dirS);
            $picturesS=array();
            $tmp=0;
            foreach($arrayS as $pS)
            {
                if($pS!='.' && $pS!='..' && $pS!="ocjene.txt")
                {
                    $picturesS[$tmp]=substr($pS, 0, strlen($pS)-4);
                    $tmp++;
                }
            }
            $arr_sizeS = count($picturesS);
            
            $dirP='Slike/Politic/';          
            $arrayP= scandir($dirP);
            $picturesP=array();
            $tmp=0;
            foreach($arrayP as $pP)
            {
                if($pP!='.' && $pP!='..' && $pP!="ocjene.txt")
                {
                    $picturesP[$tmp]=substr($pP, 0, strlen($pP)-4);
                    $tmp++;
                }
            }
            $arr_sizeP = count($picturesP);
            
            #gets the average for all categories
            $datAa="Slike/Actor/ocjene.txt";
            $averageA=average_f($datAa, $arr_sizeA);
            
            $datSs="Slike/Singer/ocjene.txt";
            $averageS=average_f($datSs, $arr_sizeS);
            
            $datPp="Slike/Politic/ocjene.txt";
            $averageP=average_f($datPp, $arr_sizeP);
             
            #then we multisort all averages and pictures 
            array_multisort($averageA, SORT_DESC, $picturesA);
            array_multisort($averageS, SORT_DESC, $picturesS);
            array_multisort($averageP, SORT_DESC, $picturesP);
            
            $pathA='Actor/';
            $pathS='Singer/';
            $pathP='Politic/';
            
            #For each category we make a fieldset and add all categories to a table so we can organise them in a way 
            #we print pictures of each category in a column next to another category.
            echo '<table align="center" border="0" cellspacing="0" cellpadding="20">';
                echo '<tr valign="top">';
                
                    echo '<td>';
                        echo '<fieldset>';
                            echo '<div class="text-center">';   
                                echo '<p class="font-weight-bold"><h1>Actors</h1></p>';
                            echo '</div>';
                            printA($averageA,$arr_sizeA,$picturesA,$pathA);
                        echo '</fieldset>';
                    echo '</td>';
                    
                    echo '<td>';                    
                        echo '<fieldset>';
                            echo '<div class="text-center">';   
                                echo '<p class="font-weight-bold"><h1>Musicians</h1></p>';
                            echo '</div>';
                            printA($averageS,$arr_sizeS,$picturesS,$pathS);
                        echo '</fieldset>';
                        echo '</td>';
                    
                    echo '<td>';                   
                        echo '<fieldset>';
                            echo '<div class="text-center">';   
                                echo '<p class="font-weight-bold"><h1>Politicians</h1></p>';
                            echo '</div>';          
                            printA($averageP,$arr_sizeP,$picturesP,$pathP);
                        echo '</fieldset>';
                    echo '</td>';
                    
                echo '</tr>';
            echo '</table>';
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
        dognjanovic@student.uniri.hr</a>.      
    </footer>
</html>

