<?php

    abstract class StrategyForm {

             protected $errors = array();
             public function __construct($str) {
                    $this->validate($str);
             }
             abstract protected function validate($str);   
             public function countErrors() {
                    return count($this->errors);  
             }             
             public function setError($error) {
                    $this->errors[] = $error;
             } 
             public function fetch() {
                    $error = each($this->errors);
                    if(isset($error)) {
                       return $error['value']; 
                    } else {
                       reset($this->errors);
                       return false;
                    }
             }
    } 


    class Username extends StrategyForm {

          public function validate($user) {
                 if(strlen($user) > 20) {
                    $this->setError("The username is too long!"); 
                 }

                 if(strlen($user) <= 4) {
                    $this->setError("The username is too short!"); 
                 }

                 if(!preg_match('/^[a-zA-Z]$/', $user)) {
                     $this->setError('The username is invalid!'); 
                 }

          }
    }

    class Password extends StrategyForm {

          public function validate($pass) {
                 if(strlen($pass) > 20) {
                    $this->setError("The password is too long!"); 
                 }

                 if(strlen($pass) <= 4) {
                    $this->setError("The password is too short!"); 
                 }
          }
    }

    class Email extends StrategyForm {

          public function validate($str) {
                 if(!preg_match('/^[a-zA-z]@[a-zA-Z0-9]\.[a-z]{2,4}/', $str)) {
                     $this->setError('This email is invalid!');  
                 }
          }
    }

    if(isset($_POST['user']) && isset($_POST['password']) && isset($_POST['email'])) {

             $username = new Username($_REQUEST['user']); 
             $password = new Password($_REQUEST['password']);
             $email    = new Email($_REQUEST['email']);
 
             $arr = array($username, $password, $email);
             $errors = array();

             foreach($arr as $ob) {
 
                     if($ob->countErrors() > 0) {
 
                             while(($err=$ob->fetch()) != false) {
                                    $errors[] = $err;
                             }//endwhile
                     }//endif
             }//endforeach
    
             //display the errors of form
             echo"<pre>";
             print_r($errors); 
             echo"</pre>";
    }

?>

<form action="<?php echo$_SERVER['PHP_SELF'];?>" method="POST">

<div>
 <label for="user">Name <span class="required">*</span></label>
 <input type="text" name="user" value="" id="name">
</div>

<div>
 <label for="password">password <span class="required">*</span></label>
 <input type="text" name="password" value="" id="password">
</div>

<div>
 <label for="email">Email <span class="required">*</span></label>
 <input type="text" name="email" value="" id="email">
</div>

<div class="bar"><input type="submit" name="done" value="make it so!"></div>
</form>