<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\Contract\UsuariosIRepository;

class UsuariosRepository  implements UsuariosIRepository{

    public function getAllUsers(){
        return User::all();
    }

    public function getUserById($id){
        return User::find($id);
    }
}