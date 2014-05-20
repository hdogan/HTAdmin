<?php
  require './config.inc.php';
  require './header.inc.php';

  $id = $_GET['id'];

  read_passwd_file($id);
?>
<table border="0" cellspacing="3" cellpadding="2" width="600">
  <tr>
    <td width="100%" align="left" class="tdheader"><?php echo $cfgProgName.' '.$cfgVersion ?></td>
  </tr>
  <tr>
    <td width="100%" align="left" class="tdheader">[ <?php echo $cfgHTPasswd[$id]['D'] ?> ]</td>
  </tr>
  <tr>
    <td width="100%" align="left" class="tdmain"><pre class="tdmain"><?php include $cfgHTPasswd[$id]['N'] ?></pre></td>
  </tr>
</table>
<table border="0" cellspacing="3" cellpadding="2" width="600">
  <tr>
    <td width="100%" align="left" class="tdmain">[
    <a href="index.php?<?php echo random() ?>">Main Page</a> |
    <a href="browse.php?id=<?php echo $id ?>&sid=<?php echo random() ?>">Browse User List</a> |
    <a href="add.php?id=<?php echo $id ?>&sid=<?php echo random() ?>">Add New User</a> |
    View .htpasswd file | 
    <a href="create-htaccess.php?id=<?php echo $id ?>&sid=<?php echo random() ?>">Create a Simple .htaccess File</a> ]</td>
  </tr>
</table>
<?php
  require './footer.inc.php';
?>
