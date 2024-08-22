<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\AssignmentInterface;
use App\Contracts\Interfaces\TransactionInterface;
use App\Models\Assignment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class TransactionRepository extends BaseRepository implements TransactionInterface
{
    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    /**
     * Store a newly created resource in storage.
     * @param array $data
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->get();
    }

    /**
     * Store a newly created resource in storage.
     * @param array $data
     * @return mixed
     */
    public function getWhere(array $data): mixed
    {
        return $this->model->query()
        ->with(['user' => function ($query) {
            $query->with('profile');
        }])
        ->when(count($data) > 0, function ($query) use ($data){
            $reference = null;
            $merchant_ref = null;
            $method = null;
            $status = null;
            $user_id = null;
            try{ $reference = $data['reference']; } catch (\Throwable $th){ }
            try{ $merchant_ref = $data['merchant_ref']; } catch (\Throwable $th){ }
            try{ $method = $data['method']; } catch (\Throwable $th){ }
            try{ $status = $data['status']; } catch (\Throwable $th){ }
            try{ $user_id = $data['user_id']; } catch (\Throwable $th){ }

            if($reference) $query->where('reference',$reference);
            if($merchant_ref) $query->where('merchant_ref',$merchant_ref);
            if($method) $query->where('method',$method);
            if($status) $query->where('status',$status);
            if($user_id) $query->where('user_id',$user_id);
        })
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     * @param array $data
     * @return mixed
     */
    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()
            ->when(count($request->all()) > 0, function ($query) use ($request){
                if($request->reference) $query->where('reference',$request->reference);
                if($request->merchant_ref) $query->where('merchant_ref',$request->merchant_ref);
                if($request->method) $query->where('method',$request->method);
                if($request->status) $query->where('status',$request->status);
            })
            ->fastPaginate($pagination);
    }

    /**
     * Store a newly created resource in storage.
     * @param array $data
     * @return mixed
     */
    public function customPaginateV2(Request $request, int $pagination = 10, int $page = 1): mixed
    {
        return $this->model->query()
            ->when(count($request->all()) > 0, function ($query) use ($request){
                if($request->reference) $query->where('reference',$request->reference);
                if($request->merchant_ref) $query->where('merchant_ref',$request->merchant_ref);
                if($request->method) $query->where('method',$request->method);
                if($request->status) $query->where('status',$request->status);
                if($request->user_id) $query->where('user_id',$request->user_id);
            })
            ->paginate($pagination, ['*'], 'page', $page);
    }

    /**
     * Store a newly created resource in storage.
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }
}
