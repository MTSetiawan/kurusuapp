<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Teacher Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="navbar">
        <div class="nav-wrap container">
            {{-- Brand goes to public landing so teacher can preview --}}
            <a href="{{ route('landing') }}" class="brand">Teacher</a>

            <div style="display:flex;gap:10px;align-items:center">
                {{-- IMPORTANT: real button, not <a> --}}
                <button class="btn primary" type="button" id="openCreateListing">+ New Listing</button>
                @php
                    $user = auth()->guard('web')->user();
                    $profile = $user?->teacherProfile;

                    // Jika pakai disk 'public' + storage:link
                    $img =
                        $profile && $profile->profile_image_path
                            ? Storage::url($profile->profile_image_path)
                            : asset('images/default-avatar.png'); // siapkan fallback
                @endphp

                <a href="{{ route('teacher.profile.edit') }}">
                    <img src="{{ $img }}" alt="Foto Profil" width="36" height="36"
                        class="rounded-full object-cover h-10 w-10">
                </a>

            </div>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    {{-- ===== Create Listing Modal ===== --}}
    <div id="create-listing-modal" class="modal-backdrop" hidden aria-hidden="true">
        <div class="modal-scrim" data-close="create-listing-modal"></div>

        <div class="modal-card card pad" role="dialog" aria-modal="true" aria-labelledby="create-title">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                <h2 id="create-title" class="h2" style="margin:0">Buat Listing</h2>
                <button class="btn" type="button" data-close="create-listing-modal">Tutup</button>
            </div>

            <div id="create-listing-body">
                <div class="muted">Memuat formulir…</div>
            </div>
        </div>
    </div>

    {{-- ===== Upgrade Modal (already used by <x-plan-banner>) ===== --}}


    {{-- ===== JS for both modals & form fetch ===== --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const qs = s => document.querySelector(s);

            // helpers
            const openModal = id => {
                const m = qs('#' + id);
                if (m) {
                    m.removeAttribute('hidden');
                    document.body.style.overflow = 'hidden';
                }
            };
            const closeModal = id => {
                const m = qs('#' + id);
                if (m) {
                    m.setAttribute('hidden', '');
                    document.body.style.overflow = '';
                }
            };

            // Close handlers (button + backdrop)
            document.querySelectorAll('[data-close]').forEach(btn => {
                btn.addEventListener('click', () => closeModal(btn.getAttribute('data-close')));
            });
            document.querySelectorAll('.modal-backdrop').forEach(m => {
                m.addEventListener('click', e => {
                    if (e.target.classList.contains('modal-scrim')) closeModal(m.id);
                });
            });

            // Open Upgrade modal when buttons have data-open="upgrade-modal"
            document.querySelectorAll('[data-open="upgrade-modal"]').forEach(b => {
                b.addEventListener('click', () => openModal('upgrade-modal'));
            });
            if (location.hash === '#upgrade') openModal('upgrade-modal');

            // Open Create Listing modal and lazy-load /listings/create
            const openBtn = qs('#openCreateListing');
            const modalBody = qs('#create-listing-body');

            if (openBtn && modalBody) {
                openBtn.addEventListener('click', async () => {
                    openModal('create-listing-modal');

                    // Fetch once per page load
                    if (!modalBody.dataset.loaded) {
                        try {
                            const res = await fetch("{{ route('listings.create') }}", {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            });
                            const html = await res.text();

                            // Extract the first <form> from the returned Blade HTML
                            const temp = document.createElement('div');
                            temp.innerHTML = html;
                            const form = temp.querySelector('form') || temp;

                            modalBody.innerHTML = '';
                            modalBody.appendChild(form.cloneNode(true));
                            modalBody.dataset.loaded = '1';
                        } catch (e) {
                            modalBody.innerHTML =
                                '<div class="muted" style="color:#b91c1c">Gagal memuat formulir.</div>';
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
