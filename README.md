# easyblog

easyblog is a simple almost-single file CMS that allows you to quickly get a blog up and running with minimal effort.

## how to use

copy the files in this repostiory into a directory with PHP and apache (most free PHP hosting providers will give you this) and you now have a blog! :D

you will also need to rename `visible-htaccess` to `.htaccess`.

Feel free to edit the settings at the top of `index.php` for more customization.

## how to write something

put a file in the `posts/` in the format YYYY-MM-DD-<title of the post>.txt

ie, `2015-07-01-Happy Birthday Canada.txt`

you can use markdown in these posts. it will be parsed and shown.

## theming

either edit style.css, or create your own file and include it in the php file.

## credits

portions of this repository (ie, Parsedown.php) contain code from [Parsedown](https://github.com/erusev/parsedown), which is copyright Emanuil Rusev, erusev.com.

