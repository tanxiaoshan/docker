#!/bin/bash
APPGROUP=dayuwen_server
APPNAME=tg_game
CODESPACE=/Users/shershon
echo "下载gitlab最新代码"
git clone git@gitlab.com:middleplat/dsp_frame.git ${CODESPACE}/dsp
cd ${CODESPACE}/dsp && rm -rf .git
mkdir -p ${CODESPACE}/dsp/log/app ${CODESPACE}/dsp/log/debug ${CODESPACE}/dsp/log/php ${CODESPACE}/dsp/log/service ${CODESPACE}/dsp/log/webserver
git clone git@gitlab.com:middleplat/dsp_phplib.git ${CODESPACE}/dsp/php/phplib
cd ${CODESPACE}/dsp/php/phplib && rm -rf .git
git clone git@gitlab.com:middleplat/dsp_nginx_conf.git ${CODESPACE}/dsp/webserver/conf
cd ${CODESPACE}/dsp/webserver/conf && rm -rf .git
git clone git@gitlab.com:middleplat/dsp_conf.git ${CODESPACE}/dsp/conf
cd ${CODESPACE}/dsp/conf && rm -rf .git
git clone git@gitlab.com:${APPGROUP}/${APPNAME}.git ${CODESPACE}/dsp/app/${APPNAME}
cd ${CODESPACE}/dsp/app/${APPNAME} && rm -rf .git

chown -R shershon:staff ${CODESPACE}/dsp
