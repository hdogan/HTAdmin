<?php
  require './config.inc.php';
  require './header.inc.php';

  $id = $_GET['id'];

  read_passwd_file($id);

  if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];
    if (!is_user($htpUser[$userid]['username']))
      ht_error("No such user (UserID: $userid)", "Browse Page (Delete)");
    echo "<font class=\"tdmain\">User \"".$htpUser[$userid]['username']."\" deleted successfuly</font><p>\n";
    $htpUser[$userid]['username'] = '';
    $htpUser[$userid]['password'] = '';
    $htpUser[$userid]['realname'] = '';
    $htpUser[$userid]['email']    = '';
    write_passwd_file($id);
    read_passwd_file($id);
  }
?>
<script language="JavaScript">
function delUser(userid) {
  cf = confirm("Are you sure you want to delete this user?");
  if (cf) {
    document.location = "browse.php?id=<?php echo $id ?>&userid="+userid+"&sid=<?php echo random() ?>";
  }
}
</script>
<table border="0" cellspacing="3" cellpadding="2" width="600">
  <tr>
    <td colspan="5" width="100%" align="left" class="tdheader"><?php echo $cfgProgName.' '.$cfgVersion ?></td>
  </tr>
  <tr>
    <td colspan="5" width="100%" align="left" class="tdheader">[ <?php echo $cfgHTPasswd[$id]['D'] ?> ]</td>
  </tr>
  <tr>
   <td align="left" class="tdheader"># Username</td>
   <td align="left" class="tdheader">Realname</td>
   <td align="left" class="tdheader">E-Mail</td>
   <td align="center" class="tdheader">Edit</td>
   <td align="center" class="tdheader">Delete</td>
  </tr>
<?php
  $htpCount = 0;
  for ($userid = 0; $userid < count($htpUser); $userid++) {
    $bgcolor = "#EEEEEE";
    if ($userid % 2) $bgcolor = "#FFFFFF";
    if (!empty($htpUser[$userid]['username'])) {
      $htpCount++;
      echo "  <tr>\n".
	   "    <td bgcolor=\"$bgcolor\" align=\"left\" class=\"tdmain\"><b>".($userid+1).")</b> ".$htpUser[$userid]['username']."</td>\n".
	   "    <td bgcolor=\"$bgcolor\" align=\"left\" class=\"tdmain\">".$htpUser[$userid]['realname']."</td>\n".
	   "    <td bgcolor=\"$bgcolor\" align=\"left\" class=\"tdmain\">".$htpUser[$userid]['email']."</td>\n".
	   "    <td bgcolor=\"$bgcolor\" align=\"center\" class=\"tdmain\"><a href=\"edit.php?id=$id&userid=$userid&sid=".random()."\">[ Edit ]</a></td>\n".
	   "    <td bgcolor=\"$bgcolor\" align=\"center\" class=\"tdmain\"><a href=\"javascript:delUser('$userid')\">[ Delete ]</a></td>\n".
	   "  </tr>\n";
    }
  }  
  if ($htpCount < 1) {
    echo "  <tr>\n".
	 "    <td colspan=\"5\" bgcolor=\"$bgcolor\" width=\"100%\" align=\"left\" class=\"tdmain\">This .htpasswd file is empty</td>\n".
	 "  </tr>\n";
  }
?>
</table>
<table border="0" cellspacing="3" cellpadding="2" width="600">
  <tr>
    <td width="100%" align="left" class="tdmain">[
    <a href="index.php?<?php echo random() ?>">Main Page</a> |
    Browse User List |
    <a href="add.php?id=<?php echo $id ?>&sid=<?php echo random() ?>">Add New User</a> |
    <a href="view-htpasswd.php?id=<?php echo $id ?>&sid=<?php echo random() ?>">View .htpasswd file</a> |
    <a href="create-htaccess.php?id=<?php echo $id ?>&sid=<?php echo random() ?>">Create a Simple .htaccess File</a> ]</td>
  </tr>
</table>
<?php
  require './footer.inc.php';
?>
