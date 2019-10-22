
# Web Coding Challenge Backend  
  
This repository represent the API behind my attempt to pass the UR web coding challenge.  
  
## About   
This small REST api is a  [symfony](https://symfony.com/4) based application .  
The API's main tasks :   
- As a User, I can sign up using my email & password  
- As a User, I can sign in using my email & password  
- As a User, I can display the list of shops sorted by distance  
- As a User, I can like a shop, so it can be added to my preferred shops  

## Instructions  
  #### Requirements:

 - php >= 7.1
 - mysql .
 - Apache
 - openssl (to generate a key related to JWT).
 - composer
#### Config :

    .env File is your friend.

After you've set the environnement you need to follow these steps :  
  
 - `composer install`  
 - `chmod a+x scripts/start.sh`  
 - `scripts/start.sh`   
  
## Endpoints  
| URL |  Method| Parameters |  Behavior|  
|:--:|:--:|:--:|:--:|  
|  /api/login_check| POST  |  {username, password}| Checks for the user infos if the credentials are valide a token is given to the user. |  
|  /api/shops| POST | {latitude, longitude} | Gets the shops sorted by distance |  
|  /api/shops/liked| GET |  | Gets the shops liked by the current user |  
|  api/shops/likes| POST | {shopID} | Added the Shop to the list of liked shops (liked by the current user)|  
|  /api/sign_up| POST |  {username, password, lon, lat}| creates an Account using the provided data |  
  
## Authentication   
The authentication is based on [JWT](https://jwt.io/) .  
To request data from the API you'll need to send a valid token with each request, the token is provided to each user after the login.  
  
*For some developpement purposes the expiration time of a token is set to 3hours.*  
## External Packages  
  
 - [friendsofsymfony/rest-bundle](https://github.com/FriendsOfSymfony/FOSRestBundle) : Provides tools to developp a RESTfull API .  
 - [lexik/jwt-authentication-bundle](https://github.com/lexik/LexikJWTAuthenticationBundle) : Symfony JWT authentication .  
 - [nelmio/cors-bundle](https://github.com/nelmio/NelmioCorsBundle) : Addes simple [Cross-Origin Resource Sharing](http://enable-cors.org/) headers support .  
 - [mjaschen/phpgeo](https://github.com/mjaschen/phpgeo) : provides abstractions to geographical coordinate .  
## Features  
  The available feature as for now are the ones listed in the Endpoints section.  
## TODO At this point we still have some buggy/incomplete features :  
 - [ ] Dislike shops.  
 - [ ] Get dynamic user coordinates.  
 - [ ] remove a shop from liked shops list.  
 - [ ] Dislike a Shop.  
 - [ ] Refactoring.  
 - [ ] Securing token exchange. 
 - [ ] Complete the docker image. 
 - [ ] Unit Tests.   
## Contributor  
 - Hamza Hasbi [hamza.hasbi@gmail.com](mailto:hamza.hasbi@gmail.com)