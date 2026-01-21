<?php

return [
    'client_id' => env('SF_CLIENT_ID'),
    'client_secret' => env('SF_CLIENT_SECRET'),
    'username' => env('SF_USERNAME'),
    'password' => env('SF_PASSWORD'),
    'security_token' => env('SF_SECURITY_TOKEN'),
    'login_url' => env('SF_LOGIN_URL', 'https://login.salesforce.com'),
];
