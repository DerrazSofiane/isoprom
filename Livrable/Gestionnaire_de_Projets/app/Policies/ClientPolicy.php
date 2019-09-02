<?php

namespace App\Policies;

use App\User;
use App\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;
    /*autoriser toutes les actions à l'admin*/
        public function before($user, $ability){
          if ($user->Auth_hasRole('ADMIN')) {
              return true;
          }else {  return false; }
        }

        public function index(User $user)
        {
            //
        }
        public function create(User $user)
        {
            //
        }

    public function show(User $user, Client $client)
    {
        //
    }
    public function edit(User $user, Client $client)
    {
        //
    }

    public function delete(User $user, Client $client)
    {
        //
    }
}
