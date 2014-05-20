<?
error_reporting(E_ALL ^ E_NOTICE);

$cfgProgName	= 'HTAdmin';
$cfgVersion	= '1.2.6';

$cfgUseAuth	= true;
$cfgSuperUser	= 'admin';
$cfgSuperPass	= 'password';
$cfgBadChars	= '`~!@#$%^&*()+=[]{};\'\\:"|,/<>? ';
$cfgBadCharsE	= '`~!#$%^&*()+=[]{};\'\\:"|,/<>?, ';
$cfgBadCharsR	= '`~!@#$%^&*()+=[]{};\'\\:"|,/<>?';

#
# You can find htpasswd.exe tool in this package or at:
# ftp://ftp.bnsi.net/pub/apache/htpasswd.exe or at:
# http://www.hido.net/projects/htadmin/htpasswd.exe
#
$cfghtpasswdEXE = 'C:\Program Files\Apache Group\Apache\bin\htpasswd.exe';

$cfgHTPasswd[0]['N'] = '/your/protected/web/directory/full/path/.htpasswd'; # Full path and filename
$cfgHTPasswd[0]['D'] = 'Sample htpasswd file #1'; # Description
$cfgHTPasswd[1]['N'] = '';
$cfgHTPasswd[1]['D'] = '';
$cfgHTPasswd[2]['N'] = '';
$cfgHTPasswd[2]['D'] = '';

$htpUser = array();

$version = explode(".", phpversion());
if (intval($version[0]) < 5 && intval($version[1]) < 1) {
  if (!isset($_POST))
    $_POST = $HTTP_POST_VARS;
  if (!isset($_GET))
    $_GET = $HTTP_GET_VARS;
  if (!isset($_SERVER))
    $_SERVER = $HTTP_SERVER_VARS;
}

function is_valid_string($string) {
  global $cfgBadChars;

  if (empty($string))
    return true;

  for ($i = 0; $i < strlen($cfgBadChars); $i++) {
    if(strpos($string, $cfgBadChars[$i]) !== false)
      return true;
  }
  return false;
}

function is_valid_email($string) {
  global $cfgBadCharsE;

  if (empty($string))
    return false;

  for ($i = 0; $i < strlen($cfgBadCharsE); $i++) {
    if(strpos($string, $cfgBadCharsE[$i]) !== false)
      return true;
  }
  return false;
}

function is_valid_realname($string) {
  global $cfgBadCharsR;

  if (empty($string))
    return false;

  for ($i = 0; $i < strlen($cfgBadCharsR); $i++) {
    if (strstr($string, $cfgBadCharsR[$i]))
      return true;
  }
  return false;
}

function ht_error($errmsg, $htfunction) {
  echo "<p><font class=\"tdmain\"><b>Error:</b> (in function <i>$htfunction</i>) $errmsg</font><p>";
  require './footer.inc.php';
  exit;
}

function init_passwd_file($filenum, $htfunction) {
  global $cfgHTPasswd;

  if (empty($cfgHTPasswd[0]['N']))
    ht_error("First .htpasswd file is not set in config file", $htfunction);

  if (empty($cfgHTPasswd[$filenum]['N']))
    return;

  if (!file_exists($cfgHTPasswd[$filenum]['N']))
    ht_error(".htpasswd ($filenum) file is not exists", $htfunction);

  if (!is_readable($cfgHTPasswd[$filenum]['N']))
    ht_error(".htpasswd ($filenum) file is not readable", $htfunction);

  if (!is_writeable($cfgHTPasswd[$filenum]['N']))
    ht_error(".htpasswd ($filenum) file is not writeable", $htfunction);
}

function read_passwd_file($filenum) {
  global $cfgHTPasswd, $htpUser;

  init_passwd_file($filenum, "read_passwd_file");

  $htpUser = array();

  if (!($fpHt     = fopen($cfgHTPasswd[$filenum]['N'], "r"))) {
    ht_error("Could not open ".$cfgHTPasswd[$filenum]['N']." file for reading", "read_passwd_file");
  }
  $htpCount = 0;
  while (!feof($fpHt)) {
    $fpLine = fgets($fpHt, 512);
    $fpLine = trim($fpLine);
    $fpData = explode(":", $fpLine);
    $fpData[0] = trim($fpData[0]);
    if (isset($fpData[1]))
	$fpData[1] = chop(trim($fpData[1]));

    if (empty($fpLine) || $fpLine[0] == '#' || $fpLine[0] == '*'
    ||	empty($fpData[0]) || empty($fpData[1]))
      continue;

    $htpUser[$htpCount]['username'] = $fpData[0];
    $htpUser[$htpCount]['password'] = $fpData[1];
    $htpUser[$htpCount]['realname'] = $fpData[2];
    $htpUser[$htpCount]['email']    = $fpData[3];
    $htpCount++;
  }
  fclose($fpHt);
  return;
}

function write_passwd_file($filenum) {
  global $cfgHTPasswd, $htpUser;

  init_passwd_file($filenum, "write_passwd_file");

  if (($fpHt = fopen($cfgHTPasswd[$filenum]['N'], "w"))) {
    for ($i = 0; $i < count($htpUser); $i++) {
      if (!empty($htpUser[$i]['username']))
        fwrite($fpHt, $htpUser[$i]['username'].":".
		      $htpUser[$i]['password'].":".
		      $htpUser[$i]['realname'].":".
		      $htpUser[$i]['email']."\n");
    }
    fclose($fpHt);
  }
  else {
    ht_error("Could not open ".$cfgHTPasswd[$filenum]['N']." file for reading", "write_passwd_file");
  }
  return;
}

function is_user($username) {
  global $htpUser;

  if (empty($username))
    return false;

  for ($i = 0; $i < count($htpUser); $i++) {
    if ($htpUser[$i]['username'] == $username)
      return true;
  }
  return false;
}

function random() {
  srand ((double) microtime() * 1000000);
  return rand();
}

function crypt_password($username, $password) {
  global $cfghtpasswdEXE;

  if (empty($password))
    return "** EMPTY PASSWORD **";

  if (strstr(strtoupper(PHP_OS), "WINNT") ||
      strstr(strtoupper(PHP_OS), "WINDOWS")) {
    $temp = exec("\"".$cfghtpasswdEXE."\" -nmb $username $password", $result, $retval);
    if ($retval == 0) {
        $data = explode(":", $result[0], 2);
        return $data[1];
    }
    else
        return "** ERROR **";
  }
  else {
    $salt = random();
    $salt = substr($salt, 0, 2);
    return crypt($password, $salt);
  }
}

function ht_auth() {
  global $cfgProgName, $cfgVersion, $cfgUseAuth;
  global $cfgSuperUser, $cfgSuperPass;
  global $_SERVER;

  if (!$cfgUseAuth)
    return;

  if (($_SERVER['PHP_AUTH_USER'] != $cfgSuperUser) || 
      ($_SERVER['PHP_AUTH_PW'] != $cfgSuperPass)) {
    header("WWW-Authenticate: Basic realm=\"$cfgProgName $cfgVersion\"");
    header("HTTP/1.0 401 Unauthorized");
    echo "<h1>$cfgProgName $cfgVersion</h1><h3>Authentication failed.</h3>\n".
	 "Click <a href=\"index.php\">here</a> to login again.\n";
    exit;
  }
}
?>
