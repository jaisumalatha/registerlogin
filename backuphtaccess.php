<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteBase /codeignatoreproject/
	#RewriteCond %{HTTP} off
	#RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [R,L]
	<Files "upload.php">
		Order Allow,Deny
		Deny from all
	</Files>
	#php_value max_input_vars 100000
	#php_value memory_callbackslimit 1024M
	#php_value upload_max_filesize 30M
	#php_value post_max_size 300M
	
	Options -Indexes
	
	#Removes access to the system folder by users.
	#Additionally this will allow you to create a System.php controller,
	#previously this would not have been possible.
	#'system' can be replaced if you have renamed your system folder.
	RewriteCond %{REQUEST_URI} ^system.*
	RewriteRule ^(.*)$ /index.php/$1 [L]
	
	#When your application folder isn't in the system folder
	#This snippet prevents user access to the application folder
	#Rename 'application' to your applications folder name.
	RewriteCond %{REQUEST_URI} ^application.*
	RewriteRule ^(.*)$ /index.php/$1 [L]
	
	#Checks to see if the user is attempting to access a valid file,
	#such as an image or css document, if this isn't true it sends the
	#request to index.php
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ index.php/$1 [L]
	
	#RewriteRule \.(jpg|php|pdf)$ - [F]
	#RewriteRule ^404/?$ errors/404.html [NC]
	#ErrorDocument 403 /errors/error_404.php
	#ErrorDocument 404 /errors/error_404.php
</IfModule>
<IfModule mod_headers.c> 
	#Header set Content-Security-Policy "default-src 'self'"
	Header set Strict-Transport-Security "max-age=10886400; includeSubDomains; preload" env=HTTPS
	Header set X-XSS-Protection: 1;
	Header set X-Content-Type-Options: nosniff
	#Header set X-Frame-Options DENY
	#Header set Cache-Control "no-cache, no-store, private" 
	#Header set Pragma "no-cache" 
</IfModule>
<IfModule !mod_rewrite.c>
	# If we don't have mod_rewrite installed, all 404's
	# can be sent to index.php, and everything works as normal.
	ErrorDocument 404 /index.php
</IfModule>