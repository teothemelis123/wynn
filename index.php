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
echo '<div style="display:flex;width:100vw;">';
foreach ($guildData['members']['chief'] as $chief) {
    $skinApiUrl = 'https://mc-heads.net/body/'.$chief['uuid'].'/right';
    
    
    echo '<img src="' . htmlspecialchars($skinApiUrl) . '" alt="Skin of ' . htmlspecialchars($chief['uuid']) . '">';
    
}
echo '</div>';
echo '</body></html>';
?>
