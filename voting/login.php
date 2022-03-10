<?php
include 'head.php';
 echo '
 <div>
    <h3> Log In</h3>
    <form name="login" action="after_login.php" method="POST">
    <div class="form-group">
    <label>Username:</label> 
    <input class="form-control" type="email" name="username">
    </div>
    <div class="form-group"> 
    <label>Password:</label>
    <input class="form-control" type="password" name="passw">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
 </div>
 ';
?>