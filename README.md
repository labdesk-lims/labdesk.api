![LOGO](https://github.com/user-attachments/assets/8e0f3318-439c-4eb3-92f3-7dccbc1cdb97)


# Introduction
LABDESK.API is a bidirectional REST API to exchange data between LABDESK and external IT-Systems. Data can be fetched and written by http requests.

# Licence
LABDESK LIMS and its components are available as free software. Further information is available at: https://labdesk.net/licence/

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
## Security
For all endpoints basic authentication is applied. The following credentials can be used to access the rest-api:
- User: rest-api
- Pass: Q8JfsYH4jKllJ98s

The credentials named need to be added to your url request for all calls. <br/>
**example:**: https://rest-api:Q8JfsYH4jKllJ98s@demo.labdesk.net

## Materials
### List records
The endpoint of the API for listing table records looks like this: <br/>
**structure**: https://localhost/index.php/{MODULE_NAME}/{METHOD_NAME}?limit={LIMIT_VALUE} <br/>
**example**: http://localhost/index.php/material/list?limit=20
### Fetch record
To fetch a specific material the sap_matno of the material has to be used: <br/>
**example**: https://localhost/index.php/material/get?sap_matno=1
### Create/Update record
To create/update a record the following payload needs to be used: <br/>
**example**: curl -i -k -X POST -H "Content-Type:application/json" -d "{""sap_matno"":"123",""sap_blocked"":"0",""sap_additionals"":""text"",""sap_title"":""my_material""}" https://localhost/index.php/material/set
