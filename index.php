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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guild Members</title>
    <style>
        body {
            width: 100vw;
            font-family: Arial, sans-serif;
        }

        .rank-section {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
        }

        .rank-title {
            width: 100%;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .member-skin {
            width: 100%;
            height: auto;
        }

        .member {
            margin: 0 20px;
            width: 120px;
        }
    </style>
</head>

<body>
    <div class="guild-members">
        <?php
        $ranksCount = 0;

        foreach ($guildData['members'] as $title => $members):
            if ($ranksCount != 0): ?>
                <div class="rank-section">
                    <h2 class="rank-title"><?php echo htmlspecialchars($title); ?></h2>
                    <?php foreach ($members as $name => $memberData):
                        $skinApiUrl = 'https://mc-heads.net/body/' . $memberData['uuid'] . '/right'; ?>
                        <div class="member">
                            <h3><?php echo htmlspecialchars($name); ?></h3>
                            <img class="member-skin" src="<?php echo htmlspecialchars($skinApiUrl); ?>" alt="Skin of <?php echo htmlspecialchars($memberData['uuid']); ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
        <?php endif;
            $ranksCount++;
        endforeach; ?>
    </div>
</body>

</html>
