<?php

namespace App\Http\Controllers;

use App\Models\BusinessComment;
use App\Models\CustomerNotificationPermission;
use App\Models\District;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function updateFeatured(Request $request)
    {
        $query = $request->model::find($request->id);
        $query->{$request->column} = $request->value;

        if ($query->save()) {
            return [
                'status' => 'success',
                'message' => 'Durum güncellendi'
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Sistemde oluşan bir hata nedeniyle işleminiz yapılamadı !'
        ];
    }

    public function deleteFeatured(Request $request)
    {
        $query = $request->model::find($request->id);

        if ($query){
            $query->delete();
            return response()->json([
                'status' => 'success',
                'message' => $request->input('title'). " Kaydı Silindi"
            ]);
        }
        else{
            return response()->json([
                'status' => 'warning',
                'message' => 'Bir Hata Sebebiyle '. $request->input('content'). "Silinemedi"
            ]);
        }
    }

    public function deleteAllFeatured(Request $request)
    {
        foreach ($request->ids as $id){
            $query = $request->model::find($id);
            if ($query){
                $query->delete();

            }
        }

        return response()->json([
            'status' => 'success',
            'message' => $request->input('title'). " Kaydı Silindi"
        ]);

    }

    public function getDistrict(Request $request)
    {
        $districts = District::where('city_id', $request->id)->get();

        return $districts;
    }

}