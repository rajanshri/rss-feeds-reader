rss-feeds-reader
================

RSS-Reader is like Google Reader, where logged in user can fetch the rss feeds of a website url which they have enterd and they can also download the pdf file of that rss feeds of the given website. This project is done in PHP5.

* Author: Rajan Shrivastava(rajanshri@gmail.com)
* Package: RSS-Reader
* Website: http://www.pixellanguage.com


Usage
------
```php
1) User must have to logged in the site
2) After login user can enter a website url, there is no rss url is required only webiste url have to enter.
3) Then the system fetch the rss feeds form that given url is it exist.
4) Last 10 rss feeds will be display in a slider.
5) There are a pdf download link for that rss feed under the silder. User can download that pdf file.
6) User search sites will be listed in left panel for future use same as Google Reader.
```

Required
----------
```php
* PHP5, Mysql
* Latest version of jQuery min file
* At first create a database and run the query which is in sql-query.txt file. Then change the config files variables as per your requiremnt in db_config.php and path_config.php under config folder.
```
