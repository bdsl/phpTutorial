{% block title%}Getting PHP{% endblock %}

{% block body%}

If you just want to run a PHP one-liner, or experiment with a tiny throwaway PHP script, the easiest way is probably
online at [3v4l](https://3v4l.org/), but to work through this tutorial you should have PHP installed on your computer.

### Installation

First check if you already have PHP installed. Open your command-line prompt, and type `php --v`. If you have PHP, you
should see something like:

```
PHP 7.4.2 (cli) (built: Jan 23 2020 11:21:30) ( NTS )
Copyright (c) The PHP Group
Zend Engine v3.4.0, Copyright (c) Zend Technologies
    with Zend OPcache v7.4.2, Copyright (c), by Zend Technologies
```

Check the version number - ideally it should be **7.4.x** but at minimum to follow this tutorial it needs to be at least
**7.2**.

Very few people download PHP directly from php.net. If you work with PHP developers you may want to check where
they install their PHP packages from and do the same. Installation methods vary with your operating system:

### Linux

On Linux, use your package manager to install PHP, e.g. with the `sudo apt install php` command on Ubuntu or Debian, and
`sudo dnf -y install php-cli` on Fedora. However these may not give you a recent enough version of PHP. You can get
more up to date packages for Ubuntu from [Ondřej Surý](https://launchpad.net/~ondrej/+archive/ubuntu/php) for Ubuntu or
from [Remi's RPM Repository](https://rpms.remirepo.net/wizard/) for Red Hat, CentOs and Fedora.

### Macintosh

Apple supplies PHP as part of OS X, but this is 7.1, and you need at least 7.2. The best way to get that is probably
through **Homebrew**. If you don't have it, first install the Homebrew package manager by following the instructions at
[brew.sh](https://brew.sh/), and then enter the command `brew install php && brew link php`.

### Windows

I personally don't have a Windows machine, but I think the easiest way to set up PHP on Windows may be as part of the
**XAMPP** package. Download and run [the installer from Apache Friends](https://www.apachefriends.org/index.html). This
package bundles PHP along with the Apache web server, MariaDB database server, and the perl language. Xampp is also available
for Linux and Macintosh.

Run `php -v` again. Hopefully you will now have version **7.2 or later**.
{% endblock %}