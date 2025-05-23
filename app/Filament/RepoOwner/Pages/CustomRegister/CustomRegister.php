<?php

namespace App\Filament\RepoOwner\Pages\CustomRegister;

use App\Models\Repository;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;

class CustomRegister extends Login
{
    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('repository_name')
                ->label('Repository Name')
                ->required(),

            TextInput::make('repository_address')
                ->label('Repository Address')
                ->required(),

            TextInput::make('repository_phone')
                ->label('Repository Phone')
                ->required(),

            TextInput::make('name')
                ->label('Full Name')
                ->required(),

            TextInput::make('email')
                ->label('Email Address')
                ->email()
                ->required(),

            TextInput::make('phone_number')
                ->label('Phone Number')
                ->required(),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->required(),

            // Optional: Uncomment this to confirm password
            // TextInput::make('password_confirmation')
            //     ->label('Confirm Password')
            //     ->password()
            //     ->same('password')
            //     ->required(),
        ]);
    }

    public function authenticate(): LoginResponse
    {
        $data = $this->form->getState();

        // Step 1: Create the user
        $user = User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'phone_number' => $data['phone_number'],
            'password'     => Hash::make($data['password']),
        ]);

        // Step 2: Login the user
        Auth::login($user);

        // Step 3: Create the repository, setting owner_id correctly
        Repository::create([
            'repository_name'    => $data['repository_name'],
            'repository_phone'   => $data['repository_phone'],
            'repository_address' => $data['repository_address'],
            'owner_id'           => $user->id, // This is critical!
        ]);

        // Step 4: Return the login response
        return app(LoginResponse::class);
    }


    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email'    => $data['email'],
            'password' => $data['password'],
        ];
    }
}
