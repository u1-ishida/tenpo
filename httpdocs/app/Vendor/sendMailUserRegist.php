<?php

// ファイルを書き込み専用でオープンします。
$fno = fopen("/var/www/vhosts/nagase-personalcare.com/httpdocs/app/tmp/test.txt", 'w');

// 文字列を書き出します。
fwrite($fno, "書き出す文字列！");

// ファイルをクローズします。
fclose($fno);
//mail( "yuichi-ishida@netyear.net", "件名", "内容", "yuichi-ishida@netyear.net" );


 ?>