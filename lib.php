<?php
putenv("TZ=Europe/Stockholm");
function lg($msg) {
error_log(date("Y/m/d H:i:s") . ": " . $msg . "\n", 3, "errors.txt");
  }


function getBrowser(){
    static $browser;//No accident can arise from depending on an unset variable.
    if(!isset($browser)){
        $browser = getBrowserInfo();
    }
    return $browser;
}


function getBrowserInfo() {
    // Note: An excellent article on browser IDs can be found at
    // http://www.zytrax.com/tech/web/browser_ids.htm
  //  logg("söker");
    $SUPERCLASS_NAMES = "gecko,mozilla,mosaic,webkit";
    $SUPERCLASS_REGX  = "(?:".str_replace(",", ")|(?:", $SUPERCLASS_NAMES).")";

    $SUBCLASS_NAMES   = "opera,msie,firefox,chrome,safari";
    $SUBCLASS_REGX    = "(?:".str_replace(",", ")|(?:", $SUBCLASS_NAMES).")";

    $browser      = "unrecognized";
    $majorVersion = "0";
    $minorVersion = "0";
    $fullVersion  = "0.0";
    $platform     = 'unrecognized';

    $userAgent    = strtolower($_SERVER['HTTP_USER_AGENT']);

    $found = preg_match("/(?P<browser>".$SUBCLASS_REGX.")(?:\D*)
(?P<majorVersion>\d*)(?P<minorVersion>(?:\.\d*)*)/i",
$userAgent, $matches);
    if (!$found) {
        $found = preg_match("/(?P<browser>".$SUPERCLASS_REGX.")(?:\D*)
(?P<majorVersion>\d*)(?P<minorVersion>(?:\.\d*)*)/i",
$userAgent, $matches);
    }

    if ($found) {
        $browser      = $matches["browser"];
        $majorVersion = $matches["majorVersion"];
        $minorVersion = $matches["minorVersion"];
        $fullVersion  = $matches["majorVersion"].$matches["minorVersion"];
        if ($browser == "safari") {
            if (preg_match("/version\
/(?P<majorVersion>\d*)(?P<minorVersion>(?:\.\d*)*)/i",
$userAgent, $matches)){
                $majorVersion = $matches["majorVersion"];
                $minorVersion = $matches["minorVersion"];
                $fullVersion  = $majorVersion.".".$minorVersion;
            }
        }
    }

    if (strpos($userAgent, 'linux')) {
        $platform = 'linux';
    }
    else if (strpos($userAgent, 'macintosh') || strpos($userAgent, 'mac platform x')) {
        $platform = 'mac';
    }
    else if (strpos($userAgent, 'windows') || strpos($userAgent, 'win32')) {
        $platform = 'windows';
    }

    if (strcmp($browser,"unrecognized")==0)
      {
	//logg("hittar inget i " . $userAgent);
	//logg(strpos($userAgent,"firefox"));
	if (strpos($userAgent,"firefox")>0)
	  $browser = "firefox";
	elseif (strpos($userAgent,"msie")>0)
	  $browser = "ie";
	//else
	//logg("inget firefox där inte");
      }


    return array(
        "browser"      => $browser,
        "majorVersion" => $majorVersion,
        "minorVersion" => $minorVersion,
        "fullVersion"  => $fullVersion,
        "platform"     => $platform,
        "userAgent"    => $userAgent);
}

function logg($msg) {
  return "";
$browser = getBrowser();
 
$msg =  "[" . $browser["browser"] . "][" .  $_SERVER["REMOTE_ADDR"] . "]" . $msg;




  /*if (is_numeric(strpos(getenv('SERVER_NAME'),'ky')))
    {
       echo $msg;
      return;
    }
  */
  //date_default_timezone_set("Europe/Stockholm");
  putenv("TZ=Europe/Stockholm");
  
  $ERR_FILE = "lgLogClient.txt";//rapport.txt";
    if (!file_exists($ERR_FILE))
      {
	//skapa filjäveln
	//$file = "newfile.txt";    
	if (!$file_handle = fopen($ERR_FILE,"w")) 
	  {
	    
	    echo "Cannot open file"; 
	  }   
	else
	  fclose($file_handle);   


      }
     
    if (!is_writable($ERR_FILE)) {
           if (!chmod($ERR_FILE, 0777)) {
                 echo "Cannot change the mode of file ($ERR_FILE)";
                 exit;
           };
       }
  
  //global $ERR_FILE;
  //if (empty($ERR_FILE))// || $ERR_FILE=='')
  
  $errlines = explode("\n",$msg);
  foreach ($errlines as $txt) { error_log("\n" . date("D M j G:i:s T Y", time()) . ": " .  $txt,3,$ERR_FILE); } 
}

function getSessionGetPostDump() {
  
  $r = "Session:\n";
  foreach ($_SESSION as $key => $value)
    {
      $r .= $key . " = " . $value . "\n";
    }
  $r .= "Get:\n";
  foreach ($_GET as $key => $value)
    {
      $r .= $key . " = " . $value . "\n";
    }


  $r .= "Post:\n";
  foreach ($_POST as $key => $value)
    {
      $r .= $key . " = " . $value . "\n";
    }
  return $r;

  
}


?>