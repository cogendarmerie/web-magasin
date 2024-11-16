FROM node:14-alpine

# Installer SASS
RUN npm install -g sass

WORKDIR /app

COPY . .

CMD ["sass", "--watch", "./assets/css:./public/assets/css", "--no-source-map", "--style=compressed"]