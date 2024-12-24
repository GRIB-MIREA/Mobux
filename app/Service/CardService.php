<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;
use App\Models\Card;
use Illuminate\Support\Facades\DB;
use Exception;

class CardService
{
    public function store($data) {
        try{
            DB::beginTransaction();
            $data['image'] = Storage::disk('public')->put('/images', $data['image']);

            Card::firstOrCreate($data);

            DB::commit();
        } catch(Exception $exception){
            DB::rollBack();
            abort(500);
        }
    }

    public function update($data, $portfolio) {
        try{
            DB::beginTransaction();
            if (isset($data['image'])){
                $data['image'] = Storage::disk('public')->put('/images', $data['image']);
            }
            $portfolio->update($data);
            DB::commit();
        } catch(Exception $exception){
            DB::rollBack();
            abort(500);
        }
        return $portfolio;
    }
}
