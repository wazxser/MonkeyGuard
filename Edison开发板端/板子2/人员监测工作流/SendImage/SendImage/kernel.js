var shell = require('shelljs');
shell.exec("~/edison_ffmpeg/bin/ffmpeg -probesize 32768 -i rtmp://115.29.109.27:1935/live/livestream -y -t 0.001 -ss 1 -f image2 -r 1 image.jpg");
shell.exec("java SendImage");