<?php
/** @noinspection PhpUnhandledExceptionInspection */
require_once('vendor/autoload.php');

use Stripe\StripeClient;

if (2 !== $argc) {
    fwrite(STDERR, "usage: php create.php <stripe-private-key>\n");
    exit(1);
}

$stripe_secret_key = $argv[1];
if ( 'sk_test_' !== substr( $stripe_secret_key, 0, 8) ) {
    fwrite(STDERR, "Invalid test secret key, it should begin with 'sk_test_'\n");
    exit(1);
}

$client = new StripeClient($stripe_secret_key);

$book = $client->products->create(array(
    'name' => 'A Study in Scarlet',
    'images' => array(
        'https://upload.wikimedia.org/wikipedia/commons/2/2c/ArthurConanDoyle_AStudyInScarlet_annual.jpg'
    )
));

$client->prices->create(array(
    'product' => $book['id'],
    'unit_amount' => 100,
    'currency' => 'USD',
));

$gold = $client->products->create(array(
    'name' => 'Gold level membership',
    'images' => array(
        'https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/Buffalo_%2450_Reverse.png/440px-Buffalo_%2450_Reverse.png'
    )
));

$client->prices->create(array(
    'product' => $gold['id'],
    'unit_amount' => 300,
    'currency' => 'USD',
    'recurring' => ['interval' => 'day'],
));

$silver = $client->products->create(array(
    'name' => 'Silver level membership',
    'images' => array(
        'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/%241_Silver_Eagle_Type_2_Reverse.png/440px-%241_Silver_Eagle_Type_2_Reverse.png'
    )
));

$client->prices->create(array(
    'product' => $silver['id'],
    'unit_amount' => 200,
    'currency' => 'USD',
    'recurring' => ['interval' => 'day'],
));

