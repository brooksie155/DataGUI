<?php
/* Sample usage:
	php data-api-sample.php time
	php data-api-sample.php statistics/advertiser/campaign_group/37444 "from=2016-05-01&break=entity"
	php data-api-sample.php statistics/advertiser/banner/2579900 "from=2016-05-01&to=2016-05-01&break=date"
	php data-api-sample.php statistics/advertiser/banner/2579900 "from=2016-05-01&to=2016-05-01&break=geo"
	php data-api-sample.php inventory/advertiser
*/
$verbose=false;
$reporoGateway = 'http://api.reporo.com/analytics/data-api.php?';
$reporoApiKey = '5t1hQUxEot7OaUBjNWT1d5ZMP65AqfhF';
$reporoSecretKey = 'O92T4LH37YIDRac8dAmlb1uQsjz86GIs3UdGi2PhiB4C39D6z6ehA4b0NcxOcJtB';

$reporoReqEpoch = time();
$reporoReqHash = hash("sha256", $reporoReqEpoch . $reporoSecretKey);

if($verbose) {
    echo "x-reporo-epoch: $reporoReqEpoch\n";
    echo "x-reporo-key: $reporoApiKey\n";
    echo "x-reporo-mash: $reporoReqHash\n";
}

$action = "action=" . urlencode($argv[1]);
$method = "GET";
$qs = empty($argv[2]) ? '' : ('&' . $argv[2]);

$reporoRequestURL = $reporoGateway . $action . $qs;

if ($verbose) echo "GET: $reporoRequestURL\n";

$options = array(
    'http' => array(
        'method' => $method,
        'header' =>
        "accept: application/xml" . "\r\n" .
        "x-reporo-key: $reporoApiKey" . "\r\n" .
        "x-reporo-epoch: $reporoReqEpoch" . "\r\n" .
        "x-reporo-mash: $reporoReqHash" . "\r\n"
    )
);

print $reporoRequestURL;
var_dump($options);

$context = stream_context_create($options);
$reporoResponse = file_get_contents($reporoRequestURL, false, $context);

echo "$reporoResponse\n";
