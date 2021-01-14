FROM node:12.12.0-alpine

WORKDIR /var/www/Front

COPY ./Front/package*.json ./
COPY ./Front/webpack.config.js ./
COPY ./Front/.babelrc ./

RUN npm install

# copy all the app
COPY ./Front ./

EXPOSE 3000
EXPOSE 35729

# start the app
CMD npm start
