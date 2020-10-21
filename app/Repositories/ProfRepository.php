<?php
namespace App\Repositories;
use App\Models\Prof;
class ProfRepository extends BaseRepository
{
    public function __construct(Prof $prof)
    {
        $this->model = $prof;
    }
    public function create($user, array $inputs)
    {
        $user->profs()->create($inputs);
    }

    public function getAlbumsWithImages($user)
    {
        return $user->profs()->with('cours')->get();
    }
}
