<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * Sample application that authenticates and makes an API request.
 *
 * @author Dean Lukies <api.dean.lukies@gmail.com>
 */

/*
 * Provide path to src directory of google-api-php-client.
 *
 * For example:"google-api-php-client/src/"
 */
require_once "../account.inc.php";

session_start();

$client = new Google_Client();
$client->setApplicationName('Ad Exchange Buyer REST First API Request');

if (isset($_SESSION['service_token'])) {
  $client->setAccessToken($_SESSION['service_token']);
}
// Use the P12 to create credentials
$key = file_get_contents($key_file_location);
$cred = new Google_Auth_AssertionCredentials(
    $service_account_name,
    array('https://www.googleapis.com/auth/adexchange.buyer'),
    $key
);

// add the credentials to the client
$client->setAssertionCredentials($cred);
if($client->getAuth()->isAccessTokenExpired()) {
  $client->getAuth()->refreshTokenWithAssertion($cred);
}

$_SESSION['service_token'] = $client->getAccessToken();

// Use the authorized client to create a client for the API service
$service = new Google_Service_AdExchangeBuyer($client);

if ($client->getAccessToken()) {
    // Call the Accounts resource on the service to retrieve a list of
    // Accounts for the service account.
    $result = $service->accounts->listAccounts();

    print '<h2>Listing of user associated accounts</h2>';
    if (!isset($result['items']) || !count($result['items'])) {
      print '<p>No accounts found</p>';
      return;
    } else {
      foreach ($result['items'] as $account) {
        printf('<pre>');
        print_r($account);
        printf('</pre>');
      }
    }
}
