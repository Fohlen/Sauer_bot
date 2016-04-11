## Sauerbraten_bot
-----
You'll see a little Telegram bot to organize matches for casual players right over here. I wrote it up with F3 for the #cube2 group.

### How'd I set it up?
Clone the repository and follow these steps

- Install stuff via composer ```composer install```
- Set up a Bot token in ```app/config.ini```

I recommend nginx with a config alike
```
server {

        root /path/to/Sauer_bot;

        location /app/config.ini {
                deny all;
        }

        location / {
                index index.php index.html index.htm;
                try_files $uri /public/$uri /index.php$is_args$args;
        }

        location ~ \.php$ {
               fastcgi_split_path_info ^(.+\.php)(/.+)$;
               # NOTE: You should have "cgi.fix_pathinfo = 0;" in php.ini

               # With php5-fpm:
               fastcgi_pass unix:/var/run/php5-fpm.sock;
               fastcgi_index index.php;
               include fastcgi.conf;
        }
}
``` 

### Any features to follow?
Some. I plan to extend on a few things, just to make it stable

- broadcast messages to all available groups (as an administrator maybe)
- add a badword list and a possibility to block users
- add a synchronization with tracker.impressivesquad.eu

I don't plan any feature beyond this, but feel welcome for pull-requests!