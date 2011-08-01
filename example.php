<?php
require 'CakeAPI.class.php';

try {
    $CakeAPI = new CakeAPI('YourApiKey');
    
    /*  Pass the params to the API as a string with the /Class/Method you want and an array with the parameters.
        In case you need to parse an array that one of the params is another array, do so like you would do normally: 
        
        array(
            'param1' => 'some value', 
            'param2' => array(
                'first_name' => 'Your Name',
                'last_name' => 'Last Name'
            )
        );
    */
    var_dump($CakeAPI->call('/User/login', array('email' => 'some@email.com', 'password' => 'abcd1234')));
    
} catch (Exception $e) {
    echo $e->getMessage();
}
