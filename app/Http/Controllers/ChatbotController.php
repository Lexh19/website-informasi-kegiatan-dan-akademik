<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        // Ambil history dari session
        $chatHistory = session()->get('chat_history', []);

        // Tambahkan prompt system jika belum ada
        if (empty($chatHistory)) {
            $chatHistory[] = [
                'role' => 'system',
                'content' => 'Kamu adalah chatbot SD Paliyan 4 dan tahu banyak tentang sekolah ini.'
            ];
        }

        // Tambahkan pesan user
        $chatHistory[] = [
            'role' => 'user',
            'content' => $request->input('content')
        ];

        // Kirim ke Deepseek API
        $res = Http::withToken('sk-ae260c44f3bf41b89ad5350ee7cb29e5')
            ->post('https://api.deepseek.com/chat/completions', [
                'model' => 'deepseek-chat',
                'messages' => $chatHistory,
                'stream' => false
            ]);

        $data = $res->json();

        $answer = $data['choices'][0]['message']['content'] ?? 'Maaf, tidak ada jawaban dari chatbot.';

        // Tambahkan jawaban chatbot ke riwayat
        $chatHistory[] = [
            'role' => 'assistant',
            'content' => $answer
        ];

        // Simpan ulang ke session
        session()->put('chat_history', $chatHistory);

        // Filter untuk dikirim ke frontend (tanpa sistem prompt kalau mau)
        $filteredHistory = collect($chatHistory)->filter(function ($item) {
            return in_array($item['role'], ['user', 'assistant']);
        })->values();

        return response()->json([
            'history' => $filteredHistory
        ]);
    }
}
