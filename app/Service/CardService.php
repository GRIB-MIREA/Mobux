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

            $stampIds = $data['stamp_ids'];
            unset($data['stamp_ids']);

            $data['image'] = Storage::disk('public')->put('/images', $data['image']);

            $card = Card::firstOrCreate($data);
            $card->stamps()->attach($stampIds);

            DB::commit();
        } catch(Exception $exception){
            DB::rollBack();
            abort(500);
        }
    }

    public function update($data, $card) {
        try{
            DB::beginTransaction();

            $stampIds = $data['stamp_ids'];
            unset($data['stamp_ids']);

            if (isset($data['image'])){
                $data['image'] = Storage::disk('public')->put('/images', $data['image']);
            }
            $card->update($data);
            $card->stamps()->sync($stampIds);
            DB::commit();
        } catch(Exception $exception){
            DB::rollBack();
            abort(500);
        }
        return $card;
    }
}
