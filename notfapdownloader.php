<?php

$url = "https://yiff.party";
$regex = "/<a\shref=\"(.+)\"\s.+Post file<\/a>/";

$opts = getopt("i:t:d:h::");

if(isset($opts["i"]) && isset($opts["t"]) && isset($opts["d"])){
    $creator_id = $opts["i"];
    $file_type = $opts["t"];
    $creator_dir = $opts["d"];
} elseif(isset($opts["h"])) {
    print("NotFapDownloader\nHelps you download all the media posted by a creator on Yiff.party\nRequired options:\n-i : creator id on yiff.party\n-t : file type (all,pictures,videos)\n-d : destination folder");
    exit;  
} else {
    print("Error: missing 'i'[Creator ID], 't'[File type] and/or 'd'[Destination Folder] parameters\nCorrect command example: php notfapdownloader.php -i 123 -t pictures -d FolderName");
    exit;
}


$curl = curl_init("$url/patreon/$creator_id");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$web_page = curl_exec($curl);
curl_close($curl);


if (!file_exists("$creator_dir") && !mkdir("$creator_dir/", 0775, true)) {
    die('Error unable to create specified dir.');
}

if ($file_type == 'all') {
    $regex = "/<a\shref=\"(.+?)\"\s.+?(.png|.jpg|.JPG|.jpeg|.MOV|.mov|.mp4)<\/a>/";
} elseif ($file_type == "pictures") {
    $regex = "/<a\shref=\"(.+?)\"\s.+?(.png|.jpg|.JPG|.jpeg)<\/a>/";

} elseif ($file_type == "videos") {
    $regex = "/<a\shref=\"(.+?)\"\s.+?(.MOV|.mov|.mp4)<\/a>/";
} else {
    die('Error: invalid -t parameter (choose one between all,pictures,videos)');
}


preg_match_all($regex, $web_page, $images, PREG_SET_ORDER, 0);

$total_files = count ($images);

echo "[" . date("H:i:s") . "] Download started..\n";
echo "[" . date("H:i:s") . "] Downloading $total_files files($file_type)...\n";
for ($i = 0; $i < $total_files; $i++)
{
    $save = "{$images[$i][1]}";
    $extension = "{$images[$i][2]}";

    echo "[" . date("H:i:s") . "] Downloading file($extension) n°".($i+1)."/$total_files\n";
    file_put_contents("$creator_dir/$i$extension", file_get_contents($save));
}
echo "[" . date("H:i:s") . "] ..Download completed!\n";
