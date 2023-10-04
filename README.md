# BlogZ

This is a blog website created in Laravel 


## Features
Normal website visitor :
- Can read all approved posts
- Can type comments and replay to comments
- Can contact with the adminstration

Logged in users :
- User can create new account
- User can publish new articles  
- User can type comments and replay to comments
- User can update his information

Admin :
- Admin can show, add, edit and delete users 
- Admin can show, add, edit and delete posts
- Admin can show, add, edit and delete categories
- Admin can show, add, edit and delete others admins
- Admin can show, add, edit and delete roles
- Admin can assign roles and permissions to other admins
- Admin can replay to messages sended by users
- Admin can edit information in fixed pages 
- Admin can update his information
- Admin can update website sittings
- Admin can comment, approve, disapprove and replay to comments

## Notes

- I use mailtrap to test emails so in `.env` file you must update `MAIL_USERNAME` and `MAIL_PASSWORD` to your mailtrap sittings to send emails to your account
- I used mail feature when user creates new account and when sends message to adminstration and when admin replays to his message
- I used `spatie Laravel-permission` package to achive permissions and roles for admins
- I used `redis` to save some informations which appear in multiple pages in cache 
- Database name is `blogz` and just type this command  `php artisan migrate:fresh --seed ` to create database tables with its initiate data like permissions and roles information and fake data for posts and comments
- All accounts have the same password `123`   

## 🔗 Links
[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/gibran-kashour-a073471b2/)


