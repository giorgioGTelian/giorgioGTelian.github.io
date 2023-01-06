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
  // TODO prevent (XSS) attacks.use htmlspecialchars or htmlentities 
  $email = $_POST['email']; 
  $password = $_POST['password'];
 } 
 // Check if the email and password match an accepted user
  if (array_key_exists($email, $users) && password_verify($password, $users[$email])) {
     // Initialize a cURL session
  $ch = curl_init();

  // Set the URL of the server's authentication API
  curl_setopt($ch, CURLOPT_URL, 'https://cloud.fatturapro.click/junior2023/login');

  // Set the HTTP method to POST
  curl_setopt($ch, CURLOPT_POST, 1);
    
  // Set the email and password as POST data
  curl_setopt($ch, CURLOPT_POSTFIELDS, "email=$email&password=$password");

  // Set the response format to JSON
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

  // Set the data to be sent in the request
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
  'email' => $email,
  'password' => $password,
]));

  // Set the option to receive the response as a string
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
  // Set the option to verify the hostname
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    
    // Decode the response
    $response = json_decode($response, true);

//This will ensure that cURL is connecting to the intended website and not being redirected to a malicious site.


    // Set the URL of the server
    curl_setopt($ch, CURLOPT_URL, 'https://cloud.fatturapro.click/junior2023/login');

    // Set the option to verify the hostname
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

/* Set other options as needed (HTTP method, data to send) */

    // Send the request and get the response
    $response = curl_exec($ch);

    // Close the cURL session
    curl_close($ch);

    } else {
    echo'<p>Email or password are invalid</p>'; 
  
}
 
 
    // Check if the login was successful
    if ($response['status'] === 0) {
      // Save the token in the session
      $_SESSION['token'] = $response['token'];

      // Redirect the user to the home page
      header('Location: /index.html');
      exit;
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
?>
