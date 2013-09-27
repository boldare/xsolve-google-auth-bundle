# About

This bundle allows user to sign in via Google Auth 2.0 API to FOSUserBundle.

It includes:

* Google API integration
* Creating new user if it's necessary
* Signing in

# Installation

1) Install and configure FOSUserBundle

    https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md

2) Add to composer.json

    "require": {
        "xsolve-pl/xsolve-google-auth-bundle": "1.0.*"
    },

3) Install dependencies

    composer install

4) Run the bundle in app/AppKernel.php

    public function registerBundles()
    {
        return array(
            // ...
            new Xsolve\GoogleAuthBundle\XsolveGoogleAuthBundle(),
        );
    }

5) Add to routing.yml 

    xsolve_google_auth:
        resource: "@XsolveGoogleAuthBundle/Controller/"
            type:     annotation
                prefix:   /


6) Register your service in https://code.google.com/apis/console/b/0/ an configure parameters.yml and add

    xsolve_google_auth:
        name: Xsolve test application
        client_id: "4429041xxxx.apps.googleusercontent.com"
        client_secret: "xrAbfJ7wmOBZbYU3TyDxxxxx"
        redirect_uri: "http://testapp.xsolve.pl/oauth2callback"
        dev_key: xsolvetestapplication

        success_authorization_redirect_url: _welcome
        failure_authorization_redirect_url: _welcome

        autoregistration: false
        autoregistration_domains: []

7) Add access controls to security.yml

    access_control:
        - { path: ^/oauth2callback, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/googleauthlogin, role: IS_AUTHENTICATED_ANONYMOUSLY }


# Usage

After configuring a bundle you can go to /oauth2callback page and the browser should redirect to google access page.

## Configuration options

Configuration can be adjusted in app/config/config.yml

    xsolve_google_auth:
        name: Xsolve test application #name of application from google console
        client_id: "4429041xxxx.apps.googleusercontent.com" #client id of application from google console
        client_secret: "xrAbfJ7wmOBZbYU3TyDxxxxx" #client secret key of application from google console
        redirect_uri: "http://testapp.xsolve.pl/oauth2callback" #redirect uri of application from google console
        dev_key: xsolvetestapplication #your developmnent's application name from google console

        success_authorization_redirect_url: _welcome #url key inside Symfony where user should be redirected after successful sign in
        failure_authorization_redirect_url: _welcome #url key inside Symfony where user should be redirected after failure sign in

        autoregistration: false #true|false - if false than user will be registered into system automaticaly
        autoregistration_domains:  #array may be empty. If autoregistration is true you can allow to register users only from selected domains
           - xsolve.pl

