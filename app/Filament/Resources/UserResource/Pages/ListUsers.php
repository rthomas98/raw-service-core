<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Mail\TeamInvitationMail;
use App\Models\Invitation;
use App\Models\User;
use Filament\Actions;

use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Filament\Tables\Actions\Action;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('inviteUser')
                ->form([

                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(User::class, 'email')
                ])
                ->action(function ($data) {
                    $invitation = Invitation::create(['email' => $data['email']]);

                    Mail::to($invitation->email)->send(new TeamInvitationMail($invitation));

                    Notification::make()
                        ->title('User invited successfully!')
                        ->success()
                        ->send();
                }),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            // Resend invite action as a row action
            Action::make('resendInvite')
                ->label('Resend Invite')
                ->action(function (Invitation $record) {
                    Mail::to($record->email)->send(new TeamInvitationMail($record));

                    Notification::make()
                        ->title('Invitation resent successfully!')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->visible(fn (Invitation $record) => $record->status === 'pending'),
        ];
    }
}
