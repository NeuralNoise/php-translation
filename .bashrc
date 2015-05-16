PROJECT=translation
PS1="\`if [ \$? = 0 ]; then echo \[\e[32m\]${PROJECT}\[\e[0m\]; else echo \[\e[31m\]${PROJECT}\[\e[0m\]; fi\`:\w$ "
cd /vagrant

function php {
  sudo docker run -it --rm --net host -v $(pwd):/wd -w /wd shouldbee/php /sbin/my_init --quiet --skip-startup-files --skip-runit -- php "$@"
}

function composer {
  sudo docker run -it --rm --net host -v $(pwd):/app composer/composer "$@"
}
