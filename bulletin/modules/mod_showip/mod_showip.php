<?php
/**
* @version		$Id: mod_showip.php 2011-03-24 17:00 $
* @package		Joomla
* @copyright	Copyright (C) 2007 - 2011 Maik Heinelt. All rights reserved.
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__).DS.'browser.php');

$showOSlogo = $params->get('showOSlogo', 0);

if (!$showOSlogo ==0)
	{
	$OSList = array
		(
			'<img src="modules/mod_showip/images/os/win311.gif" /> <font size=+1>Windows 3.11</font>' => 'Win16',
			'<img src="modules/mod_showip/images/os/win95.gif" /> <font size=+1>Windows 95</font>' => '(Windows 95)|(Win95)|(Windows_95)',
			'<img src="modules/mod_showip/images/os/winme.gif" /> <font size=+1>Windows-ME</font>' => '(Windows 98)|(Win 9x 4.90)',
			'<img src="modules/mod_showip/images/os/win98.gif" /> <font size=+1>Windows-98</font>' => '(Windows 98)|(Win98)',
			'<img src="modules/mod_showip/images/os/win2000.gif" /> <font size=+1>Windows 2000</font>' => '(Windows NT 5.0)|(Windows 2000)',
			'<img src="modules/mod_showip/images/os/winxp.gif" /> <font size=+1>Windows XP</font>' => '(Windows NT 5.1)|(Windows XP)',
			'<img src="modules/mod_showip/images/os/win2k3s.gif" /> <font size=+1>Windows Server 2003</font>' => '(Windows NT 5.2)',
			'<img src="modules/mod_showip/images/os/winvista.gif" /> <font size=+1>Windows Vista</font>' => '(Windows NT 6.0)',
			'<img src="modules/mod_showip/images/os/win7.gif" /> <font size=+1>Windows 7</font>' => '(Windows NT 6.1)',
			'<img src="modules/mod_showip/images/os/winnt.gif" /> <font size=+1>Windows NT 4.0</font>' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
			'<img src="modules/mod_showip/images/os/winme.gif" /> <font size=+1>Windows ME' => 'Windows ME',
			'<img src="modules/mod_showip/images/os/openbsd.gif" /> <font size=+1>Open BSD</font>' => 'OpenBSD',
			'<img src="modules/mod_showip/images/os/freebsd.gif" /> <font size=+1>Free BSD</font>' => 'FreeBSD',
			'<img src="modules/mod_showip/images/os/sunos.gif" /> <font size=+1>Sun OS</font>' => 'SunOS',
			'<img src="modules/mod_showip/images/os/linux.gif" /> <font size=+1>Linux</font>' => '(Linux)|(X11)',
			'<img src="modules/mod_showip/images/os/macosx.gif" /> <font size=+1>Mac OS</font>' => '(Mac_PowerPC)|(Macintosh)',
			'<img src="modules/mod_showip/images/os/qnx.png" /> <font size=+1>QNX</font>' => 'QNX',
			'<img src="modules/mod_showip/images/os/beos.gif" /> <font size=+1>BeOS</font>' => 'BeOS',
			'<img src="modules/mod_showip/images/os/os2.gif" /> <font size=+1>OS/2</font>' => 'OS/2',
			'Search Bot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves/Teoma)|(ia_archiver)'
		);
	}
else
	{
		$OSList = array
		(
			'<font size=+1>Windows 3.11</font>' => 'Win16',
			'<font size=+1>Windows 95</font>' => '(Windows 95)|(Win95)|(Windows_95)',
			'<font size=+1>Windows-ME</font>' => '(Windows 98)|(Win 9x 4.90)',
			'<font size=+1>Windows-98</font>' => '(Windows 98)|(Win98)',
			'<font size=+1>Windows 2000</font>' => '(Windows NT 5.0)|(Windows 2000)',
			'<font size=+1>Windows XP</font>' => '(Windows NT 5.1)|(Windows XP)',
			'<font size=+1>Windows Server 2003</font>' => '(Windows NT 5.2)',
			'<font size=+1>Windows Vista</font>' => '(Windows NT 6.0)',
			'<font size=+1>Windows 7</font>' => '(Windows NT 6.1)',
			'<font size=+1>Windows NT 4.0</font>' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
			'<font size=+1>Windows ME' => 'Windows ME',
			'<font size=+1>Open BSD</font>' => 'OpenBSD',
			'<font size=+1>Free BSD</font>' => 'FreeBSD',
			'<font size=+1>Sun OS</font>' => 'SunOS',
			'<font size=+1>Linux</font>' => '(Linux)|(X11)',
			'<font size=+1>Mac OS</font>' => '(Mac_PowerPC)|(Macintosh)',
			'<font size=+1>QNX</font>' => 'QNX',
			'<font size=+1>BeOS</font>' => 'BeOS',
			'<font size=+1>OS/2</font>' => 'OS/2',
			'Search Bot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves/Teoma)|(ia_archiver)'
		);	
	}
foreach($OSList as $CurrOS=>$Match)
{
	if (eregi($Match, $_SERVER['HTTP_USER_AGENT']))
	{
		break;
	}
}

// Get the label settings
$ipLabel = $params->get('ipLabel', "Your IP");
$MapLinkLabel = $params->get('MapLinkLabel', "Show location on Map");
$hostnameLabel = $params->get('hostnameLabel', "Hostname");
$osLabel = $params->get('osLabel', "Your OS");
$browserLabel = $params->get('browserLabel', "Your Browser");
$locationLabel = $params->get('locationLabel', "Location");
$ShorResLabel = $params->get('ShorResLabel', "Screen Resolution");

//Get the enabled/disabled settings
$showMaplink = $params->get('showMaplink', 0);
$showHostname = $params->get('showHostname', 0);
$showBrowser = $params->get('showBrowser', 0);
$showBrowserlogo = $params->get('showBrowserlogo', 0);
$showOS = $params->get('showOS', 0);
$showCountry = $params->get('showCountry', 0);
$ShowRes = $params->get('ShowRes', 0);
$ShowJS = $params->get('ShowJS', 0);
$showFlag = $params->get('showFlag', 0);
$MapLinkType = $params->get('Maplinktype', 1);
$MapZoomLevel = $params->get('MapZoomLevel', 11);
$UnknownLocLBL = $params->get('UnknownLocLBL', "Unknown Location");

$IP = $_SERVER['REMOTE_ADDR'];
$REMOTEHOST = gethostbyaddr($IP);

$browser = new Browser();
$browser_name = $browser->getBrowser();
$browser_ver = $browser->getVersion();

if (!$showMaplink == 0 || !$showCountry == 0 || !$showFlag == 0)	//	<< 2011-01-25 Prevent using external service at all. 
	{
		$IPDetail=countryCityFromIP($IP);
		$country = $IPDetail['country'];
		
		
		if (isset($IPDetail['country_code']))
			{
				$country_code = $IPDetail['country_code'];
			}
		else
			{
				$country_code = "jp";
			}
			
		if (isset($IPDetail['coordinates']))
			{
				$coordinates = $IPDetail['coordinates'];
				list($lng, $lat) = split(",", $coordinates, 2);
			}
		
	}






echo '<!-- Show IP v1.3 START http://www.heinelt.info -->
<font size=-1 >'.trim($ipLabel).': </font><b>'.$IP.'</b><br />';

//echo $coordinates;
if (!$showMaplink == 0)
	{
	if (isset($coordinates))
		{
			switch ($MapLinkType) 
				{
			    case 0:
			        echo '<a href="http://maps.google.com/maps?q='.$lat.',+'.$lng.'&hl=en&ie=UTF8&t=h&z='.$MapZoomLevel.'
			        &iwloc=A" target="_blank" ><font size="-4" >'.trim($MapLinkLabel).'</font></a><br />';
			        break;
			        
			    case 1:
			        echo '<a href="http://www.openstreetmap.org/?lat='.$lat.'&lon='.$lng.'&zoom='.$MapZoomLevel.'
			        &layers=B000FTFTT&mlat='.$lat.'&lon='.$lng.'" target="_blank" ><font size="-4" >'.trim($MapLinkLabel).'</font></a><br />';
			        break;
			        
			    case 2:
			        echo '<a href="http://www.bing.com/maps/?v=2&cp='.$lat.'~'.$lng.'&lvl='.$MapZoomLevel.'
			        &dir=0&sty=r&trfc=1" target="_blank" ><font size="-4" >'.trim($MapLinkLabel).'</font></a><br />';
			        break;
			    case 3;
			    	echo'<a href="http://maps.yahoo.com/#mvt=m&lat='.$lat.'&lon='.$lng.'&zoom='.$MapZoomLevel.'
			    	target="_blank" ><font size="-4" >'.trim($MapLinkLabel).'</font></a><br />';
			    	break;
				}
			
			
		}
	else
		{
			echo '<a href="http://www.hostip.info/correct.php?spip='.$IP.'&fd=correctFinished.html" target="_blank" ><font size="-4" >
			'.trim($UnknownLocLBL).'</font></a><br />';
		}
	}


// Show user hostname, if enabled.
if (!$showHostname == 0)
	{
		echo '
<font size=-1 >'.trim($hostnameLabel).':</font><br /><b>'.$REMOTEHOST.'</b><br />';
	}

echo '<br />';


// Show used Operating System, if enabled.
if (!$showOS == 0)
	{
		echo '
<font size=-1 >'.trim($osLabel).': </font> '.$CurrOS.'<br />';
	}


// Show used browser and it's version, if enabled
if (!$showBrowser == 0)
	{
		if (!$showBrowserlogo == 0)
			{
				$logostring = "
<img src=\"modules/mod_showip/images/browser/".strtolower($browser_name).".gif\" /> ";
			}
		else
			{
				$logostring = "";
			}
			
		echo trim($browserLabel).": ".$logostring.$browser_name." ".substr($browser_ver, 0, 6)."<br />";
	}

// Show location and country flag.
if (!$showCountry == 0)
	{
		if (!$showFlag == 0)
			{
				$country = "
<img src=\"modules/mod_showip/images/flags/".strtolower($country_code).".gif\" /> ".$country;
			}
		if (isset($city))
			{
				$country = $country.", ".$city;
			}
		
		echo trim($locationLabel).": ".$country."<br />"; //country of that IP address
	}
if (!$ShowRes == 0)
	{
	echo'
	<script type="text/javascript">
	document.write(\''.trim($ShorResLabel).': \'+screen.width+\'x\'+screen.height+\'<br />\');
	</script>
	<noscript>
	'.trim($ShorResLabel).': JScript disabled!
	</noscript> 
	';
	}
	
if (!$ShowJS == 0)
	{
	echo'
	<script type="text/javascript">
	document.write(\'Javascript: Enabled<br />\');
	</script>
	<noscript>
	Javascript: Disabled!<br />
	</noscript>';
	}
	
echo '<!-- Show IP v1.3 END http://www.heinelt.info -->';