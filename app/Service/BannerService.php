<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

class BannerService
{
    public function store($data) {
        try{
            DB::beginTransaction();

            $data['image'] = Storage::disk('public')->put('/images', $data['image']);

            $card = Banner::firstOrCreate($data);

            DB::commit();
        } catch(Exception $exception){
            DB::rollBack();
            Log::error('StoreBannerError: ' . $exception->getMessage());
            abort(500);
        }
    }

    public function update($data, $card) {
        try{
            DB::beginTransaction();

            if (isset($data['image'])){
                $data['image'] = Storage::disk('public')->put('/images', $data['image']);
            }
            $card->update($data);

            DB::commit();
        } catch(Exception $exception){
            DB::rollBack();
            Log::error('UpdateBannerError: ' . $exception->getMessage());
            abort(500);
        }
        return $card;
    }
}
