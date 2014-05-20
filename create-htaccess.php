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
    $path     = trim($_POST['path']);
    $filename = trim($_POST['filename']);
    $userfile = trim($_POST['userfile']);

    if (!is_dir($path)) {
      echo "<font class=\"tdmain\">Path \"$path\" is not a valid directory</font><p>\n";
      $path = '';
    }
    elseif (file_exists($path.'/'.$filename)) {
      echo "<font class=\"tdmain\">Sample .htaccess file already exists</font><p>\n";
      $filename = '';
    }
    elseif (!($fp = @fopen($path.'/'.$filename, "w"))) {
      echo "<font class=\"tdmain\">Could not open sample .htaccess file for writing</font><p>\n";
      $filename = '';
    }
    else {
      $content  = "AuthUserFile ".$path."/".$userfile."\n";
      $content .= "AuthType Basic\n";
      $content .= "AuthName \"My Private Area\"\n\n";
      $content .= "require valid-user\n";
      fwrite($fp, $content);
      fclose($fp);
      echo "<font class=\"tdmain\">Sample .htaccess file created successfuly<br>Your .htaccess file contains:\n";
      echo "<font size=\"3\" face=\"times new roman\"><pre>---[ begin ]--\n$content---[ end ]---</pre></font><p>\n";
    }
  }
  else {
    $path     = strrchr($cfgHTPasswd[$id]['N'], '/');
    $path     = str_replace($path, '', $cfgHTPasswd[$id]['N']);
    $filename = '.htaccess';
    $userfile = str_replace($path, '', $cfgHTPasswd[$id]['N']);
    $userfile = substr($userfile, 1, strlen($userfile));
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
    <td width="30%" align="right" class="tdmain">Path:</td>
    <td width="70%" align="left" class="tdmain"><input type="text" name="path" size="25" value="<?php echo $path ?>"></td>
  </tr>
  <tr>
    <td width="30%" align="right" class="tdmain">.htaccess File:</td>
    <td width="70%" align="left" class="tdmain"><input type="text" name="filename" size="25" value="<?php echo $filename ?>"></td>
  </tr>
  <tr>
    <td width="30%" align="right" class="tdmain">User File (Password File):</td>
    <td width="70%" align="left" class="tdmain"><input type="text" name="userfile" size="25" value="<?php echo $userfile ?>"></td>
  </tr>
  <tr>
    <td colspan="2" width="100%" align="center" class="tdmain"><input type="submit" name="submit" value=" Create "></td>
  </tr>
  </form>
</table>
<table border="0" cellspacing="3" cellpadding="2" width="600">
  <tr>
    <td width="100%" align="left" class="tdmain">[
    <a href="index.php?<?php echo random() ?>">Main Page</a> |
    <a href="browse.php?id=<?php echo $id ?>&sid=<?php echo random() ?>">Browse User List</a> |
    <a href="add.php?id=<?php echo $id ?>&sid=<?php echo random() ?>">Add New User</a> |
    <a href="view-htpasswd.php?id=<?php echo $id ?>&sid=<?php echo random() ?>">View .htpasswd file</a> | 
    Create a Simple .htaccess File ]</td>
  </tr>
</table>
<?php  
  require './footer.inc.php';
?>

