# transfer-free

How to setup:
- Clone this project from Github.
- git init flow in project folder.
- copy config.example.php to config.php in config folder.
- setup your database config in config.php
- run  migration with this command:
    > php -r "include 'core/migration.php'; migration::up();" = for running migrate table.
    > php -r "include 'core/migration.php'; migration::down();" = for undo migration have been migrated.
    > you can running migration for spesifik file, you just fill the filename in function down() or up(), example;
        +  php -r "include 'core/migration.php'; migration::up(migration_create_a_table);"
- run project: php -S localhost:8000
- and you can hit this project with postman.