<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
spl_autoload_register(function ($classname) {
    require_once "getss/" . $classname . '.php';
});


$is_SSR = isset($_GET['dingyue']) || isset($_GET['subscribe']);
$update = isset($_GET['update']);
$is_filter = isset($_GET['filter']);
$port = isset($_GET['port']) ? $_GET['port'] : "";
$is_ping = isset($_GET['ping']);
$util = Util::getUtil();
$links = $util->getSSLink();
$text = "";
$filter_array = array();
$nodes = array();
$is_ping = true;
foreach ($links as $link) {
    $node = $util->generateSSNode($link, $is_SSR);

    if ($is_filter) {
        $ip = $node->getServerIP();

        if (in_array($ip, $filter_array)) {
            continue;
        }
        array_push($filter_array, $ip);
        if ($port != "") {
            $node->setServerPort($port);
        }
    }
    if ($is_ping) {
        $node->name = $node->getRemark() . "<->".$node->getServerIP();
        $node->url = "http://" . $node->getServerIP() . "/";
        $node->download = $node->generateLink();
        array_push($nodes, $node);
        continue;
    }
    if ($is_SSR) {
        $text .= $node->generateLink() . "\n";

    } else {
        echo $node->generateLink() . "</br>\n";
    }

}

if ($is_ping) {
    header('Content-Type: text/javascript; charset=utf-8');
    echo "data={Free:" . json_encode($nodes, JSON_UNESCAPED_UNICODE) . "};";
    return;
}

if ($is_SSR) {
    echo base64_encode($text);
    return;
}

