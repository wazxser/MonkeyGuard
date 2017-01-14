~/edison_ffmpeg/bin/ffmpeg -f v4l2 -framerate 30 -i /dev/video0 -f flv -y "rtmp://115.29.109.27:1935/live/livestream" & 1>ffmpeg.log
