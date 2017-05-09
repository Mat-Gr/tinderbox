# Tinderbox Volunteer Web App
This is a studen project, made in colaboration with the Tinderbox music festival.
The purpose of this project, was to create a web app to manage the volunteers working for the festival.

A demo of this project can be [seen here.](http://opbwu16eintg8.my.eal.dk/)
(Make sure to view it in a mobile device size, as it is designed as such.)
## Backend
The API for this project was created using the Codeigniter php framework, and a mySQL database.
It partially follows the RESTful style of WEB API's, using HTTP as it's protocol, and JSON as the format for data transfer.
### Overview of the API
Requests to the API can be made at the following URL, with an appended endpoint: **opbwu16eintg8.my.eal.dk/app**

Endpoint | Accepted HTTP method | Requires Authenthication | Functionality |
--- | --- | --- | ---
`/schedule` | GET | Yes | returns the users upcoming schedule
`/announcements` | GET | No | returns the latest announcements
`/userinfo` | GET | Yes | returns user information
`/signup` | POST | No | creates new user (requires data input)
`/edit_user` | PUT | Yes | edits user info (requires data input)
`/delete_user` | DELETE | Yes | deletes user

## Frontend
The frontend was developed mainly with jQuery for functionality and SASS for styling.
The web app also uses a web app manifest best on [google's guidelines](https://developers.google.com/web/fundamentals/engage-and-retain/web-app-manifest/), to allow the app to be added to the homescreen on mobile devices, and generally create a more native-app feel.
This has also been achived by using AJAX, which allowed for loading page content without browser refresh.
Here are a few screenshots of the finnished product:

![login screen][lg]   ![schedule screen][sch]   ![announcements screen][ann]

[lg]: https://cloud.githubusercontent.com/assets/22744066/25851715/23e64030-34c7-11e7-84de-ab1bf7c64b92.png "Login Screen"
[sch]: https://cloud.githubusercontent.com/assets/22744066/25851748/426a12e8-34c7-11e7-9498-1688a5ee856e.png "Schedule Screen"
[ann]: https://cloud.githubusercontent.com/assets/22744066/25851763/4d61706a-34c7-11e7-878b-b98b6e2d536f.png "Announcements Screen"
