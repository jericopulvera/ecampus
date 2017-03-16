<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\User;
use Image;
use Storage;

class UploadController extends Controller
{

    public function store(Request $request)
    {
       // $this->validate($request, [
       //      'image' => 'image',
       //  ]);
       
       $img = substr($request->image, strpos($request->image, ",")+1);
       $image = base64_decode($img);

       Storage::disk('local')->put('/dist/images/avatars/'.auth()->user()->usn.'.jpg', $image);

       $path = asset('/dist/images/avatars/'.auth()->user()->usn.'.jpg');
       
       return $path;    
    }


}
