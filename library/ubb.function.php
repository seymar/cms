<?php
 
function ubb($a) {
    $a=str_replace("[hr]","<hr size=\"1\" noshade>",$a);
    $a=preg_replace("/\[b\](.*?)\[\/b\]/si","<b>\\1</b>",$a);
    $a=preg_replace("/\[i\](.*?)\[\/i\]/si","<i>\\1</i>",$a);
    $a=preg_replace("/\[u\](.*?)\[\/u\]/si","<u>\\1</u>",$a);
    $a=preg_replace("/\[h1\](.*?)\[\/h1\]/si","<h1>\\1</h1>",$a);
    $a=preg_replace("/\[h2\](.*?)\[\/h2\]/si","<h2>\\1</h2>",$a);
    $a=preg_replace("/\[h3\](.*?)\[\/h3\]/si","<h3>\\1</h3>",$a);
    $a=preg_replace("/\[h4\](.*?)\[\/h4\]/si","<h4>\\1</h4>",$a);
    $a=preg_replace("/\[h5\](.*?)\[\/h5\]/si","<h5>\\1</h5>",$a);
    $a=preg_replace("/\[h6\](.*?)\[\/h6\]/si","<h6>\\1</h6>",$a);
    $a=preg_replace("/\[p\](.*?)\[\/p\]/si","<p>\\1</p>",$a);
    $a=preg_replace("/\[light\](.*?)\[\/light\]/si","<span class=\"light\">\\1</span>",$a);
    $a=preg_replace("/\[center\](.*?)\[\/center\]/si","<center>\\1</center>",$a);
    $a=preg_replace("/\[quote\](.*?)\[\/quote\]/si","<blockquote>\\1</blockquote>",$a);
    $a=preg_replace("/\[img=(.*?)\]/si","<img src=\"\\1\">",$a);
    $a=preg_replace("/\[img\](.*?)\[\/img\]/si","<img src=\"\\1\" />",$a);
    $a=preg_replace("/\[img h=([0-9]*) w=([0-9]*)\](.*?)\[\/img\]/si","<img src=\"\\3\" height=\"\\1\" width=\"\\2\" />",$a);
    $a=preg_replace("/\[url=(.*?)\](.*?)\[\/url\]/si","<a href=\"\\1\" target=\"_blank\">\\2</a>",$a);
    
    return $a;
}