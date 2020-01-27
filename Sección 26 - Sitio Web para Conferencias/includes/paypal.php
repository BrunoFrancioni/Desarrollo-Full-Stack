<?php
    require 'PayPal/autoload.php';

    define('URL_SITIO', 'http://localhost:80/gdlwebcamp');

    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AWHzH3HMYgbPD5ivF6ezAo4PF2rePfY3MgbSoQB07tMv6-XBhJW37IqKmYk8iL1voOgnmHKFLVCsl39W', // ClienteID
            'EJKmxPuZsvRQnmeBkuf09kdtkA_b9svV41ClVvhiI4A8xGs3xPEGt7XDKdX4t2vN6HmhmItINpCpy52v' // Secret
        )
        );
?>
