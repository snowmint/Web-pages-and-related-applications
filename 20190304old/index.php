<!DOCTYPE html>
<?php
    if(isset($POST_['ID'])) print_r($_POST);
?>

<html>
    <head>
        <title>FormTest</title>
        
    </head>
    <body>
        <form method="post"> <!--action="welcome.php"-->
         
          User name:<br>
          <input type="text" name="username"><br>
          Sex:<br>
          <input type="radio" name="sex">f<input type="radio" name="username">M<br>
          
          Age:
          <br>
          <input type="text" name="age"><br>
          E-mail Address:<br>
          <input type="text" name="email"><br><br>
          User ID:<br>
          <input type="text" name="id"><br>
          User password:<br>
          <input type="password" name="psw"><br><br>
          
          <input type="submit" value="Submit">
        </form>
    </body>
</html>