<script src="{{ asset('assets/js/vendors.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>

@auth
    <script>
        window.UserAudioConfig = {
            chatSound: "{{ auth()->user()->getSetting('chat.sound_alert', 'pop') }}",
            soundChime: {{ auth()->user()->getSetting('notifications.sound_chime', true) ? 'true' : 'false' }},
            browserPush: {{ auth()->user()->getSetting('notifications.browser_push', true) ? 'true' : 'false' }}
        };
    </script>
@endauth

<!-- Web Push Notification & Service Worker Manager -->
<script src="{{ asset('assets/js/web-push-manager.js') }}"></script>

@yield('scripts')
