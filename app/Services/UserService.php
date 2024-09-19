<?php

namespace App\Services;

use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Resources\DefaultResource;
use App\Mail\SendingEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function handleUpdateProfileWithPhoto(UpdateProfileRequest $request): array
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photo');
            if (!is_null(auth()->user()->photo)) {
                if (Storage::exists(auth()->user()->photo)) Storage::delete(auth()->user()->photo);
            }
        }

        return $data;
    }

    public function handleSendEmail(mixed $data, ?string $type = 'web')
    {
        $token = $this->generateCode(32);

        DB::table('password_resets')->create([
            "email" => $data?->email ?? "test@gmail.com",
            "token" => $token
        ]);

        $url = route('reset-password', ['token' => $token]);

        Mail::to($data?->email ?? "test@gmail.com")->send(new SendingEmail($data?->profile?->name ?? '', $url));

        if($type == 'web') return redirect()->route('login')->with('success', 'Berhasil mengirimkan email untuk reset password. Silahkan check di email anda!');
        else return (DefaultResource::make(['code' => 200, 'message' => 'Berhasil mengirimkan email untuk reset password. Silahkan check di email anda!']))->response()->setStatusCode(200);
    }

    private function generateCode($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
}
