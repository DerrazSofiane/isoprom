<?php

namespace App\Policies;

use App\User;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;
    /*autorise toutes les actions du projet à l'administrateur et au gestionnaire, à l'exception de MyProjects (pour le gestionnaire de projet)*/

      public function index(User $user){

          return true;
      }

      public function create(User $user){
        if(!$user->Auth_hasRole('EMPLOYEE')){
          return true;
        }
          return false;
      }

      public function show(User $user, Project $project){

          return true;
      }

      public function ManagerProjets(User $user){
        if($user->Auth_hasRole('PROJECT_MANAGER')){
           return true;
        }
          return false;
      }

     public function edit(User $user){
       if($user->Auth_hasRole('EMPLOYEE')){
         return false;
       }
         return true;
     }

    public function delete(User $user, Project $project)
    {
      if($user->Auth_hasRole('EMPLOYEE')||$user->Auth_hasRole('PROJECT_MANAGER')){
        return false;
      }
       return true;
    }
}
