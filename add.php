<?php
  require './config.inc.php';
  require './header.inc.php';

  if (empty($_SERVER['REQUEST_METHOD']))
    $method = $REQUEST_METHOD;
  else
    $method = $_SERVER['REQUEST_METHOD'];

  if ($_SERVER['REQUEST_METHOD'] == "GET")
    $id = $_GET['id'];
  else
    $id = $_POST['id'];

  read_passwd_file($id);

  if (isset($_POST['submit'])) {
    $username  = trim($_POST['username']);
    $password  = trim($_POST['password']);
    $passwordv = trim($_POST['passwordv']);
    $realname  = trim($_POST['realname']);
    $realname  = ucwords($realname);
    $email     = trim($_POST['email']);
    $email     = strtolower($email);

    if (is_user($username)) {
      echo "<font class=\"tdmain\">User \"$username\" already exists</font><p>\n";
      $username = '';
    }
    elseif (is_valid_string($username)) {
      echo "<font class=\"tdmain\">Username contains bad characters</font><p>\n";
      $username = '';
    }
    elseif (is_valid_string($password)) {
      echo "<font class=\"tdmain\">Password contains bad characters</font><p>\n";
    }
    elseif (is_valid_string($passwordv)) {
      echo "<font class=\"tdmain\">Password (Verify) contains bad characters</font><p>\n";
    }
    elseif ($password != $passwordv) {
      echo "<font class=\"tdmain\">Passwords don't match</font><p>\n";
    }
    elseif (is_valid_realname($realname)) {
      echo "<font class=\"tdmain\">Realname contains bad characters</font><p>\n";
      $realname = '';
    }
    elseif (is_valid_email($email)) {
      echo "<font class=\"tdmain\">E-Mail contains bad characters</font><p>\n";
      $email = '';
    }
    else {
      echo "<font class=\"tdmain\">User \"$username\" addedd successfuly<p>\n";
      $userid = count($htpUser);
      $htpUser[$userid]['username'] = $username;
      $htpUser[$userid]['password'] = crypt_password($username, $password);
      $htpUser[$userid]['realname'] = $realname;
      $htpUser[$userid]['email']    = $email;
      write_passwd_file($id);
      read_passwd_file($id);
      # clean form
      $username = '';
      $realname = '';
      $email    = '';
    }
  }
  else {
    $username = '';
    $realname = '';
    $email    = '';
  }
?>
<table border="0" cellspacing="3" cellpadding="2" width="600">
  <form method="post" action="<?php echo $PHP_SELF.'?'.random() ?>">
  <input type="hidden" name="id" value="<?php echo $id ?>">
  <tr>
    <td colspan="2" width="100%" align="left" class="tdheader"><?php echo $cfgProgName.' '.$cfgVersion ?></td>
  </tr>
  <tr>
    <td colspan="2" width="100%" align="left" class="tdheader">[ <?php echo $cfgHTPasswd[$id]['D'] ?> ]</td>
  </tr>
  <tr>
    <td width="30%" align="right" class="tdmain">Username:</td>
    <td width="70%" align="left" class="tdmain"><input type="text" name="username" size="25" maxlength="25" value="<?php echo $username ?>"></td>
  </tr>
  <tr>
    <td width="30%" align="right" class="tdmain">Password:</td>
    <td width="70%" align="left" class="tdmain"><input type="password" name="password" size="25" maxlength="25"></td>
  </tr>
  <tr>
    <td width="30%" align="right" class="tdmain">Password (Verify):</td>
    <td width="70%" align="left" class="tdmain"><input type="password" name="passwordv" size="25" maxlength="25"></td>
  </tr>
  <tr>
    <td width="30%" align="right" class="tdmain">Realname:</td>
    <td width="70%" align="left" class="tdmain"><input type="text" name="realname" size="25" maxlength="100" value="<?php echo $realname ?>"></td>
  </tr>
  <tr>
    <td width="30%" align="right" class="tdmain">E-Mail:</td>
    <td width="70%" align="left" class="tdmain"><input type="text" name="email" size="25" maxlength="150" value="<?php echo $email ?>"></td>
  </tr>
  <tr>
    <td colspan="2" width="100%" align="center" class="tdmain"><input type="submit" name="submit" value=" Add User "></td>
  </tr>
  </form>
</table>
<table border="0" cellspacing="3" cellpadding="2" width="600">
  <tr>
    <td width="100%" align="left" class="tdmain">[
    <a href="index.php?<?php echo random() ?>">Main Page</a> |
    <a href="browse.php?id=<?php echo $id ?>&sid=<?php echo random() ?>">Browse User List</a> |
    Add New User |
    <a href="view-htpasswd.php?id=<?php echo $id ?>&sid=<?php echo random() ?>">View .htpasswd file</a> | 
    <a href="create-htaccess.php?id=<?php echo $id ?>&sid=<?php echo random() ?>">Create a Simple .htaccess File</a> ]</td>
  </tr>
</table>
<?php
  require './footer.inc.php';
?>
