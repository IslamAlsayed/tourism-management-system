<?php

namespace App\Livewire;

use Livewire\Component;
use LarAgent\Agent;
use Illuminate\Support\Facades\Log;

class AiAgentChat extends Component
{
    public $messages = [];
    public $newMessage = '';
    public $isLoading = false;

    public function mount()
    {
        $session_id = session()->getId();
        $user_id = auth()->id();

        // Load existing messages
        $query = \App\Models\AiChatMessage::query();
        if ($user_id) {
            $query->where('user_id', $user_id);
        } else {
            $query->where('session_id', $session_id);
        }
        
        $history = $query->orderBy('created_at', 'asc')->get();

        if ($history->isEmpty()) {
            $this->messages = [
                [
                    'role' => 'assistant', 
                    'content' => 'Hello! I am your MixJo travel assistant. How can I help you manage your tourism data today?'
                ]
            ];
        } else {
            foreach ($history as $msg) {
                $this->messages[] = [
                    'role' => $msg->role,
                    'content' => $msg->content
                ];
            }
        }
    }

    public function sendMessage()
    {
        // Validate message
        $this->validate([
            'newMessage' => 'required|string|min:1|max:2000',
        ]);

        $session_id = session()->getId();
        $user_id = auth()->id();
        $prompt = trim($this->newMessage);

        // Add user message to UI immediately
        $this->messages[] = ['role' => 'user', 'content' => $prompt];
        $this->newMessage = '';
        $this->isLoading = true;

        // Save User Message to DB
        \App\Models\AiChatMessage::create([
            'user_id' => $user_id,
            'session_id' => $session_id,
            'role' => 'user',
            'content' => $prompt,
        ]);

        try {
            // Process with LarAgent using our custom MixJoAi agent
            $agent = \App\Agents\MixJoAi::make('mixjo-chat-' . $session_id); 
            $agent->withModel('llama-3.3-70b-versatile'); 
            $agent->withInstructions('You are an expert AI assistant for a tourism management system called MixJo2025. Be helpful, concise, and professional.');
            
            // Reconstruct chat history for the agent
            foreach ($this->messages as $msg) {
                if ($msg['role'] === 'user' && $msg['content'] !== $prompt) {
                    $agent->withMessage($msg['content']);
                }
            }

            // Generate response
            $responseContent = $agent->chat($prompt);
            
            // Add Assistant message to UI
            $this->messages[] = ['role' => 'assistant', 'content' => $responseContent];

            // Save Assistant Message to DB
            \App\Models\AiChatMessage::create([
                'user_id' => $user_id,
                'session_id' => $session_id,
                'role' => 'assistant',
                'content' => $responseContent,
            ]);

        } catch (\Exception $e) {
            Log::error('LarAgent Error: ' . $e->getMessage());
            $this->messages[] = [
                'role' => 'assistant', 
                'content' => 'Sorry, I encountered an error connecting to the AI service. Please check your API keys or try again later.'
            ];
        }

        $this->isLoading = false;
        $this->dispatch('messageAdded');
    }

    public function render()
    {
        return view('livewire.ai-agent-chat');
    }
}
