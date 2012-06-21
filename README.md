## REFERLY PHP API

This repository contains a helpful set of classes to connect to and interact with the http://refer.ly API. For full details on the API and available methods please check out http://refer.ly/api.

## Getting Started

To use the Referly class in your project, you need to include the lib/bootstrap.php file. Make sure to pass in the correct path to the lib folder, this will vary depending on where you place our API library within your project.

    require_once('lib/bootstrap.php');

Then setup an instance of the Referly class with your app api key and secret.

    $referly_client = Referly::instance('api_key', 'secret');

To create a new link for your account do the following:

    $account_id = 'your account id';
    $url = 'http://www.amazon.com/catdj/dp/B006YR6EK8/';
    $response = $referly_client->create_link($account_id, $url);
    if ($response['code'] == 200) { // 200 code means request was successful.
        print $response['data']->url; // Print the shortened url to the screen.
    }
    else {
        print $response['data']->error; // Print the error message for why the request failed.
    }

