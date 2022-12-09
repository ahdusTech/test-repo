<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php

   for($i=1;$i<=10;$i++){
    if($i%2==0)
        {
            for($j=1;$j<=3;$j++)
            echo '<span style="margin-left:32px">*</span>';

        }
        else
        {
            for($j=1;$j<=4;$j++)
            echo '<span style="margin-left:23px">*</span>';
        }
         echo "<br>";
   }
            ?>
</body>
</html>
