<?php


namespace App\Repository;


use App\Entities\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepositories
{
    /**
     * @return User
     */
    public function getModel(): User
    {
        return new User();
    }

    /**
     * @param $request
     * @return LengthAwarePaginator
     */
    public function getUserIndex($request): LengthAwarePaginator
    {
        return $this->getModel()
            ->userInfo($request->input('search'))
            ->paginate();
    }
}
