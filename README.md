# Vyndue
**Arbitrage Chat Application**

Instructions: 

How to run Vyndue App in Local Machine 

# clone vydnue app in gitlab / github 
 - cd inside vyndue folder
 - install composer then run “composer update”
 - install npm then run “cd chatapp && npm install”
 - sudo chmod -R 777 application/cache/session/
 - Tweak database configuration

# Note: Use port 3000 in websocket 
 - assets/newTheme/assets/js/si.js # var socket=io.connect("ws://localhost:3000",{"transports": ['websocket']});
 - application/config/config.php
 - ChatApp/serverConf.js
 - ChatApp/bin/www
 - ChatApp/server.js

# Run socket
 - run in chatapp folder “node server”
 - if has error in running port run
   > sudo kill $(sudo lsof -t -i:3000)

# View in browser 

// Vyndue 

http://localhost/

// Vyndue Admin

http://localhost/admin
U: admin@admin.com 
P: 123456


![alt text][logo]

[logo]: https://media.giphy.com/media/amrNGnZUeWhZC/giphy.gif
