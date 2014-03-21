PHP-Codeigniter With JqWidgets code sample
=========================
Jq Widgets Grid example code with codeignter to enhance larg scale data.
This example just show the basic listing feature for jqWidgets Grid, In future i hope to upload further enhance features with jqxGrid
In this example i just add the these features:
 - Filter Data
 - Sort Data
 - Pagintaion
 - status bar rendring.



## Include
### Core
* [CodeIgniter](https://github.com/EllisLab/CodeIgniter) 2.1.3 
* [Jquery](http://jquery.com/) 1.10.2
* [JqWidget](http://www.jqwidgets.com/) 3.0.1
 



### Directory Structure
Here is the Complete directory structure.

```
application/
    config/                     
      config.php                  // Config base URL
      database.php                //config the database
    controllers                   //controllers folder
      part1.php                   // example controller
    models
      part1_model.php             //our example model
    views
      part1
        index.php                 //view file
    
system/                           //system library files
theme/
  jqwidgets/                      // hold jq widgets library
  js/
    views/
      part1/
        index.js                  //hold the grid and others implementaion
    jquery-1.10.2.min.js
  
db
  git_jqxci_part1.sql             //example database sql file 
index.php                         //codeingniter main index file
```
## Usage

### Setup
 Just unzip the package and put the source code in your server.

* Set your base URL in `application/config/config.php` file. Example: `$config['base_url'] = 'http://localhost/test/';`
* Set your database in `application/config/database.php` file.

### Guidelines

#### Database
Create the data with provided or your own data or just upload the database file db/git_jqxci_part1.sql

#### Javascript Url Setting 
Varibale initialization for theme/js/views/part1/index.js


```

[js]
var gridID = "allCustomers";  //this var hold the id of div in which you want to render grid data.
var path = base_url+'index.php/part1/allGrid'; //this variable hold the controller path for get grid data. Note the base_url var which is come from view file part1/index.php

```



