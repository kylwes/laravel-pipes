# Laravel pipes

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kylwes/laravel-pipes.svg?style=flat-square)](https://packagist.org/packages/kylwes/laravel-pipes)
[![Total Downloads](https://img.shields.io/packagist/dt/kylwes/laravel-pipes.svg?style=flat-square)](https://packagist.org/packages/kylwes/laravel-pipes)


Laravel Pipes is a PHP library that allows you to easily chain and execute multiple actions on a single data object. It is inspired by the Unix pipe concept, where the output of one command can be used as the input to another command.

```php
$user = $createUser->execute($request->validated());
$sendWelcomeEmail->execute($user);
```
you can write this:
```php
$user = pipe($request->validated(), [
    CreateUser::class,
    SendWelcomeEmail::class,
]);
```

## Installation

You can install the package via composer:

```bash
composer require kylwes/pipe
```

## Usage

You can create a pipe by use the `pipe` function:
```
$user = pipe($request->validated(), [
    CreateUser::class,
    SendWelcomeEmail::class,
]); // $user is an instance of App\Models\User
```

When one of your actions expects another parameter, you can use the `with` method:
```
// App\Actions\AssignRoleToUser.php
class AssignRoleToUser
{
    public function execute(User $user, $role)
    {
        $user->assignRole($role);
        
        return $user;
    }
}

// App\Http\Controllers\UserController.php
$user = pipe($request->validated())
    ->with(['role' => Role::find(1)])
    ->through([
        CreateUser::class,
        AssignRoleToUser::class,
        SendWelcomeEmail::class,
    ]); // $user is an instance of App\Models\User
```

You can also use pass anonymous functions:
```
$user = pipe($data, [
    CreateUser::class,
    function ($user) {
        $user->assignRole(Role::find(1));
        
        return $user;
    },
    SendWelcomeEmail::class,
]); // $user is an instance of App\Models\User
```
or call a function:
```
$title = pipe('  My awesome title   ', [
    'trim',
    'strtoupper',
]); // $title is 'MY AWESOME TITLE'
```




### Testing

``` bash
composer test
```

### Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing
Contributions are welcome! If you find a bug or have a feature request, please open an issue on GitHub. If you would like to contribute code, please fork the repository and submit a pull request.

## Credits
- [Kylian Wester](https://github.com/kylwes)

## License
Laravel Pipes is licensed under the MIT license. See the LICENSE file for details.
