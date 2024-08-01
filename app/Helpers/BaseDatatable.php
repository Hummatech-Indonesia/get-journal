<?php 


namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class BaseDatatable {
    
    private $data;

    public function __construct(mixed $data){
        $this->data = $data;
    }

    public static function Table(mixed $data): JsonResponse
    {
        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->make(true);
    }   

    public static function TableV2(array $data): JsonResponse
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }    
}