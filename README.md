# wp-nonce-wrapper
Use WordPress Nonce an object oriented way 

[![Build Status](https://travis-ci.org/PatelUtkarsh/wp-nonce-wrapper.svg?branch=master)](https://travis-ci.org/PatelUtkarsh/wp-nonce-wrapper)

##Installation:

```
"spock/wp-nonce-wrapper": "0.2"
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

Create nonce input field:

```php
//This will echo input field
create_nonce_field( 'clean_field');
```

Create nonce url 
```php
$url   = $this->instance->create_nonce_url( "http://w.org", 'clean_url' );
```

Check user is coming from another admin page.
 
 ```php
 // This will check current url 
 if ($this->instance->check_admin_referral( 'clean_url' ))
    //doing it right
 else 
    //doing it wrong
 ```
 
 
##Changelog 

### 0.2 ###
* Nonce field support 
* Nonce url support
* Check user is coming from admin referral

### 0.1 ###
* Initial basic functionality