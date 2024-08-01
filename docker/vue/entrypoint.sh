#!/usr/bin/env bash

node --version
npm --version
java -version

cd /var/www/html || {
  echo "Failure"
  exit 1
}

npm install

npm run build
npm run dev

bash -l
