{% block title%}HTTP{% endblock %}

{% block body%}
PHP is of course mostly used in web servers, so you might be wondering why we started with a command line script.

In fact you can access the same script through your web browser. PHP comes with a built-in web server for development
and testing uses. To start it, run:

```shell script
php -S localhost:8080
```
Point your browser at [http://localhost:8080/hello.php](http://localhost:8080/hello.php), and you should see
"Hello, world.".

Go back to your command line and press ctrl-c to shut down the server.

This tutorial treats PHP as a general purpose programming language - we won't focus on the specifics of running in a web
server. In a big web application only a small part of the code may need to deal with getting data in and out through
HTTP, and usually this will be abstracted away to some extent by a framework like Symfony or Laravel, or a CMS like
Wordpress or Drupal.
{% endblock %}