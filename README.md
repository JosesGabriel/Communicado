# Communicado
### Messaging Platform written in CodeIgniter & Node


##### How to run in Local Machine

**clone vydnue app in gitlab / github** 
 - `cd vyndue-chat-app` folder
 - **install npm** then run `cd chatapp && npm install`
 - `sudo mkdir application/cache/session/`
 - `sudo chmod -R 777 application/cache/session/` 
 - Create database in MySQL **vyndue03_msgr**
 - Open **query.sql** file then copy and paste in MySQL Query run
 - Setup virtual host for Vyndue (don't use .io or .dev extensions, might cause errors)

**Run socket**
 - run in chatapp folder “node server”
 - if has error in running port run
   > sudo kill $(sudo lsof -t -i:3000)

**Note: Use port 3000 in websocket** 
 - assets/newTheme/assets/js/si.js # var socket=io.connect("ws://localhost:3000",{"transports": ['websocket']});
 - application/config/config.php
 - ChatApp/serverConf.js
 - ChatApp/bin/www
 - ChatApp/server.js


**View in browser** 
> Vyndue User

  http://localhost/

  U: `billy@email.com` 
  
  P: `123456`

> Vyndue Admin
  
  http://localhost/admin 
  
  U: `arbitrage@email.com` 
  
  P: `123456`


![alt text][logo]

[logo]: https://media.giphy.com/media/amrNGnZUeWhZC/giphy.gif
