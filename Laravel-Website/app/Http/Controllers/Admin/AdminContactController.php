<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('admin.contact.view');

        $status = $request->string('status')->trim()->value();

        $query = ContactMessage::query();

        if (in_array($status, ['read', 'unread'], true)) {
            $query->where('is_read', $status === 'read');
        }

        $messages = $query->orderByDesc('id')->paginate(25)->withQueryString();

        return view('admin.contact.index', [
            'messages' => $messages,
            'status' => $status,
        ]);
    }

    public function show(Request $request, ContactMessage $contactMessage)
    {
        $this->authorize('admin.contact.view');

        if (! $contactMessage->is_read) {
            $contactMessage->markAsRead();
        }

        return view('admin.contact.show', [
            'message' => $contactMessage,
        ]);
    }
}
