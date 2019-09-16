<?php

$url = "https://yiff.party";
$regex = "/<a\shref=\"(.+)\"\s.+Post file<\/a>/";

$opts = getopt("i:d:h::");

if(isset($opts["i"]) && isset($opts["d"])){
    $girl_id = $opts["i"];
    $girl_dir = $opts["d"];
} elseif(isset($opts["h"])) {
    print("i : girl id on yiff.party\nd : directory name");
    exit;  
} else {
    print("Error missing 'i' and 'd' parameters\nExample : file.php -i 123 -d Sexy");
    exit;
}


$curl = curl_init("$url/patreon/$girl_id");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$retour = curl_exec($curl);
curl_close($curl);

if (!mkdir("$girl_dir/", 0775, true)) {
    die('Error unable to create specified dir.');
}
preg_match_all($regex, $retour, $images, PREG_SET_ORDER, 0);

$nombre_boucle = count ($images);

echo "[" . date("H:i:s") . "] Downloading $nombre_boucle pictures...\n";
for ($i = 0; $i < $nombre_boucle; $i++)
{
    $save = "{$url}{$images[$i][1]}";
    echo "[" . date("H:i:s") . "] Downloading picture n°$i\n";
    file_put_contents("$girl_dir/$i.png", file_get_contents($save));
}
