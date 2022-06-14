![Screenshot 2022-06-13 161224](https://user-images.githubusercontent.com/77008074/173373322-ba866e8b-1fdf-49be-b0aa-e7b65b3e9c83.png)


# Introduction
LABDESK.API is a bidirectional application interface to exchange data between labdesk and external applications.

# Requirements
This web api requires an apache server, php and ms-sql server driver.

# Licence
LABDESK LIMS and its components are proprietary software. Further information is available at: https://labdesk.net/licence/

# Material Endpoint
The material endpoint is used to create, read, update and delete records. The http request has the following parameters:

**Connection related:**<br>
*token* - need to be created as a record in table *api* in the labdesk database in order to authenticate access<br>
*api* - this is the endpoint, e.g. *material*<br>
*action* - ref. CRUD<br>

**Create releated**<br>
*title* - title of the material<br>
*sap_matno* - SAP material no<br>
*sap_blocked* - Can be 0 (available) and 1 (blocked)<br>
*sap_additional* - Addition information provided (e.g. storage position and amount)<br>

**Read releated**<br>
*sap_matno* - SAP material no<br>

**Update releated**<br>
*id* - primary key of the material<br>
*title* - title of the material<br>
*sap_matno* - SAP material no<br>
*sap_blocked* - Can be 0 (available) and 1 (blocked)<br>
*sap_additional* - Addition information provided (e.g. storage position and amount)<br>

**Read releated**<br>
*id* - primary key of the material

## Example
http://server.com/?token=123&api=material&action=c&title=ethanol&sap_matno=123&sap_blocked=0&sap_additonal=Shelf 112 Pith 14
