#Dockerfile

#使うDockerイメージ
FROM mysql:8

#ポートを開ける
EXPOSE 3306

#MySQL設定ファイルをイメージ内にコピー
COPY ./conf/my.conf /etc/mysql/conf.d/my.cnf

# timezone setting
RUN cp /etc/localtime /etc/localtime.org
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

#docker runに実行される
CMD ["mysqld"]