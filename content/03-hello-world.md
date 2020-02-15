# Hello, world.

At this point we're ready to start writing in PHP. Make a new folder for your PHP scripts.

If you have a favourite text editor or integrated development environment, such as vim, atom, or vs-code you may want to
stick with that, but the best tool for editing PHP code is almost certainly JetBrains'
[PhpStorm](https://www.jetbrains.com/phpstorm/). PhpStorm is free for 30 days, but will demand money after that.

Make a new file called `hello.php`, and type in the following:

```php
<?php declare(strict_types=1);

echo "Hello, world.\n";
```

Save the file, and go to your command line. Navigate to your PHP scripts folder, and run your first PHP program by 
typing `php hello.php`. You should see:

```shell script
$ php hello.php
Hello, world
$
```

Every PHP file should start with `<?php declare(strict_types=1);` . This tells the PHP interpreter that you're writing
PHP, and `strict_types` tells PHP not to try to be guess what you mean so much. Historically PHP has tended to be very
loose, and prefer make the best guess of what's required if it isn't clear instead of giving up. That's probably good
for writing a website one page at a time, but for applications we need the computer to stop and tell us what's wrong
if we make a mistake, not plough ahead and give us a wrong result.

`echo` simply outputs strings of text. We could use `print`, which is quicker to say, but we prefer `echo`, which is
20% shorter to write.
