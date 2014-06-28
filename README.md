RentalMgr
=======================

Introduction
------------
This is a project I'm using just to educate myself on zend framework 2.



Getting A Copy of the Project
-----------------------------
The recommended way to get a working copy of this project is to clone the repository
and use `composer` to install dependencies. Clone the repository and manually invoke
`composer` using the shipped `composer.phar`:

    cd my/project/dir
    git clone git@github.com:kkucera/rentalmgr.git
    cd rentalmgr
    php composer.phar self-update
    php composer.phar install

(The `self-update` directive is to ensure you have an up-to-date `composer.phar`
available.)



Database Setup
---------------
This project has been setup to work with a MySQL database. So you will need to have MySQL setup and listening
on a proper configured address and port.

You must manually create the database first. Right now it's setup to connect to a database call: rentalmgr.
Create the database through MySQL interface then continue.

Database - The database interface is through Doctrine.  The following commands can be run from the project base
directory to initialize the database.

$ ./vendor/bin/doctrine-module orm:schema-tool:drop
$ ./vendor/bin/doctrine-module orm:schema-tool:create

If you just want to update the schema run this
$ ./vendor/bin/doctrine-module orm:schema-tool:update --force


Initialize the resources
php public/index.php acl register resources
