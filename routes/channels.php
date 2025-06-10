<?php

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;



Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});




Broadcast::channel('user-chat.{id}', function ($user, $id) {
    return $user instanceof User && (int) $user->id === (int) $id;
});

Broadcast::channel('admin-chat.{id}', function ($user, $id) {
    return $user instanceof Admin && (int) $user->id === (int) $id;
});
