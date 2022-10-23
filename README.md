![Screenshot 2022-06-13 161224](https://user-images.githubusercontent.com/77008074/173373322-ba866e8b-1fdf-49be-b0aa-e7b65b3e9c83.png)


# Introduction
LABDESK.SAP is a bidirectional REST API to exchange data between LABDESK and SAP. Data can be fetched and written by http requests.

# Licence
LABDESK LIMS and its components are proprietary software. Further information is available at: https://labdesk.net/licence/

# The Skeleton
The project structure of the API is implemented as follows:

<pre>
├── Controller
│   └── Api
│       ├── BaseController.php
│       └── UserController.php
├── inc
│   ├── bootstrap.php
│   └── config.php
├── index.php
└── Model
    ├── Database.php
    └── UserModel.php
</pre>

- **index.php**: the entry-point of the application. It will act as a front-controller of the application.
- **inc/config.php**: holds the configuration information of the application. Mainly, it will hold the database credentials.
- **inc/bootstrap.php**: used to bootstrap the application by including the necessary files.
- **Model/Database.php**: the database access layer which will be used to interact with the underlying database.
- **Model/UserModel.php**: the User model file which implements the necessary methods to interact with the users table in the database.
- **Controller/Api/BaseController.php**: a base controller file which holds common utility methods.
- **Controller/Api/UserController.php**: the **user** controller file which holds the necessary application code to entertain REST API calls.

# Calling the REST API
## List records
The endpoint of the API for listing table records looks like this: <br/>
**structure**: https://localhost/index.php/{MODULE_NAME}/{METHOD_NAME}?limit={LIMIT_VALUE} <br/>
**example**: http://localhost/index.php/material/list?limit=20
## Fetch record
## Write record
