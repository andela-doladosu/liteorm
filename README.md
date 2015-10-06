#Potato ORM
Potato ORM is a lightweight ORM based on concepts
borrowed from the laravel framework


#Testing
 The phpunit framework for testing is used to perform
 unit test on the classes. The TDD principle has been
 employed to make the application robust

 Run this in your terminal to execute the tests
 ```````
 /vendor/bin/phpunit
`````````

#Install

- To install this package, PHP 5.5+ and Composer are required

``````
composer require dara/potato
``````

#usage

- Save a new record

````````
$user = new User();
$user->username = "drsumo";
$user->password = "ppkksdjs";
$user->email = "mail@mail.com";
$user->save();
`````````
- Find one record

``````
$user = User::find($id);
``````
- Find all records

``````
$allUsers = User::getAll();
``````
- Update an existing record

``````
$user = User::find($id);
$user->email = "newemail@mail.com";
$user->username = "rockefeller";
$user->save();
``````
- Delete an existing record 

````````
$delete = User::destroy($id):
````````




## Change log
Please check out [CHANGELOG](CHANGELOG.md) file for information on what has changed recently.

## Contributing
Please check out [CONTRIBUTING](CONTRIBUTING.md) file for detailed contribution guidelines.

## Credits
Potato-ORM is maintained by `Dara Oladosu`.

## License
Potato-ORM is released under the MIT Licence. See the bundled [LICENSE](LICENSE.md) file for more details.


