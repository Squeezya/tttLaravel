<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function getOwnerNameAttribute(){
    	$user = User::findOrFail($this->ownerUserID);
    	return $user->name;
    }
}
