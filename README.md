# Documentation for FandomDB.com
## Developed by:
 Jordan Liebman,  
 Tiara Jarrett,  
 Ally Dolan,  
 Abdul Eldarrat

## Description of Application:
FandomDB.com was created to be a place for authors to create works and have them displayed on the world wide web. It is a content hosting site where authors create articles based on templates. FandomDB is a platform which allows fans to follow their specific topic of interest(s). A Fandom is defined as, the fans of a particular person, team, fictional series, etc., regarded collectively as a community or subculture. Three templates have been developed, the types are article template, video template, and image collection. Authors are able to create Fandoms or add to existing Fandoms to contribute content to topics of their choosing. Articles can be speculation or fan fiction within the genre or anything else the author would like to create in the body of the article. Videos can be posted in the video template with an accompanying text body below to supplement the video content, either a caption, a description, or anything else the user would like to include, this is very flexible to what the author would like to display with their video content. The image collection template is geared towards those hosting comics and albums on FandomDB however the author is free to fill out the template to their liking.

### This is a version without image or video availability implemented site wide.
##### As of 5/3/2018 Creating an article works on text posts only. Feel free to check out the final product May 9th 2018 at FandomDB.com

## Database Schema
### Article table discription
| Field       | Type         | Null | Key | Default      | Extra |
|-------------|--------------|------|-----|--------------|-------|
| fandom      | varchar(45)  | no   |     | Null         |       |
| type        | int(11)      | no   |     | Null         |       |
| discription | mediumtext   | yes  |     | Null         |       |
| title       | varchar(128) | no   |     | Null         |       |
| content     | longtext     | no   |     | Null         |       |
| authorID    | int(11)      | yes  |     | Null         |       |
| id          | int(11)      | no   | PRI |              | AI    |
| lastEdited  | timestamp    | no   |     | Current Time |       |
### Fandom table discription
| Field | Type         | Null | Key | Default | Extra |
|-------|--------------|------|-----|---------|-------|
| title | varchar(128) | yes  |     | Null    |       |
| id    | int(11)      | no   | PRI | Null    | AI    |

### User table discription
| Field        | Type          | Null | Key | Default | Extra |
|--------------|---------------|------|-----|---------|-------|
| userId       | int(11)       | no   | PRI | Null    | AI    |
| email        | varchar(320)  | yes  |     | Null    |       |
| firstName    | varchar(255)  | yes  |     | Null    |       |
| lastName     | varchar(255)  | yes  |     | Null    |       |
| birthday     | date          | yes  |     | Null    |       |
| passwordHash | varchar(255)  | yes  |     | Null    |       |
| about        | mediumtext    | yes  |     | Null    |       |
| twitter      | varchar(2083) | yes  |     | Null    |       |
| facebook     | varchar(2083) | yes  |     | Null    |       |
| tumblr       | varchar(2083) | yes  |     | Null    |       |
| instagram    | varchar(2083) | yes  |     | Null    |       |
| snapchat     | varchar(2083) | yes  |     | Null    |       |
| username     | varchar(128)  | no   |     | Null    |       |
## Entity Relationship Diagram
![ERD](https://i.imgur.com/xaytPtk.png)

## Proof of CRUD in code

#### Create  
On line 109 of 'signup.php' a query is executed. That query is defined on line 102 of the same file.
#### Read  
On line 26 of 'editProfle.php' a query is executed. That query is defined on line 24 of the same file.
#### Update  
On line 139 of 'editProfileService.php' a query is executed. That query is defined on line 135 of the same file.
#### Delete  
On line 7 of 'deleteService.php' a query is executed. That query is defined on line 6 of the same file.  

## Explaination of where CRUD is throughout
#### Create  
Create occurs in the signup code and also in the creation of an article.
#### Read  
Read occurs not only when looking at the information to edit the profile but also when you view the profile as a user without priveledges to edit. Read occurs in all of the following files.
* articles.php
* creators.php
* editProfile.php
* fandoms.php
* mainAnon.php
* userProfile.php
* viewArticle.php  
I chose the example above in the "Proof of CRUD in code" section because it was very clear and concise.

#### Update  
Update occurs only in the place referenced above in the "Proof of CRUD in code"
#### Delete  
Delete occurs only in the place referenced above in the "Proof of CRUD in code"
### Video
