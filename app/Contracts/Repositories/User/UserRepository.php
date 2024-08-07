<?php

namespace App\Contracts\Repositories\User;

use App\Contracts\Interfaces\User\UserInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Store a new user
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * Update user
     *
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function updatePassword(mixed $id, array $data): mixed
    {
        return $this->model->find($id)->update(['password' => bcrypt($data['new_password'])]);
    }

    /**
     * Update user
     *
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * Delete user
     *
     * @param mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->model->find($id)->delete();
    }

    /**
     * get detail user
     *
     * @param mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->find($id);
    }

    public function customQuery(Request $request): mixed
    {
        return $this->model->query()
        ->with(["profile", "roles"])
        ->selectRaw('
            users.*,
            IF(profiles.is_premium = 1 AND profiles.premium_expired_at > NOW(), true, false) AS user_premium,
            profiles.name
        ')
        ->leftJoin('profiles','users.id','=','profiles.user_id')
        ->when(count($request->all()) > 0, function ($query) use ($request){
            $count_role = 0;
            try{ 
                $count_role = count($request->role);
            }catch(\Throwable $th){
                $check_role = ['admin','teacher','school','student'];
                if(in_array($request->role, $check_role)){
                    $request->merge(["role" => [$request->role]]);
                    $count_role = 1;
                }
            }
            
            if($count_role > 0){
                $query->whereHas("roles", function($q) use ($request) {
                    $q->whereIn("name", $request->role);
                });
            }
        });
    }

    public function getWhere(array $data): mixed
    {
        return $this->model->query()
        ->when(count($data) > 0, function ($query) use ($data){
            foreach($data as $index => $value){
                $query->where($index, $value);
            }
        })        
        ->first();
    } 
}
