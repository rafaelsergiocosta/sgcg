<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Model\User;

class GamificationController
{
    public function setScore($type, $user)
    {
        $gameScore = $this->db->table('gamification_scores')->where('gameType', $type)->first();
        if (!empty($gameScore->score)) {
            $userScore = $user->score + $gameScore->score;
            $this->db->table('users')->where('id', $user->id)->update(['score' => $userScore]);
            return $gameScore->score;
        } else {
            return false;
        }
    }
}