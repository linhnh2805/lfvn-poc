<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Residence;
use App\Models\ResidenceImage;
use App\Models\Personal;

class Step8Controller extends Controller {

  function uploadResidenceImage(Request $request) {
    
    $reserveId = $request->input('reserve_id');
    $order = $request->input('order');
    $file = $request->file('image');

    $personal = Personal::where('reserve_id', $reserveId)->first();
    $path = $reserveId .'_' . $order . '.png';
    $file->storeAs('public/residence_images/', $path);

    $residenceImage = new ResidenceImage();
    $residenceImage->personal_id = $personal->id;
    $residenceImage->order = $order;
    $residenceImage->file_name = $path;
    $residenceImage->save();
    
    return response()->json([
      'code' => 'OK'
    ]);
  }

  function uploadResidenceImages(Request $request) {

    $reserveId = $request->input('reserve_id');
    $files = $request->file('images');

    $personal = Personal::where('reserve_id', $reserveId)->first();

    foreach ($request->images as $idx=>$file) {
      $path = $reserveId .'_' . $idx . '.png';
      $file->storeAs('public/residence_images/', $path);
      $residenceImage = new ResidenceImage();
      $residenceImage->personal_id = $personal->id;
      $residenceImage->order = $idx;
      $residenceImage->file_name = $path;
      $residenceImage->save();
    }

    return response()->json([
      'code' => 'OK'
    ]);
  }

  function loanProcess(Request $request) {
    
    return response()->json([
      'code' => 'OK'
    ]);
  }
}