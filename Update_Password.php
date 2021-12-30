//update hashed password from database


//Post email, password from php or ajax
/*
function changepass(){
	let email = document.getElementById('email').value;
    let pass = document.getElementById('old_pass').value;
	let new_pass = document.getElementById('new_pass').value;
	let conf_pass = document.getElementById('conf_pass').value;
    $.ajax({
        type:"post",
        url:"passupdate.php",
        data: {'email': email, 'curr_pass': pass, 'new_pass': new_pass, 'conf_pass': conf_pass},
        cache: false,
        success: function(html) {
           alert(html);
        }
    });
    return false;
 }
*/
<?php
  include "db-connection.php";
	global $conn;
  $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
  $old_pass = isset($_POST['curr_pass']) ? htmlspecialchars($_POST['curr_pass']) : '';
  $new_pass = isset($_POST['new_pass']) ? htmlspecialchars($_POST['new_pass']) : '';
  $conf_pass = isset($_POST['conf_pass']) ? htmlspecialchars($_POST['conf_pass']) : '';
  if($conn == NULL) {return;}
  $sql = $conn->prepare("SELECT `id`, `emailid`, `passwd` FROM people WHERE emailid = :email");
  $sql->bindParam(':email', $email);
  $sql->execute();
  $row = $sql->fetch();
  if(password_verify($old_pass, $row["passwd"])) {
    if($new_pass === $conf_pass){
      $hashedpass = password_hash($new_pass, PASSWORD_DEFAULT);
      $update = $conn->prepare("UPDATE `people` SET `passwd`= :pass WHERE `people`.`emailid` = :emailid");
      $update->bindParam(':pass', $hashedpass);
      $update->bindParam(':emailid', $email);
      $update->execute();
      echo "Password Changed";
    } else {
      echo "Different password in fields";
    }
  } else {
    echo "Incorrect Current Password";
  }
?>
