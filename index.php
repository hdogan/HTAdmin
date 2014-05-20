<?php
  require './config.inc.php';
  require './header.inc.php';
?>
<table border="0" cellspacing="3" cellpadding="2" width="600">
  <tr>
    <td colspan="2" width="100%" align="left" class="tdheader"><?php echo $cfgProgName.' '.$cfgVersion ?></td>
  </tr>
<?php
  for ($fileid = 0; $fileid < count($cfgHTPasswd); $fileid++) {
    init_passwd_file($fileid, "Main Page");

    $bgcolor		      = "#DDDDDD";
    if ($fileid % 2) $bgcolor = "#C0C0C0";
    if (!empty($cfgHTPasswd[$fileid]['N'])) {
      echo "  <tr>\n".
	   "    <td bgcolor=\"$bgcolor\" width=\"85%\" align=\"left\" class=\"tdmain\">".($fileid+1).") ".$cfgHTPasswd[$fileid]['D']."</td>\n".
	   "    <td bgcolor=\"$bgcolor\" width=\"15%\" align=\"center\" class=\"tdmain\"><a href=\"browse.php?id=$fileid&sid=".random()."\">[ Browse ]</a></td>\n".
	   "  </tr>\n";
    }
  }  
?>
</table>
<?php
  require './footer.inc.php';
?>
