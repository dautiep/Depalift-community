# Compress with WebOptima options
<IfModule mod_deflate.c>
    <IfModule mod_setenvif.c>
        BrowserMatch ^Mozilla/4 gzip-only-text/html
        BrowserMatch ^Mozilla/4\.0[678] no-gzip
        BrowserMatch SV1; !no_gzip
        BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
    </IfModule>
    AddOutputFilterByType DEFLATE text/javascript application/javascript application/x-javascript text/x-js text/ecmascript application/ecmascript text/vbscript text/fluffscript
    AddOutputFilterByType DEFLATE image/svg+xml application/x-font-ttf application/x-font font/opentype font/otf font/ttf application/x-font-truetype application/x-font-opentype application/vnd.ms-fontobject application/vnd.oasis.opendocument.formula-template
</IfModule>
<IfModule mod_headers.c>
    # SUPPORT PROXY SERVER
    <FilesMatch \.(css|js)$>
        Header append Vary User-Agent
        Header append Vary Accept-Encoding
        Header append Cache-Control private
    </FilesMatch>
    <FilesMatch \.(bmp|png|gif|jpe?g|ico|flv|wmv|asf|asx|wma|wax|wmx|wm|ogg|mp4|mp3|wav|mid|swf|pdf|doc|rtf|xls|ppt|eot|ttf|otf|svg|woff)$>
        Header append Cache-Control public
    </FilesMatch>
    <FilesMatch \.(js|css|bmp|png|gif|jpe?g|ico|flv|wmv|asf|asx|wma|wax|wmx|wm|ogg|mp4|mp3|wav|mid|swf|pdf|doc|rtf|xls|ppt|woff)$>
        Header unset Last-Modified
        FileETag MTime
    </FilesMatch>
    # SUPPORT PROXY SERVER end
</IfModule>
<IfModule mod_mime.c>
    # STATIC GZIP
    AddEncoding gzip .gz
    AddEncoding deflate .df
    <FilesMatch \.html\.(gz|df)$>
        ForceType text/html
    </FilesMatch>
    <FilesMatch \.xml\.gz$>
        ForceType text/xml
    </FilesMatch>
    <FilesMatch \.txt\.gz$>
        ForceType text/plain
    </FilesMatch>
    <FilesMatch \.ico\.gz$>
        ForceType image/x-icon
    </FilesMatch>
    <FilesMatch \.cur\.gz$>
        ForceType image/vnd.microsoft.icon
    </FilesMatch>
    <FilesMatch \.css\.gz$>
        ForceType text/css
    </FilesMatch>
    <FilesMatch \.js\.gz$>
        ForceType application/x-javascript
    </FilesMatch>
    <FilesMatch \.svg\.gz$>
        ForceType image/svg+xml
    </FilesMatch>
    <FilesMatch \.ttf\.gz$>
        ForceType font/ttf
    </FilesMatch>
    <FilesMatch \.otf\.gz$>
        ForceType font/otf
    </FilesMatch>
    <FilesMatch \.eot\.gz$>
        ForceType application/vnd.ms-fontobject
    </FilesMatch>
    <FilesMatch \.(rtf|rtx)\.gz$>
        ForceType text/richtext
    </FilesMatch>
    <FilesMatch \.xsd\.gz$>
        ForceType text/xsd
    </FilesMatch>
    <FilesMatch \.xsl\.gz$>
        ForceType text/xsl
    </FilesMatch>
    AddType text/css css
    AddType application/x-javascript js
    AddType text/html html htm
    AddType text/richtext rtf rtx
    AddType text/plain txt
    AddType text/xsd xsd
    AddType text/xsl xsl
    AddType text/xml xml
    AddType text/cache-manifest manifest
    AddType video/asf asf asx wax wmv wmx
    AddType video/avi avi
    AddType video/ogg ogg ogv
    AddType video/mp4 mp4 m4v
    AddType video/webm webm
    AddType video/divx divx
    AddType video/quicktime mov qt
    AddType video/mpeg mpeg mpg mpe
    AddType audio/midi mid midi
    AddType audio/mpeg mp3 m4a
    AddType audio/ogg ogg
    AddType audio/x-realaudio ra ram
    AddType audio/wav wav
    AddType audio/wma wma
    AddType image/svg+xml svg svgz
    AddType image/bmp bmp
    AddType image/gif gif
    AddType image/x-icon ico
    AddType image/vnd.microsoft.icon ico
    AddType image/jpeg jpg jpeg jpe
    AddType image/png png
    AddType image/tiff tif tiff
    AddType font/ttf ttf
    AddType font/otf otf
    AddType font/x-woff woff
    AddType application/vnd.ms-fontobject eot
    AddType application/msword doc docx
    AddType application/x-msdownload exe
    AddType application/vnd.ms-access mdb
    AddType application/vnd.ms-project mpp
    AddType application/vnd.ms-powerpoint pot pps ppt pptx
    AddType application/vnd.ms-write wri
    AddType application/vnd.ms-excel xla xls xlsx xlt xlw
    AddType application/vnd.oasis.opendocument.database odb
    AddType application/vnd.oasis.opendocument.chart odc
    AddType application/vnd.oasis.opendocument.formula odf
    AddType application/vnd.oasis.opendocument.graphics odg
    AddType application/vnd.oasis.opendocument.presentation odp
    AddType application/vnd.oasis.opendocument.spreadsheet ods
    AddType application/vnd.oasis.opendocument.text odt
    AddType application/java class
    AddType application/x-gzip gzip
    AddType application/pdf pdf
    AddType application/x-shockwave-flash swf
    AddType application/x-tar tar
    AddType application/zip zip
    # STATIC GZIP end
</IfModule>
<IfModule mod_rewrite.c>
    RewriteBase /
    RewriteRule ^(.*)\.wo[0-9]+\.(js|php)$ $1.$2
    # REWRITE STATIC GZIP JAVASCRIPT
    RewriteCond %{HTTP:Accept-encoding} gzip
    RewriteCond %{HTTP_USER_AGENT} !Konqueror
    RewriteCond %{REQUEST_FILENAME}.gz -f
    RewriteRule ^(.*)\.js$ $1.js.gz [QSA,L]
    # REWRITE STATIC GZIP JAVASCRIPT end
    # REWRITE STATIC GZIP FONTS
    RewriteCond %{HTTP:Accept-encoding} gzip
    RewriteCond %{HTTP_USER_AGENT} !Konqueror
    RewriteCond %{REQUEST_FILENAME}.gz -f
    RewriteRule ^(.*)\.(ttf|otf|eot|svg)$ $1.$2.gz [QSA,L]
    # REWRITE STATIC GZIP FONTS end
</IfModule>
<IfModule mod_expires.c>
    ExpiresActive On
    <FilesMatch \.manifest$>
        ExpiresDefault A0
    </FilesMatch>
    ExpiresByType text/cache-manifest A0
    # EXPIRES JAVASCRIPT FILES
    <FilesMatch \.js$>
        ExpiresDefault "access plus 10 years"
    </FilesMatch>
    ExpiresByType text/javascript A315360000
    ExpiresByType application/javascript A315360000
    ExpiresByType application/x-javascript A315360000
    ExpiresByType text/x-js A315360000
    ExpiresByType text/ecmascript A315360000
    ExpiresByType application/ecmascript A315360000
    ExpiresByType text/vbscript A315360000
    ExpiresByType text/fluffscript A315360000
    # EXPIRES JAVASCRIPT FILES end
</IfModule>
# WebOptima options end