<?php 
$wynnGuildUrl = 'https://api.wynncraft.com/v3/guild/Light%20Within';

$ch = curl_init($wynnGuildUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    die('cURL error: ' . curl_error($ch));
}

curl_close($ch);

$guildData = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON response.');
}

echo '<html><body style="width:100vw;">';
echo '<div style="width:100vw;">';
$ranksCount = 0;
foreach ($guildData['members'] as $title => $members) {
    if ($ranksCount != 0) {
        echo '<div><h2>'.$title.'</h2>';
        foreach ($members as $memberData) {
        $skinApiUrl = 'https://mc-heads.net/body/'.$memberData['uuid'].'/right';
        echo '<img style="width:70px;height:auto;" src="' . htmlspecialchars($skinApiUrl) . '">';

        }
        echo '</div><br><br>';
    }
   
    
    
    $ranksCount++;
}
echo '</div>';
echo '</body></html>';
?>
