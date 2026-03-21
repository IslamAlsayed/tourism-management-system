<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; margin: 0; padding: 20px; background: #f4f7fa; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #3b82f6, #1d4ed8); padding: 24px; color: white; }
        .header h2 { margin: 0; font-size: 20px; }
        .header p { margin: 5px 0 0; opacity: 0.85; font-size: 14px; }
        .body { padding: 24px; }
        .field { margin-bottom: 16px; }
        .field-label { font-weight: 600; color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .field-value { color: #334155; font-size: 14px; padding: 10px 14px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; }
        .diff { display: flex; gap: 12px; margin-top: 16px; }
        .diff-old, .diff-new { flex: 1; padding: 12px; border-radius: 8px; }
        .diff-old { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
        .diff-new { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .footer { padding: 16px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: center; color: #94a3b8; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>🌐 {{ __('Translation Suggestion') }}</h2>
            <p>{{ __('A user has suggested a translation correction.') }}</p>
        </div>
        <div class="body">
            <div class="field">
                <div class="field-label">{{ __('Submitted By') }}</div>
                <div class="field-value">{{ $submittedBy }}</div>
            </div>
            <div class="field">
                <div class="field-label">{{ __('Language / File / Key') }}</div>
                <div class="field-value">
                    <strong>{{ strtoupper($suggestion->locale) }}</strong> →
                    {{ $suggestion->file }}.php →
                    <code>{{ $suggestion->key }}</code>
                </div>
            </div>
            <div class="diff">
                <div class="diff-old">
                    <div class="field-label" style="color: #b91c1c;">{{ __('Current Value') }}</div>
                    <div style="margin-top: 6px;">{{ $suggestion->current_value ?: __('(empty)') }}</div>
                </div>
                <div class="diff-new">
                    <div class="field-label" style="color: #15803d;">{{ __('Suggested Value') }}</div>
                    <div style="margin-top: 6px;">{{ $suggestion->suggested_value }}</div>
                </div>
            </div>
            @if($suggestion->reason)
                <div class="field" style="margin-top: 16px;">
                    <div class="field-label">{{ __('Reason') }}</div>
                    <div class="field-value">{{ $suggestion->reason }}</div>
                </div>
            @endif
        </div>
        <div class="footer">
            {{ __('Please review this suggestion in the Translation Manager dashboard.') }}
        </div>
    </div>
</body>
</html>
