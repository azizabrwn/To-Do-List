<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>    
<link rel = "stylesheet" type="text/css" href="todo.css">
<link href="https://fonts.googleapis.com/css?family=Noticia+Text" rel="stylesheet">

<title>To-Do List</title>
</head>     
<body> 
    <div id="design ">
    <div  class="wrapper ">
    <h2 id="clock">&nbsp; Welcome! <h2>

        <?php
        //if form not submitted, display first form (There are two forms). User will be taken to a list where their entry is displayed, with the option to add more.
        //if the form has not yet been submitted the first time, a new array is created. The input goes in here and leads to the above mentioned list, where the user will stay.

        if (!isset($_POST['submit'])){
            $_SESSION[ 'added']  = array (
                "Smile"
            );
            ?>
       
        <!--Beginning of first input form-->
        <form  method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>What To Do Today?</h2>
        <input type="text" name="added" size = "100 "/>

        <?php

        foreach($_SESSION[ 'added'] as $item){ //places user input  in the designated array.
            //foreach loops through all the items placed in the array and performs the same action on all of them.
            
            echo "<input type = \"hidden\" name = \"thingsToDo[]\" value = \"$item\".\"required\" />\n";
        }
        ?>
        <input type="submit" name="submit" value="Woohoo!"/>

        </form>
        
        <?php

        }else{
            $_SESSION[ 'added']=($_POST['thingsToDo']); // Places user input (a string) into the $_SESSION superglobal.
            $added=explode(',',$_POST['added']); // explode () turns that string into an array. It's placed within a new variable $added.

            array_splice($_SESSION[ 'added'], count($_SESSION[ 'added']), 0, $added);
            $key = 0;
            //Replaces the string version of input with $added (same input just put into an array). 
            //So, whether this is the first or second time submitting, there will always be an array. 
            //The first one where you add your first input ever. When submitted, the above code runs and turns every string into array members.

            echo "<ul>"; //start and end the ul outside the loop so not to make infinite unordered lists
            foreach($_SESSION[ 'added'] as $item){
                echo "<li id=\"list-item-" . $key . "\">".trim($item)."</li>"."\n";
                $key = $key + 1;
                //trims the whitespace that user might've inserted eg. "have    fun" will print "have fun".
            }
            echo "</ul>";

            //End of first form
            ?>
           


            <!--Main list Area-->
           <form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
           <input type="text" name="added" size="80" />
           <?php
           foreach ($_SESSION[ 'added'] as $item){
            echo "<input type=\"hidden\" name=\"thingsToDo[]\" value=\"$item\".\"required\" />\n";
           }
           ?>
          <input type="submit" name="submit" value="Another One!" />
          </form>

            <script>
            //Line Through Completed Tasks
            numTick = 0;
            $("li").click(function(){
           numIndex = $(this).index();
           if(numTick == 0){
               $(this).css("text-decoration", "line-through");
               numTick = 1;
               sessionStorage.setItem(numIndex, numTick);
           }
           else{
               $(this).css("text-decoration", "none");
               numTick = 0;
               sessionStorage.setItem(numIndex, numTick);

           }
   })
           for( var key in sessionStorage){
            //    console.log(sessionStorage(key));
            if (sessionStorage.getItem(key) == 1 ){
                $("#list-item-" + key).css("text-decoration", "line-through");
            }
           }

            //Update Time
            updateClock();
            
            function updateClock( )
            {
            let currentTime = new Date( );
            let currentHours = currentTime.getHours();
            let currentMinutes = currentTime.getMinutes();
            currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
            var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";
            var currentTimeString = currentHours + ":" + currentMinutes + ":" + timeOfDay;

            var img = document.createElement("img");
            if (currentHours < 12){
                document.getElementById("clock").firstChild.nodeValue = "Good Morning!";
                
            } else if(currentHours < 18){
                document.getElementById("clock").firstChild.nodeValue = "Good Afternoon!";
            }else{
                document.getElementById("clock").firstChild.nodeValue = "Good Evening!";
            };
            } ;</script>

         <?php
        }

        ?>
        
        </div>
    </div>  
        </body>
        </html>