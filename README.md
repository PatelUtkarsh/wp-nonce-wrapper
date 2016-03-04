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
$nonce_obj = new Nonce_Wrapper('doing_some_form_job');
$nonce = $nonce_obj->create_nonce();
```

Verify Nonce:

```php
$nonce = $_REQUEST['nonce'];
$nonce_obj = new Nonce_Wrapper('doing_some_form_job');
if ( $nonce_obj->verify_nonce( $nonce ) )
    //Verified Source 
else 
    // Unknown Source
```

Create nonce input field:

```php
//This will echo input field
$nonce_obj->create_nonce_field();
```

Create nonce url 
```php
$url   = $nonce_obj->create_nonce_url( 'http://w.org' );
```

Check user is coming from another admin page.
 
 ```php
 // This will check current url 
 if ($nonce_obj->check_admin_referral())
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