<?php

namespace App\Policies;
use Auth;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

	public function showProfile(User $user,User $usertarget){
    return ($user->Auth_hasRole('ADMIN')||$user->Auth_hasRole('MANAGER'));
  }

    public function index(User $user){
      if(!Auth::guest()){
          return ($user->Auth_hasRole('ADMIN')||$user->Auth_hasRole('MANAGER'));
      }    
      return false;
    }

    public function create(User $user){
      if(!Auth::guest()){
        return ($user->Auth_hasRole('ADMIN')||$user->Auth_hasRole('MANAGER'));
      }    
      return false;
    }

  public function show(User $user, User $usertarget){/*profil authentifié*/

        return true;
  }

  public function edit(User $user, User $usertarget){
    return ($user->Auth_hasRole('ADMIN')||$user->Auth_hasRole('MANAGER'));
  }

  	public function editPassword(User $user){/*mot de passe oublié*/
       return ($user->guest());
    }

    public function update_avatar(User $user, User $usertarget)
  	{
            return true;

    }
    public function updatePassword(User $user, User $usertarget)
  	{
       return ($user->guest());
    }

    public function delete(User $user, User $usertarget)
    {
      return ($user->Auth_hasRole('ADMIN')||$user->Auth_hasRole('MANAGER'));
    }
}
