FROM nginx:stable

COPY ./default.conf /etc/nginx/docker.conf

RUN export NGINX_HOST=`echo $APP_URL | awk -F/ '{print $3}'`
RUN envsubst '$$NGINX_HOST' < /etc/nginx/docker.conf > /etc/nginx/conf.d/default.conf

# php host is physically missing
RUN echo `nginx -g 'daemon off;'`
