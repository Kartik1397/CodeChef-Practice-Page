# CodeChef Practice Page

This project built by me for codechef internship assesment 2021.

## DEMO

[Go to Demo](https://www.ccpractice.ml/) and create your own account or use username: test and password: test12345. The demo is hosted on Azure Virtual Machine.
![Current Status](https://s2.gifyu.com/images/ccpractice.gif)
## Stack (Slim & React)

This project use following technologies

- [MySQL](https://www.mysql.com/) for database (self hosted)
- [Slim Framework](https://www.slimframework.com/) as PHP web framework
- [React.js](https://reactjs.org) for client, [React Router](https://reacttraining.com/react-router/) for routing & [Redux](https://redux.js.org/basics/usagewithreact) for state management
- [Create React App](https://github.com/facebook/create-react-app) for bootstrapping client

## Features

#### General

- [x] Authentication with Email Verification
- [x] Practice Page and User Page
- [x] Responsive Design

#### Tags

- [x] Tag Search with autocomplete
- [x] Custom tag for registered user
- [x] Filter problems with multiple tags
- [x] Filter problems according to difficulty
- [x] Delete Custom tags

#### Deployment

- [x] Configured Nginx server
- [x] Created deploy.sh
- [x] Deployed on Azure VM

## Install

make sure you have MySQL(with phpmyadmin), Nodejs, PHP and Composer installed

#### Import Database

Create database named "ccpp" and import \_sql/ccpp.sql file in phpmyadmin

#### For api

Create .env file according to .env.example
```javascript
cd api
// Install all dependencies for server
composer install

// Run development server
cp public
php -S localhost:3000
```

#### For client

Create .env file according to .env.example
```javascript
cd client
// Install all dependencies for server
npm install

// Run development server
npm start
```

## API

[Click here](https://github.com/Kartik1397/CodeChef-Practice-Page/tree/main/api) to read api documentation

## DATABASE

Database Schema is given in [Schema.pdf](https://github.com/Kartik1397/CodeChef-Practice-Page/blob/main/Schema.pdf) file
