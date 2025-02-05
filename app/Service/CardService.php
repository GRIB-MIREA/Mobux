<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;
use App\Models\Card;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

class CardService
{
    public function store($data) {
        try{
            DB::beginTransaction();

            $stampIds = $data['stamp_ids'] ?? [];
            unset($data['stamp_ids']);

            if(!isset($data['image'])){
                return redirect()->route('admin.card.create')->withErrors(['image' => 'Необходимо установить изображение.'])->withInput();
            }
            
            $data['image'] = Storage::disk('public')->put('/images', $data['image']);

            $card = Card::firstOrCreate($data);
            if (!empty($stampIds)) {
                $card->stamps()->attach($stampIds);
            }

            DB::commit();
        } catch(Exception $exception){
            DB::rollBack();
            Log::error('StoreCardError: ' . $exception->getMessage());
            abort(500);
        }
    }

    public function update($data, $card) {
        try{
            DB::beginTransaction();

            $stampIds = $data['stamp_ids'] ?? [];
            unset($data['stamp_ids']);

            if (isset($data['image'])){
                $data['image'] = Storage::disk('public')->put('/images', $data['image']);
            }
            $card->update($data);

            if (empty($stampIds)) {
                $card->stamps()->detach(); // Удаляем все связанные записи
            } else {
                $card->stamps()->sync($stampIds); // Синхронизируем с новыми идентификаторами
            }

            DB::commit();
        } catch(Exception $exception){
            DB::rollBack();
            Log::error('UpdateCardError: ' . $exception->getMessage());
            abort(500);
        }
        return $card;
    }
}
