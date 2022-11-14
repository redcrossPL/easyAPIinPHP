**This is easy REST API write in php which returns, whether we have logged in or registered in JSON format**

To test this project or use it you must:

1. Import database.db from project to your phpmyadmin panel.
2. Enable mysql or mariadb and apache (I suggest XAMPP).
3. If you use XAMPP move the project folder to the htdocs.
4. Go to site http://localhost/easyAPIinPHP/login.php?login_user=
You have received a message that you have not logged in. It is because the database is empty and you have not provided login details.

Register on this site:

1. To register go to site: http://localhost/easyAPIinPHP/register.php?reg_user=
2. To register, we need to provide a few attributes: 
- username
- email
- password_1
- password_2 (this is confirmation on password_1, it must be the same)
3. We can do it in the postman application or by writing to the link:
  http://localhost/easyAPIinPHP/register.php?reg_user=&username=redcross&email=example@example.com&password_1=123&password_2=123
4. We have successfully registered the user and created a record in the table in the database

Login on this site:

1. To register, we must provide the data that exists in the database
2. When logging in, we use only 2 attributes:
- username
- password
3. We can do it in the postman application or write attributes in the link as before:
  http://localhost/easyAPIinPHP/login.php?login_user&username=redcross&password=123
4. After entering the correct data existing in the database, we logged in.

ENJOY!!!
