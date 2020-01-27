<?php
    require 'PayPal/autoload.php';

    define('URL_SITIO', 'http://localhost:80/paypal');

    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AV9DGg3ADOm-yw--_92PSojqG9lD0ybPfJES0wwdpoUTBIkoazHs9g5Lc6I7R9xv1mGVoOLAhSmRvoOK', // ClienteID
            'EHhbk-EojYpPxilNN41I4gDo_OI2pvyVPJM5gxxSCY5QO9wnZphywgHuFE_e2LvF822slJg4pmPGuxDd' // Secret
        )
        );
?>