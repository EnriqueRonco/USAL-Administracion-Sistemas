#!/bin/bash
perl copiaSeguridad.pl
cp -r /home/backup /root/Dropbox
~/.dropbox-dist/dropboxd &
