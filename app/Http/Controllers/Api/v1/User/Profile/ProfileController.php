<?php

namespace App\Http\Controllers\Api\v1\User\Profile;

// Laravel Imports
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Request Validation Imports
use App\Http\Requests\Api\V1\User\Profile\ProfileUpdateRequest;

// Model Imports 
use App\Models\User;

// JSON Resource Imports 
use App\Http\Resources\Api\v1\User\Profile\ProfileUpdateResource;

class ProfileController extends Controller
{
    public function update(ProfileUpdateRequest $request) 
    {
        $data = $request->validated();

        $image = $request->file('avatar')->store('', 'avatar');
        $imageUrl = Storage::url($image);

        $data['image_url'] = $imageUrl;
        
        User::where('id', auth()->id())->update([
            'NIK' => $data['NIK'],
            'phone_number' => $data['phone_number'],
            'image_path' => $data['image_url']
        ]);

        return new ProfileUpdateResource($data);
    }
}
