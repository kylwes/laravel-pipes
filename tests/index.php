<?php




class CreateUser
{
    public function execute($data)
    {
        return $data;
    }
}

class AssignRoleToUser
{
    public function execute($user, Role $role)
    {
        // $user->roles()->attach($role->id)

        return $user;
    }
}


class SendWelcomeEmail
{
    public function execute($user)
    {
        return $user;
    }
}

function pipe($data, $actions = null)
{
    $pipe = new Pipe($data);

    if ($actions) {
        return $pipe->through($actions);
    }

    return $pipe;
}

class Role
{

}

$data = [
    'name' => 'Kylian Wester'
];

$user = pipe($data)
    ->with(['role' => 1])
    ->through([
        CreateUser::class,
        AssignRoleToUser::class,
        SendWelcomeEmail::class,
        function ($user) {
            var_dump($user);
            return $user;
        }
    ]);

var_dump($user);





