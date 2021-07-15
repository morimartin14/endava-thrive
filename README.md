# endava-thrive Take-Home
> This is a solution for the problem planted on the Take-Home Document provided by Thrive
## Table of Contents
* [General Info](#general-information)
* [Technologies Used](#technologies-used)
* [Features](#features)
* [Screenshots](#screenshots)
* [Setup](#setup)
* [Usage](#usage)
* [Project Status](#project-status)
* [Contact](#contact)
<!-- * [License](#license) -->
## General Information
- Objective:
- The develop of a recently viewed product feature.  

## Technologies Used
- Php 7.3
- Docker (From php:7.3-apache)
- MySql
- Composer
- PhpUnit
- Bootstrap 5.0

## Features
In this app you can:
- Create 100 new Rand Products
- Create 1 new Rand Products
- See the list of All Products
- Add one product to the user recently viewed product list
- See the list of the recently viewed product list for the current loggued user
- Remove one product from the recently viewed product list for the current loggued user


## Screenshots
![Screenshot 1](https://raw.githubusercontent.com/morimartin14/endava-thrive/master/assets/img/screenshots/1.png)

![Screenshot 2](https://raw.githubusercontent.com/morimartin14/endava-thrive/master/assets/img/screenshots/2.png)

## Setup
Dockerfile and docker-compose.yml could by provided if needed, but basicaly, just need any developmen environmet with Apache, MySql and composer will work.
After the enviroment is working, you will need to run a composer install comand in order to get the PHPunit dependensies, then you can run all the unit 
test by running this command "./vendor/bin/phpunit tests"

## Test
Here are the test that are going to run when you execute the PHPunit command:
- testGetProductById
- testSaveRecentlyViewedProduct
- testGetRecentlyViewedProductForUser
- testUpdateRecentlyViewedProduct
- testRemoveRecentlyViewedProduct
- testGetAllRecentlyViewedProduct

## Usage
Once the server es running you will be able to see the index.php page (find scheenshot 1)
There you will see the list of actions that you can do.
* [Features](#features)

For example, to remove one product from the recently viewed product list for the current loggued user, you need to go to the Recently viewed Product screen by
clicking on the "Recently viewed Product" link, there you will see the "Remove from this list" button. 
  
  
  

