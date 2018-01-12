<?php

function randomString($length) {$characters = 'QAZWSXEDCRFVTGBYHNUJMIKOLP!@~#$%^&*()_+-=|1234567890`;:abcdefghijklmnopqrstuvwxyz';$charactersLength = strlen($characters);$randomString = '';for ($i = 0; $i < $length; $i++) {$randomString .= $characters[rand(0, $charactersLength - 1)];}return $randomString;}  

function disable_gzip() {
	@ini_set('zlib.output_compression', 'Off');
	@ini_set('output_buffering', 'Off');
	@ini_set('output_handler', '');
	@apache_setenv('no-gzip', 1);	
}

// Might not work if Fastcgi is installed
disable_gzip();
session_start();
if (!$_SESSION['homepage']){$u="../speedtest/";header("Location: $u");die();}
$_SESSION['homepage']=false;
$loading=<<<HTML
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Speed Test - Yuxin Pan</title><meta http-equiv="refresh" content="150;URL=../speedtest/"><style>body{background-color:#dedede;font-size:12px}.base{height:9em;left:50%;margin:-7.5em;padding:3em;position:absolute;top:50%;width:9em;transform:rotateX(45deg) rotateZ(45deg);transform-style:preserve-3d}.cube,.cube:after,.cube:before{content:'';float:left;height:3em;position:absolute;width:3em}.cube{background-color:#05afd1;position:relative;transform:translateZ(3em);transform-style:preserve-3d;transition:.25s;box-shadow:13em 13em 1.5em rgba(0,0,0,0.1);animation:anim 1s infinite}.cube:after{background-color:#049dbc;transform:rotateX(-90deg) translateY(3em);transform-origin:100% 100%}.cube:before{background-color:#048ca7;transform:rotateY(90deg) translateX(3em);transform-origin:100% 0}.cube:nth-child(1){animation-delay:.05s}.cube:nth-child(2){animation-delay:.1s}.cube:nth-child(3){animation-delay:.15s}.cube:nth-child(4){animation-delay:.2s}.cube:nth-child(5){animation-delay:.25s}.cube:nth-child(6){animation-delay:.3s}.cube:nth-child(7){animation-delay:.35s}.cube:nth-child(8){animation-delay:.4s}.cube:nth-child(9){animation-delay:.45s}@keyframes anim{50%{transform:translateZ(0.5em)}}</style><script src="loading/js/prefixfree.min.js"></script></head><body><div style="text-align:center;clear:both;"></div><div class='base'><div class='cube'></div><div class='cube'></div><div class='cube'></div><div class='cube'></div><div class='cube'></div><div class='cube'></div><div class='cube'></div><div class='cube'></div><div class='cube'></div></div>   
HTML;

if (!isset($_SESSION['clientKey'])) $_SESSION['clientKey']=0;
if ((isset($_SESSION['clientKey']))&&(isset($_GET["pg"]))){if (($_SESSION['clientKey']!=0)&&($_GET["pg"]=="result")){
if (isset($_SESSION['timer'])){$text="";$_SESSION['clientKey']=0;
$n=1;$tmp="id".$n;//echo $_POST[$tmp]."@@";die();
while (isset($_POST[$tmp])){$text=$text.$_POST[$tmp];$n++;$tmp="id".$n;}
$time_end=explode(" ",microtime());$finish = $time_end[0]+$time_end[1];
$size=strlen($text)/1024;
$_SESSION['uploadSpeed']=round($size/($finish-$_SESSION['timer']),1);/*echo "<!DOCTYPE html><html><head><meta charset=\"UTF-8\"><title>Speed Test Result - Yuxin Pan</title><meta name=\"keywords\" content=\"Speed test,network connection check,Yuxin Pan,web application\" /><meta name=\"description\" content=\"Test your Internet connection speed, works for any device, provided by Yuxin Pan.\" /></head><body>Download Speed: ".$_SESSION['downloadSpeed']." kB/s<br><br>Upload Speed: ".$_SESSION['uploadSpeed']." kB/s</body></html>";*/
$_SESSION['clientKey']=0;
$u="../speedtest/";
header("Location: $u");die(); }}}

echo $loading;
$randNum1=rand(0,1024*1024*6);$randNum2=rand(1024*1024*8,1024*1024*14-1);
flush();

$preparationText='<div style="display:none;">'.randomString(128000).'</div> ';
$time = explode(" ",microtime());
echo $preparationText;
flush();
$time_end = explode(" ",microtime());
$size=strlen($preparationText)/1024;
$start = $time[0] + $time[1];
$finish = $time_end[0] + $time_end[1];
$deltat = $finish - $start;
$pSpeed=round($size / $deltat, 2);
//echo $preparationSpeed;die();
if (!isset($_SESSION['mobile']))$_SESSION['mobile']=1;
if (($pSpeed<200)||($_SESSION['mobile']==1)) $n=1;
elseif ($pSpeed<500) $n=1;
elseif ($pSpeed<1000) $n=2;
elseif ($pSpeed<2000) $n=3;
else $n=4;
$text='';
for ($i=1;$i<=$n;$i++){$text=$text.'<input type="text" name="id'.$i.'" value="'.randomString(500000).'" />';}
$text='<div style="display:none;">'.randomString($n*256000).'</div> '.'<div style="display:none;"><form id="speedtesting" method="POST" action="test.php?pg=result">'.$text.'</form><script>document.getElementById("speedtesting").submit();</script></div></body></html> ';
$time = explode(" ",microtime());
echo $text;
flush();
$time_end = explode(" ",microtime());
$size=strlen($text)/1024;
$start = $time[0] + $time[1];
$finish = $time_end[0] + $time_end[1];
$deltat = $finish - $start;
//echo $size."**".$deltat;die();
$_SESSION['downloadSpeed']=round($size / $deltat, 1);
$time = explode(" ",microtime());
$_SESSION['timer']=$time[0] + $time[1];;
$_SESSION['clientKey']++;
$_SESSION['homepage']=true;

//echo $deltat."**".$size."**".$_SESSION['downloadSpeed'];die();



?>