<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller {
    public function index() {
        $notifications = Notification::with(['targetUser', 'targetRole'])->paginate(15);
        return view('notifications.index', compact('notifications'));
    }

    public function create() {
        $users = \App\Models\User::all();
        $roles = \App\Models\UserRole::all();
        return view('notifications.create', compact('users', 'roles'));
    }

    // public function store(StoreNotificationRequest $request) {
    //     Notification::create($request->validated());
    //     return redirect()->route('notifications.index')->with('success', 'Notification created.');
    // }

    public function show(Notification $notification) {
        $notification->load(['targetUser', 'targetRole']);
        return view('notifications.show', compact('notification'));
    }

    public function edit(Notification $notification) {
        $users = \App\Models\User::all();
        $roles = \App\Models\UserRole::all();
        return view('notifications.edit', compact('notification', 'users', 'roles'));
    }

    // public function update(UpdateNotificationRequest $request, Notification $notification) {
    //     $notification->update($request->validated());
    //     return redirect()->route('notifications.index')->with('success', 'Notification updated.');
    // }

    public function destroy(Notification $notification) {
        $notification->delete();
        return redirect()->route('notifications.index')->with('success', 'Notification deleted.');
    }

    public function markAsRead(Notification $notification) {
        $notification->update(['is_read' => true, 'read_at' => now()]);
        return redirect()->route('notifications.index')->with('success', 'Notification marked as read.');
    }
}
