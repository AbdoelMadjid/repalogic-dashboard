<?php

namespace App\Traits;

trait HasNotification
{
    /**
     * Send SweetAlert notification.
     */
    public function notifySwal(string $message, string $title = 'Berhasil', string $icon = 'success')
    {
        session()->flash('notify_swal', [
            'title' => $title,
            'text' => $message,
            'icon' => $icon, // success, error, warning, info, question
        ]);
    }

    /**
     * Send Toast notification.
     */
    public function notifyToast(string $message, string $icon = 'success', string $position = 'top-end')
    {
        session()->flash('notify_toast', [
            'text' => $message,
            'icon' => $icon, // success, error, warning, info
            'position' => $position,
        ]);
    }

    /**
     * Helper for success notification (Default: SweetAlert).
     */
    public function notifySuccess(string $message, string $title = 'Berhasil', string $style = 'swal')
    {
        if ($style === 'toast') {
            $this->notifyToast($message, 'success');
        } else {
            $this->notifySwal($message, $title, 'success');
        }
    }

    /**
     * Helper for error notification.
     */
    public function notifyError(string $message, string $title = 'Gagal', string $style = 'swal')
    {
        if ($style === 'toast') {
            $this->notifyToast($message, 'error');
        } else {
            $this->notifySwal($message, $title, 'error');
        }
    }

    /**
     * Helper for warning notification.
     */
    public function notifyWarning(string $message, string $title = 'Peringatan', string $style = 'swal')
    {
        if ($style === 'toast') {
            $this->notifyToast($message, 'warning');
        } else {
            $this->notifySwal($message, $title, 'warning');
        }
    }

    /**
     * Helper for info notification.
     */
    public function notifyInfo(string $message, string $title = 'Informasi', string $style = 'swal')
    {
        if ($style === 'toast') {
            $this->notifyToast($message, 'info');
        } else {
            $this->notifySwal($message, $title, 'info');
        }
    }
}
