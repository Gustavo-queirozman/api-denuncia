<?php

namespace App\Repository\Contract;

interface UsuariosIRepository {
    public function getUserById($id);
    public function getAllUsers();
}