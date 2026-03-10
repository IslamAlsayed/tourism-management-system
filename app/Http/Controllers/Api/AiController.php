<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{

    public function correctByGemini(Request $request)
    {
        $response = Http::post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . env('GEMINI_API_KEY'),
            [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => "You are a spelling and grammar corrector. Correct ONLY spelling and grammar mistakes. Do NOT explain. Do NOT rephrase. Return ONLY the corrected text. Text: {$request->text}"
                            ]
                        ]
                    ]
                ]
            ]
        );

        $corrected = trim($response['candidates'][0]['content']['parts'][0]['text'] ?? $request->text);

        return response()->json(['corrected' => $corrected]);
    }

    public function correctByLanguageTool(Request $request)
    {
        $text = $request->text;

        $response = Http::asForm()->post('https://api.languagetool.org/v2/check', [
            'text' => $text,
            'language' => 'en',
        ]);

        $data = $response->json();

        $corrected = $text;

        if (!empty($data['matches'])) {
            foreach (array_reverse($data['matches']) as $match) {
                if (!empty($match['replacements'])) {
                    $replacement = $match['replacements'][0]['value'];
                    $corrected = substr($corrected, 0, $match['offset'])
                        . $replacement
                        . substr($corrected, $match['offset'] + $match['length']);
                }
            }
        }

        return response()->json(['corrected' => $corrected]);
    }
    public function correctByGpt(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => "Correct spelling and grammar ONLY, do not rephrase: {$request->text}"
                        ]
                    ],
                    'temperature' => 0
                ]);

        $corrected = $response->json()['choices'][0]['message']['content'] ?? $request->text;

        return response()->json(['corrected' => $corrected]);
    }


    // @push('scripts')
//     <script>
//         document.addEventListener("trix-blur", async function(e) {
//             const editor = e.target;
//             const text = editor.editor.getDocument().toString();
//             if (!text.trim()) return;

    //             const response = await fetch("/api/ai/correct-text", {
//                 method: "POST",
//                 headers: {
//                     "Content-Type": "application/json",
//                     "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
//                 },
//                 body: JSON.stringify({
//                     text
//                 })
//             });

    //             const data = await response.json();
//             editor.editor.loadHTML(data.corrected);
//         });
//     </script>
// @endpush

}
