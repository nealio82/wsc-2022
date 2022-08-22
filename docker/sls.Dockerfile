FROM node:14

RUN npm install -g serverless

ENTRYPOINT [ "serverless" ]