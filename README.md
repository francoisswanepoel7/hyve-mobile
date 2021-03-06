Hyve Mobile Importer: Client
-
1. composer update
2. CLI: php /src/importer/client/index.php
3. API Post Endpoint: https://import.tsekcorona.co.za/process
4. Environment vars in /src/utils/.env
5. Importer sends all data to GoLang API

Components
- DotEnv Loader
- League CSV package for CSV Manipulation
- Nestbot/Carbon package for Time Manipulation
- utils\Importer does main processing

Processing
- Timezones
- Notes are UTF-8 encoded if UTF-8 or out through htmlspecialchars if not
- Images get created under the '/card' directory and the base64 encoded string is set in the post data to the API 




Hyve Mobile API
-------------------
This API is located at: https://api.tsekcorona.co.za/

Calls:

Contacts API Calls (GET): 
 - https://api.tsekcorona.co.za/contacts?page=2
 - https://api.tsekcorona.co.za/contacts/2/
    
Timezone API Calls (GET):
 - https://api.tsekcorona.co.za/timezone?timezone=Asia/Jakarta
 - https://api.tsekcorona.co.za/timezone/Asia/Jakarta
 
 Contact API (POST)
 - https://api.tsekcorona.co.za/contact
 
 Components
 --
 RequestController:
  - Allowed Methods (GET/POST) and Endpoints check(contact/contacts/timezone) for those methods -> default to home
  
  DBO
  - Nette/Database package from Packagist
  
 
 
 Nginx Configuration
 -------------------
 server {
 
         root /home/francois/hyve/src/api;
 
         index index.php index.html index.htm index.nginx-debian.html;
 
         server_name api.tsekcorona.co.za;
         access_log /var/log/nginx/api.tsekcorona.co.za.access;
         error_log /var/log/nginx/api.tsekcorona.co.za.error;
 
         location / {
                 try_files $uri $uri/ /index.php?$args;
         }
 
         location ~ \.php$ {
                 include snippets/fastcgi-php.conf;
                 fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
         }
 
     listen [::]:443 ssl ipv6only=on; # managed by Certbot
     listen 443 ssl; # managed by Certbot
     ssl_certificate /etc/letsencrypt/live/api.tsekcorona.co.za/fullchain.pem; # managed by Certbot
     ssl_certificate_key /etc/letsencrypt/live/api.tsekcorona.co.za/privkey.pem; # managed by Certbot
     include /etc/letsencrypt/options-ssl-nginx.conf; # managed by Certbot
     ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem; # managed by Certbot
 
 }
 
 server {
     if ($host = api.tsekcorona.co.za) {
         return 301 https://$host$request_uri;
     } # managed by Certbot
 
 
         listen 80;
         listen [::]:80;
 
         server_name api.tsekcorona.co.za;
         return 404; # managed by Certbot
}
