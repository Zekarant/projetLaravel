<?php
namespace App\Policies;
use App\Models\ { User, Cours };
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->admin) {
            return true;
        }
    }
    public function manage(User $user, Cours $cours)
    {
        return $user->id === $cours->user_id;
    }
}
