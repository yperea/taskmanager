# Task Manager Web Application

### A RESTful implementation

This is a simple PHP Web application that uses a user interface built on Bootstrap and connects to a RESTful service to create, update, delete and list all your personal tasks. Also, it shows statistics of your interaction with the system. 

### Project Technologies/Techniques
* Technology:
    * PHP 7.2
* Security/Authentication
    * Basic Authentication, based on a user/password (encrypted) model database.
    * Signed role: create/read/update/delete (crud) and lists their own tasks.
    * All: anyone can sign up and only view index pages (no login).
* Database
    * MySQL 5.7.
    * PDO (PHP Data Objects).
    * Store users and tasks information.
* Web Services
    * Use Composer and Guzzle to interact with application web services.
* CSS
    * Bootstrap 4
* Data Validation
    * Bootstrap Validator for front end
* IDE: IntelliJ IDEA

### Prerequisistes
You need to run this application on Apache Server.
This application implements a kind of MVC pattern and a Router which requires you override some configuration files on your APACHE/Linux server. 

1.Enable Apache mode rewrite

```sudo a2enmod rewrite```

2.Restart apache

```sudo service apache2 restart```

3.Override apache configuration settings

```sudo nano /etc/apache2/apache2.conf```

4.Change AllowOverride None for AllowOverride All

```
<Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
</Directory>
```
5.Restart apache


