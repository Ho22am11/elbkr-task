<?php 
namespace App\Services;

use App\Models\Campany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CampanyService
{
    public function store(Request $request)
    {
        $data = $request->only('name');

        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('images', 'public');
            $data['img'] = $path;
        }

        $cate = Campany::create($data);
        return $cate ;
    }


    public function update(Request $request,  $id )
    {
        $data = $request->only('name');

        $campany= Campany::find($id);

        if ($request->hasFile('img')) {
            if ($campany->img && Storage::disk('public')->exists($campany->img)) {
                Storage::disk('public')->delete($campany->img);
            }

            $path = $request->file('img')->store('images', 'public');
            $data['img'] = $path;
        }

        $campany->update($data);

        return $campany;
    }


    public function delete($id){
         $campany = campany::find($id);
        Storage::disk('public')->delete($campany->img);
        $campany->delete();
    }
}