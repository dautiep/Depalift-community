server {
    server_name depalift-community.dev.gistensal.com www.depalift-community.dev.gistensal.com;
    root   /home/dev/htdocs/depalift-community/public;
    
    # Enable HSTS (https://developer.mozilla.org/en-US/docs/Security/HTTP_Strict_Transport_Security)
    # The HTTP Strict-Transport-Security response header (often abbreviated as HSTS)  lets a web site tell browsers that it should only be accessed using HTTPS, instead of using HTTP.
    # include sub domains
    #### add_header Strict-Transport-Security "max-age=63072000; includeSubdomains; preload";
    #### add_header Strict-Transport-Security "max-age=31536000" always;
    # "max-age=0" to disable
    #### add_header Strict-Transport-Security "max-age=0;";
    #### add_header X-Content-Type-Options nosniff;
    add_header X-XSS-Protection "1; mode=block";

    #### add_header X-Content-Type-Options nosniff;
    more_set_headers 'Server: Microsoft-IIS/8.0';
    more_set_headers 'X-Powered-By: ASP.NET';
    ## more_set_headers 'X-Frame-Options:ALLOW-FROM http://depalift-community.dev.gistensal.com';
    ## more_set_headers "Content-Security-Policy:default-src 'self' ;script-src 'self' 'unsafe-inline' 'unsafe-eval' ;;style-src 'self' 'unsafe-inline' ;img-src 'self' data:  *.tile.openstreetmap.org *.tile.opencyclemap.org *.googleapis.com *.google-analytics.com;";
    ## more_set_headers "X-Content-Security-Policy:default-src 'self' ;options inline-script eval-script;img-src 'self' data:  *.tile.openstreetmap.org *.tile.opencyclemap.org *.googleapis.com *.google-analytics.com;";
    ## more_set_headers "X-Frame-Options:default-src 'self' ;options inline-script eval-script;img-src 'self' data:  *.tile.openstreetmap.org *.tile.opencyclemap.org *.googleapis.com *.google-analytics.com;";
    ## more_set_headers "X-WebKit-CSP:default-src 'self' ;script-src 'self'  'unsafe-inline' 'unsafe-eval';style-src 'self' 'unsafe-inline' ;img-src 'self' data:  *.tile.openstreetmap.org *.tile.opencyclemap.org *.googleapis.com *.google-analytics.com;";
    ## more_set_input_headers 'Host: Microsoft-IIS/8.0';

    ## IMPORTANT : Fixed HTTP Code 422 error Openproject 8.x
    proxy_set_header X-Forwarded-Proto $scheme; 

    ## access_log /home/dev/logs/depalift-community.access.log;
    access_log off;
    error_log /home/dev/logs/depalift-community.error.log;	
    server_tokens off;
    
    charset utf-8;
    index index.php index.html index.htm;

    ### FOR PHALCON ONLY
    ##location @rewrite {
    ##    rewrite ^/(.*)$ /index.php?_url=/$1;
    ## }
    ### FOR PHALCON ONLY

    ##auth_basic "Username and Password are required"; 
    ##auth_basic_user_file /var/www/.htpasswd;
        
    location / {
        ## try_files $uri $uri/ @rewrite; ## FOR PHALCON ONLY, comment bellow line if your are using phalcon
        try_files $uri $uri/ /index.php?$query_string;
    }

    # REQUIREMENTS : Enable PHP Support
    location ~ \.php$ {
        fastcgi_param   NODE_ENV development;
        fastcgi_param   APP_ENV development;
        fastcgi_param   APPLICATION_ENV development;
        fastcgi_param   CI_ENV development; ## For CI framework
        fastcgi_param   ENVIRONMENT development; ## For CI framework

        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        ## try_files $uri $uri/ @rewrite; ## FOR PHALCON ONLY, comment bellow line if your are using phalcon
        try_files       $uri $uri/ /index.php?$query_string;

        fastcgi_pass    unix:/opt/php7/var/run/php-fpm-dev.sock;
        ## fastcgi_pass    unix:/opt/php-5.4.45/var/run/php-fpm-dev.sock; ## PHP 5.4.45
        ## fastcgi_pass    unix:/opt/php5/var/run/php-fpm-dev.sock;
        fastcgi_index   index.php;
	
        fastcgi_intercept_errors on;
        fastcgi_param   SCRIPT_FILENAME $realpath_root$fastcgi_script_name; ### very important, avoid the nginx download php file instead of executed

        include fastcgi_params;
    }
    ## SECURITY : Deny all attempts to access PHP Files in the uploads directory
    location ~* /(?:uploads|files)/.*\.php$ {deny all;}
    ## !!! IMPORTANT !!! We need to hide the password file from prying eyes
    ## This will deny access to any hidden file (beginning with a .period)
    location ~ /\. { deny  all; }
        
    ## Images and static content is treated different
    ## PERFORMANCE : Set expires headers for static files and turn off logging.
    location ~* ^.+\.(mp3|pdf|js|css|swf|txt|ogg|ogv|svg|svgz|eot|otf|woff|woff2|mp4|ttf|rss|atom|jpg|jpeg|gif|png|ico|zip|tgz|gz|rar|bz2|doc|xls|exe|ppt|tar|mid|midi|wav|bmp|rtf|sql)$ {
        access_log off; log_not_found off; expires max;
    }
    # Prevent Direct Access To Protected Files
    location ~ \.(env|log) {deny all;}
    location ~ /\.(?!well-known).* { deny all; }
    # location ~ \.css {add_header  Content-Type    text/css;}
    # location ~ \.js {add_header  Content-Type    application/x-javascript;}
    # location ~ ^\/(js|img|css) {access_log off; log_not_found off; expires max;}
    # location ~ /\. {access_log off;log_not_found off;deny all;}

    # ESSENTIAL : Configure 404 Pages
    # error_page 404 =200 /dummy.gif;
    # location = /dummy.gif {root /etc/nginx/html/;}    
    # error_page 404 /404.html;
    # location = /404.html {root /etc/nginx/html;}
	
    # ESSENTIAL : Configure 50x Pages
    # error_page 500 502 503 504 /50x.html;
    # location = /50x.html {root /etc/nginx/html;}

    ### disable logging ###
    location = /robots.txt { return 204;access_log off; log_not_found off; }
    location = /favicon.ico { return 204;access_log off; log_not_found off; }
}
