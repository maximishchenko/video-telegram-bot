<?php


namespace App\Entity;


use App\Shared;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Crud
{
    public static $pageSizeKey = 'pageSize';

    public static function searchLike(Request $request, Builder $query, $attribute)
    {
        if (!empty($value = $request->get($attribute))) {
            return $query->where($attribute, 'like', '%' . $value . '%');
        }
        return null;
    }

    public static function searchEquals(Request $request, Builder $query, $attribute)
    {
        if (!empty($value = $request->get($attribute))) {
            return $query->where($attribute, $value);
        }
        return null;
    }

    public static function getPageSize(Request $request, Builder $query)
    {
        if (!empty($value = $request->get(static::$pageSizeKey)) && (is_numeric($value))) {
            return $query->paginate($value);
        } else {
            return $query->paginate(Shared::DEFAULT_PAGINATE);
        }
    }
}
