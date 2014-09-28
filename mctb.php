<?



$string = "<?php";

$string .= "\n\n";
$string .= '	$secret_key = \'\';'."\n";
$string .= '	$project_id = \'\';'."\n";
$string .= '	$host = \'localhost\';'."\n";
$string .= '	$bd_user = \'Имя_пользователя\';'."\n";
$string .= '	$bd_name = \'Название_базы\';'."\n";
$string .= '	$user_pass = \'Пароль_пользователя\';'."\n";
$string .= '	$iconomy_table = \'iconomy\';'."\n\n";
$string .= '	if(isset($_GET[\'server_id\']) && isset($_GET[\'nickname\']) && isset($_GET[\'token\']))	';
$string .= "\n	{\n\n";
$string .= '	    $server = $_GET[\'server_id\'];'."\n\n";
$string .= '	    $nickname = $_GET[\'nickname\'];'."\n\n";
$string .= '	    $token = $_GET[\'token\'];'."\n\n";
$string .= '	    if($token == md5($secret_key))'."\n";
$string .= "        {\n";
$string .= '            $con = mysqli_connect($host, $bd_user, $user_pass, $bd_name);';
$string .= "\n\n";
$string .= '            if (mysqli_connect_errno()) {';
$string .= "\n";
$string .= '              echo "Failed to connect to MySQL: " . mysqli_connect_error();';
$string .= "\n            }\n\n";
$string .= '            mysqli_query($con, "UPDATE {$iconomy_table} SET money = money+100 WHERE player =\'{$nickname}\'");';
$string .= "\n\n";
$string .= '            mysqli_close($con);';
$string .= "\n";
$string .= '        }';
$string .= "\n\n";
$string .= '    }';
$string .= "\n\n";
$string .= '?>';

if(isset($_SERVER['HTTP_USER_AGENT']) and strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))

    Header('Content-Type: application/force-download');

else

    Header('Content-Type: application/octet-stream');



Header('Accept-Ranges: bytes');

Header('Content-Length: '.strlen($string));

Header('Content-disposition: attachment; filename="mctb.php"');



echo $string;



exit();



?>