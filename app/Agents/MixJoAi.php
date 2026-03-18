<?php

namespace App\Agents;

use LarAgent\Agent;

class MixJoAi extends Agent
{
    protected $provider = 'groq';
    protected $model = 'llama-3.3-70b-versatile'; 
    protected $instructions = 'You are an expert AI assistant for a tourism management system called MixJo2025. Be helpful, concise, and professional.';
}
