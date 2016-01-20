# wp-nonce-wrapper
Use WordPress Nonce an object oriented way 

[![Build Status](https://travis-ci.org/PatelUtkarsh/wp-nonce-wrapper.svg?branch=master)](https://travis-ci.org/PatelUtkarsh/wp-nonce-wrapper)

##Installation:

```
"spock/wp-nonce-wrapper": "0.5"
```

to your composer.json file and run a `composer update`

Or 
```
composer require spock/wp-nonce-wrapper
```

##Usage:

Get Nonce:
```php
$instance = Wp_Nonce_Wrapper::getInstance();
$nonce = $instance->create_nonce( "doing_some_form_job" );
```

Verify Nonce:

```php
$nonce = $_REQUEST['nonce'];
$instance = Wp_Nonce_Wrapper::getInstance();
if ($instance->verify_nonce( $nonce, "doing_some_form_job" ))
    //Verified Source 
else 
    // Unknown Source
```