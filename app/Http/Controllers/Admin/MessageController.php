<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message): View
    {
        $message->markAsRead();
        return view('admin.messages.show', compact('message'));
    }

    public function toggleRead(ContactMessage $message): RedirectResponse
    {
        if ($message->read_at) {
            $message->markAsUnread();
            $status = 'Pesan ditandai belum dibaca.';
        } else {
            $message->markAsRead();
            $status = 'Pesan ditandai sudah dibaca.';
        }

        return back()->with('success', $status);
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
