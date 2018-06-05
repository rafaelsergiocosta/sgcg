<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Model\GamificationScore;
use App\Model\User;

class GamificationController
{
    public static function setScore($type, User $user)
    {
        $gameScore = GamificationScore::where('gameType', $type)->first();
        if (!empty($gameScore->score) && is_object($user)) {
            $user->score += $gameScore->score;
            if($user->save()) {
                return $gameScore->score;
            }
        } 
        
        return false;
    }
}