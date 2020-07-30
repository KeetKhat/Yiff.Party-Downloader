# notfap-script

## Description
Download private patreon files from yiff.party
It requires cURL for PHP

## Usage 

``php notfapdownloader.php -i [GIRL ID] -t [FILE TYPE] -d [DESTINATION FOLDER]``

Example #1 : 
We want to download Belle Delphine pictures (with the user id 7330723) in the folder called "Belle-Delphine" (it will be created) :

``php notfapdownloader.php -i 7330723 -t pictures -d Belle-Delphine``

Example #2 :
We want to download Belle Delphine pictures AND videos (with the user id 7330723) in the folder called "Belle-Delphine" (it will be created) :

``php notfapdownloader.php -i 7330723 -t all -d Belle-Delphine``