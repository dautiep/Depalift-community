#!/bin/bash

platform='unknown'
os=${OSTYPE//[0-9.-]*/}
if [[ "$os" == 'darwin' ]]; then
  platform='MAC OSX'
elif [[ "$os" == 'msys' ]]; then
  platform='window'
elif [[ "$os" == 'linux' ]]; then
  platform='linux'
fi
NORMAL="\\033[0;39m"
VERT="\\033[1;32m"
ROUGE="\\033[1;31m"
BLUE="\\033[1;34m"
ORANGE="\\033[1;33m"
echo -e "$ROUGE You are using $platform $NORMAL"
ESC_SEQ="\x1b["
COL_RESET=$ESC_SEQ"39;49;00m"
COL_RED=$ESC_SEQ"31;01m"
COL_GREEN=$ESC_SEQ"32;01m"
COL_YELLOW=$ESC_SEQ"33;01m"
COL_BLUE=$ESC_SEQ"34;01m"
COL_MAGENTA=$ESC_SEQ"35;01m"
COL_CYAN=$ESC_SEQ"36;01m"

## Linux bin paths, change this if it can not be autodetected via which command
BIN="/usr/bin"
CP="$($BIN/which cp)"
CD="$($BIN/which cd)"
GIT="$($BIN/which git)"
LN="$($BIN/which ln)"
MV="$($BIN/which mv)"
NGINX="/etc/init.d/nginx"
MKDIR="$($BIN/which mkdir)"
MYSQL="$($BIN/which mysql)"
MYSQLDUMP="$($BIN/which mysqldump)"
CHOWN="$($BIN/which chown)"
CHMOD="$($BIN/which chmod)"
GZIP="$($BIN/which gzip)"
ZIP="$($BIN/which zip)"
FIND="$($BIN/which find)"
RM="$($BIN/which rm)"

## SCRIPT_PATH=`pwd -P`
(cd $SCRIPT_PATH && $RM -f depalift-community.zip \;)
SCRIPT_PATH="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
echo -e "$VERT--> Your path: $SCRIPT_PATH $NORMAL"

################ FOR SYMFONY
if [ -f "$SCRIPT_PATH/../app/console" ]; then
  $RM -rf $SCRIPT_PATH/../app/cache/*
  $RM -rf $SCRIPT_PATH/../composer.lock

  [ ! -d "$SCRIPT_PATH/../app/cache/ip_data" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../app/cache/ip_data
  [ ! -f "$SCRIPT_PATH/../app/cache/ip_data/.gitignore" ] && touch $SCRIPT_PATH/../app/cache/ip_data/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../app/cache/ip_data/.gitignore

  [ ! -d "$SCRIPT_PATH/../app/cache/prod" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../app/cache/prod
  [ ! -f "$SCRIPT_PATH/../app/cache/prod/.gitignore" ] && touch $SCRIPT_PATH/../app/cache/prod/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../app/cache/prod/.gitignore

  [ ! -d "$SCRIPT_PATH/../app/cache/prod/annotations" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../app/cache/prod/annotations
  [ ! -f "$SCRIPT_PATH/../app/cache/prod/annotations/.gitignore" ] && touch $SCRIPT_PATH/../app/cache/prod/annotations/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../app/cache/prod/annotations/.gitignore

  [ ! -d "$SCRIPT_PATH/../app/cache/prod/data" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../app/cache/prod/data
  [ ! -f "$SCRIPT_PATH/../app/cache/prod/data/.gitignore" ] && touch $SCRIPT_PATH/../app/cache/prod/data/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../app/cache/prod/data/.gitignore

  [ ! -d "$SCRIPT_PATH/../app/cache/prod/doctrine" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../app/cache/prod/doctrine
  [ ! -f "$SCRIPT_PATH/../app/cache/prod/doctrine/.gitignore" ] && touch $SCRIPT_PATH/../app/cache/prod/doctrine/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../app/cache/prod/doctrine/.gitignore

  [ ! -d "$SCRIPT_PATH/../app/cache/prod/doctrine/cache" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../app/cache/prod/doctrine/cache
  [ ! -f "$SCRIPT_PATH/../app/cache/prod/doctrine/cache/.gitignore" ] && touch $SCRIPT_PATH/../app/cache/prod/doctrine/cache/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../app/cache/prod/doctrine/cache/.gitignore

  [ ! -d "$SCRIPT_PATH/../app/cache/prod/doctrine/cache/file_system" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../app/cache/prod/doctrine/cache/file_system
  [ ! -f "$SCRIPT_PATH/../app/cache/prod/doctrine/cache/file_system/.gitignore" ] && touch $SCRIPT_PATH/../app/cache/prod/doctrine/cache/file_system/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../app/cache/prod/doctrine/cache/file_system/.gitignore

  [ ! -d "$SCRIPT_PATH/../app/cache/prod/doctrine/orm" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../app/cache/prod/doctrine/orm
  [ ! -f "$SCRIPT_PATH/../app/cache/prod/doctrine/orm/.gitignore" ] && touch $SCRIPT_PATH/../app/cache/prod/doctrine/orm/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../app/cache/prod/doctrine/orm/.gitignore

  [ ! -d "$SCRIPT_PATH/../app/cache/prod/doctrine/orm/Proxies" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../app/cache/prod/doctrine/orm/Proxies
  [ ! -f "$SCRIPT_PATH/../app/cache/prod/doctrine/orm/Proxies/.gitignore" ] && touch $SCRIPT_PATH/../app/cache/prod/doctrine/orm/Proxies/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../app/cache/prod/doctrine/orm/Proxies/.gitignore

  [ ! -d "$SCRIPT_PATH/../app/cache/run" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../app/cache/run
  [ ! -f "$SCRIPT_PATH/../app/cache/run/.gitignore" ] && touch $SCRIPT_PATH/../app/cache/run/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../app/cache/run/.gitignore

  [ ! -d "$SCRIPT_PATH/../app/logs" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../app/logs
  [ ! -f "$SCRIPT_PATH/../app/logs/.gitignore" ] && touch $SCRIPT_PATH/../app/logs/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../app/logs/.gitignore

  [ ! -d "$SCRIPT_PATH/../translations" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../translations
  [ ! -f "$SCRIPT_PATH/../translations/.gitignore" ] && touch $SCRIPT_PATH/../translations/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../translations/.gitignore
fi

################ FOR LARAVEL
if [ -f "$SCRIPT_PATH/../artisan" ]; then
  $RM -rf $SCRIPT_PATH/../storage/framework/cache/data/*
  #  $RM -rf $SCRIPT_PATH/../storage/framework/sessions
  #  $RM -rf $SCRIPT_PATH/../storage/framework/testing
  $RM -rf $SCRIPT_PATH/../storage/framework/views/*.php
  $RM -rf $SCRIPT_PATH/../storage/logs/*.log
  $RM -rf $SCRIPT_PATH/../bootstrap/cache/*.php
  $RM -rf $SCRIPT_PATH/../composer.lock

  [ ! -d "$SCRIPT_PATH/../storage/framework/cache/data" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../storage/framework/cache/data || echo $SCRIPT_PATH/../storage/framework/cache/data
  #  [ -f "$SCRIPT_PATH/../storage/framework/cache/.gitignore" ] && $ECHO "Found: storage/framework/cache/.gitignore" || $TOUCH $SCRIPT_PATH/../storage/framework/cache/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../storage/framework/cache/.gitignore

  [ ! -d "$SCRIPT_PATH/../storage/framework/sessions" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../storage/framework/sessions
  #  [ -f "$SCRIPT_PATH/../storage/framework/sessions/.gitignore" ] && $ECHO "Found: storage/framework/sessions/.gitignore" || $TOUCH $SCRIPT_PATH/../storage/framework/sessions/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../storage/framework/sessions/.gitignore

  [ ! -d "$SCRIPT_PATH/../storage/framework/testing" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../storage/framework/testing
  #  [ -f "$SCRIPT_PATH/../storage/framework/testing/.gitignore" ] && $ECHO "Found: storage/framework/testing/.gitignore" || $TOUCH $SCRIPT_PATH/../storage/framework/testing/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../storage/framework/testing/.gitignore

  [ ! -d "$SCRIPT_PATH/../storage/framework/views" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../storage/framework/views
  [ -f "$SCRIPT_PATH/../storage/framework/views/.gitignore" ] && $ECHO "Found: storage/framework/views/.gitignore" || $TOUCH $SCRIPT_PATH/../storage/framework/views/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../storage/framework/views/.gitignore

  [ ! -d "$SCRIPT_PATH/../storage/logs" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../storage/logs
  [ -f "$SCRIPT_PATH/../storage/logs/.gitignore" ] && $ECHO "Found: storage/logs/.gitignore" || $TOUCH $SCRIPT_PATH/../storage/logs/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../storage/logs/.gitignore

  [ ! -d "$SCRIPT_PATH/../bootstrap/cache" ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../bootstrap/cache
  [ -f "$SCRIPT_PATH/../bootstrap/cache/.gitignore" ] && $ECHO "Found: bootstrap/cache/.gitignore" || $TOUCH $SCRIPT_PATH/../bootstrap/cache/.gitignore && echo -e "*\n!.gitignore"$'\r' >$SCRIPT_PATH/../bootstrap/cache/.gitignore

  ## [ ! -d "$SCRIPT_PATH/../storage/DoctrineModule"  ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../storage/DoctrineModule && touch $SCRIPT_PATH/../storage/DoctrineModule/.gitignore && echo -e "*\n!.gitignore"$'\r' > $SCRIPT_PATH/../storage/DoctrineModule/.gitignore
  ## [ ! -d "$SCRIPT_PATH/../storage/DoctrineORMModule"  ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../storage/DoctrineORMModule && touch $SCRIPT_PATH/../storage/DoctrineORMModule/.gitignore && echo -e "*\n!.gitignore"$'\r' > $SCRIPT_PATH/../storage/DoctrineORMModule/.gitignore
  ## [ ! -d "$SCRIPT_PATH/../storage/DoctrineORMModule/Hydrator"  ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../storage/DoctrineORMModule/Hydrator && touch $SCRIPT_PATH/../storage/DoctrineORMModule/Hydrator/.gitignore && echo -e "*\n!.gitignore"$'\r' > $SCRIPT_PATH/../storage/DoctrineORMModule/Hydrator/.gitignore
  ## [ ! -d "$SCRIPT_PATH/../storage/DoctrineORMModule/Proxy"  ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../storage/DoctrineORMModule/Proxy && touch $SCRIPT_PATH/../storage/DoctrineORMModule/Proxy/.gitignore && echo -e "*\n!.gitignore"$'\r' > $SCRIPT_PATH/../storage/DoctrineORMModule/Proxy/.gitignore
  ## [ ! -d "$SCRIPT_PATH/../storage/DoctrineMongoODMModule"  ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../storage/DoctrineMongoODMModule && touch $SCRIPT_PATH/../storage/DoctrineMongoODMModule/.gitignore && echo -e "*\n!.gitignore"$'\r' > $SCRIPT_PATH/../storage/DoctrineMongoODMModule/.gitignore
  ## [ ! -d "$SCRIPT_PATH/../storage/DoctrineMongoODMModule/Hydrator"  ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../storage/DoctrineMongoODMModule/Hydrator && touch $SCRIPT_PATH/../storage/DoctrineMongoODMModule/Hydrator/.gitignore && echo -e "*\n!.gitignore"$'\r' > $SCRIPT_PATH/../storage/DoctrineMongoODMModule/Hydrator/.gitignore
  ## [ ! -d "$SCRIPT_PATH/../storage/DoctrineMongoODMModule/Proxy"  ] && $MKDIR -m $FDMODE -p $SCRIPT_PATH/../storage/DoctrineMongoODMModule/Proxy && touch $SCRIPT_PATH/../storage/DoctrineMongoODMModule/Proxy/.gitignore && echo -e "*\n!.gitignore"$'\r' > $SCRIPT_PATH/../storage/DoctrineMongoODMModule/Proxy/.gitignore
fi

## try if CMDS exist
command -v $PHP >/dev/null || {
  echo "php command not found."
  exit 1
}
HASCURL=1
command -v curl >/dev/null || HASCURL=0
if [ -z "$1" ]; then
  DEVMODE=$1
else
  DEVMODE="--no-dev"
fi

### settings / options
PHPCOPTS="-d memory_limit=-1"

## get last composer
if [ -f composer.phar ]; then
  php $PHPCOPTS composer.phar config --global discard-changes true
  php $PHPCOPTS composer.phar self-update
else
  if [ HASCURL == 1 ]; then
    curl -sS https://getcomposer.org/installer | php
  else
    php $PHPCOPTS -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
  fi
fi

## install or update with composer
if [ -f composer.lock ]; then
  $PHP $PHPCOPTS composer.phar config --global discard-changes true
  $PHP $PHPCOPTS composer.phar update -o -a
  ## php $PHPCOPTS composer.phar $DEVMODE update -o -a;
else
  $PHP $PHPCOPTS composer.phar config --global discard-changes true
  $PHP $PHPCOPTS composer.phar install -o -a
fi

## for laravel
if [ -f "$SCRIPT_PATH/../artisan" ]; then
  ## ($CD $SCRIPT_PATH/ && $PHP artisan vendor:publish --tag=public --force)
  ($CD $SCRIPT_PATH/ && $PHP $PHPCOPTS artisan config:clear && $PHP $PHPCOPTS artisan cache:clear)
fi

## allow bots engine
(cd $SCRIPT_PATH && $FIND . -type f -name 'robots.txt' -exec sed -i "s/Disallow\: \//Disallow\:/g" {} \;)
(cd $SCRIPT_PATH && $FIND public/ -type f -name 'robots.txt' -exec sed -i "s/Disallow\: \//Disallow\:/g" {} \;)

################ without symlink
(cd $SCRIPT_PATH && $ZIP -r4uy depalift-community.zip . -x \*.buildpath/\* \*.idea/\* \*.project/\* \*nbproject/\* \*.git/\* \*.svn/\* \*.gitignore\* \*.gitattributes\* \*.md \*.MD \*.log \*.zip \*.tar.gz \*.gz \*.tar \*.rar \*.DS_Store \*.lock \*desktop.ini vhost-nginx.conf \*.tmp \*.bat delivery.sh remove-botble.sh readme.html composer.lock wp-config.secure.php)

(cd $SCRIPT_PATH && $MYSQLDUMP -uuserdb.dev.depalift_community -pl8NmQWTErl2WZFXa --default-character-set utf8 dev_depalift_community >depalift-community.sql)

(cd $SCRIPT_PATH && $CHOWN -R dev:dev .)

## for laravel
if [ -f "$SCRIPT_PATH/../artisan" ]; then
  (cd $SCRIPT_PATH && $MV depalift-community.zip $SCRIPT_PATH/public/)
  (cd $SCRIPT_PATH && $MV depalift-community.sql $SCRIPT_PATH/public/)
fi

##################### Begin compress media files
## find . -type f -iname "*.png" -print0 | xargs -I {} -0 optipng -o5 -quiet -keep -preserve "{}"
## find . -type f -iname "*.png" -print0 | xargs -I {} -0 optipng -o5 -preserve "{}"
command -v optipng >/dev/null || {
  echo "optipng command not found."
  ## exit 1
}

## Compress Quality to 50% for all Images in a Folder That are larger than 500kb
## find . -size +300k -type f -name "*.jpg" | xargs jpegoptim --max=50 -f --strip-all
## jpegoptim --size=250k tecmint.jpeg
command -v jpegoptim >/dev/null || {
  echo "jpegoptim command not found."
  ## exit 1
}
##################### End compress media files

echo -e "$VERT--> http://depalift-community.dev.gistensal.com/depalift-community.zip $NORMAL"
echo -e "$VERT--> http://depalift-community.dev.gistensal.com/depalift-community.sql $NORMAL"
echo -e "$ORANGE--> Done!$NORMAL"
