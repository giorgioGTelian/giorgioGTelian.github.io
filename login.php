<?php


// Start a session to store the authentication token
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the email and password from the request
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Initialize a cURL session
  $ch = curl_init();

  // Set the URL of the server's authentication API
  curl_setopt($ch, CURLOPT_URL, 'https://cloud.fatturapro.click/junior2023/login');

  // Set the HTTP method to POST
  curl_setopt($ch, CURLOPT_POST, true);

  // Set the data to be sent in the request
  curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'email' => $email,
    'password' => $password,
  ]);

  // Set the option to receive the response as a string
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  // Send the request and get the response
  $response = curl_exec($ch);

  // Close the cURL session
  curl_close($ch);

  // Check if the request was successful
  if ($response !== false) {
    // The request was successful, so parse the response
    $data = json_decode($response, true);
    if (isset($data['token'])) {
      // The authentication was successful, so save the token in a session
      $_SESSION['token'] = $data['token'];
    } else {
      // The authentication failed, so show an error message
      echo '<p>Incorrect email or password</p>';
    }
  } else {
    // The request failed, so show an error message
    echo '<p>Error connecting to the server</p>';
  }
}

//This will ensure that cURL is connecting to the intended website and not being redirected to a malicious site.

// Initialize a cURL session
$ch = curl_init();

// Set the URL of the server
curl_setopt($ch, CURLOPT_URL, 'https://cloud.fatturapro.click/junior2023/login');

// Set the option to verify the hostname
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

/* Set other options as needed (HTTP method, data to send) */

// Send the request and get the response
$response = curl_exec($ch);

// Close the cURL session
curl_close($ch);


?>
