# HTTP

PHP is of course mostly used in web servers, so you might be wondering why we started with a command line script.

In fact you can access the same script through your web browser. PHP comes with a built-in web server for development
and testing uses. To start it, run:

```shell script
php -S localhost:8080
```
Point your browser at [http://localhost:8080/hello.php](http://localhost:8080/hello.php), and you should see 
"Hello, world.".

Go back to your command line and press ctrl-c to shut down the server.