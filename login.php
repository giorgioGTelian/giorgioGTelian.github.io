<?php


// Start a session to store the authentication token
session_start();

$users = array(
  'test1@demotest.it' => '123',
  'test2@demotest.it' => '456',
  'test3@demotest.it' => '789',
  'test4@demotest.it' => '135',
  'test5@demotest.it' => '246'
);

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the email and password from the request
  $email = $_POST['email'];
  $password = $_POST['password'];
  
 // Check if the email and password match an accepted user
  if (isset($users[$email]) && $users[$email] === $password) {
  // Initialize a cURL session
  $ch = curl_init();

  // Set the URL of the server's authentication API
  curl_setopt($ch, CURLOPT_URL, 'https://cloud.fatturapro.click/junior2023/login');

  // Set the HTTP method to POST
  curl_setopt($ch, CURLOPT_POST, true);
    
  // Set the email and password as POST data
  curl_setopt($ch, CURLOPT_POSTFIELDS, "email=$email&password=$password");

  // Set the response format to JSON
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

  // Set the data to be sent in the request
  curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'email' => $email,
    'password' => $password,
  ]);

  // Set the option to receive the response as a string
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
  // Set the option to verify the hostname
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    
      // Send the request and get the response
    $response = curl_exec($ch);

    // Close the cURL session
    curl_close($ch);

    // Decode the response
    $response = json_decode($response, true);

    // Check if the login was successful
    if ($response['status'] === 0) {
      // Save the token in the session
      $_SESSION['token'] = $response['token'];

      // Redirect the user to the home page
      header('Location: /home.php');
      exit;
    } 
 }
    

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
