<?php
namespace App\Policies;
use App\Models\ { User, Prof };
use Illuminate\Auth\Access\HandlesAuthorization;
class ProfPolicy
{
    use HandlesAuthorization;
    public function before(User $user)
    {
        if ($user->admin) {
            return true;
        }
    }
    public function manage(User $user)
    {
        return $user->admin;
    }
}
