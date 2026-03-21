<?php

namespace Modules\TranslationManager\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\TranslationManager\Entities\TranslationSuggestion;

class TranslationSuggestionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $suggestion;
    public $submittedBy;

    public function __construct(TranslationSuggestion $suggestion)
    {
        $this->suggestion = $suggestion;
        $this->submittedBy = $suggestion->user->name ?? 'Unknown User';
    }

    public function build()
    {
        return $this->subject("Translation Suggestion: {$this->suggestion->file}.{$this->suggestion->key} ({$this->suggestion->locale})")
            ->view('translationmanager::emails.suggestion');
    }
}
