<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Teacher Dashboard' }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
  <header class="navbar">
    <div class="nav-wrap container">
      {{-- Brand goes to public landing so teacher can preview --}}
      <a href="{{ route('landing') }}" class="brand">Teacher</a>

      <div style="display:flex;gap:10px;align-items:center">
        {{-- IMPORTANT: real button, not <a> --}}
        <button class="btn primary" type="button" id="openCreateListing">+ New Listing</button>

        <a href="{{ route('teacher.profile.edit') }}">
          <img src="{{ Auth::user()->avatar_url ?? 'https://i.pravatar.cc/64' }}" alt=""
               style="width:36px;height:36px;border-radius:999px">
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
  <div id="upgrade-modal" class="modal-backdrop" hidden aria-hidden="true">
    <div class="modal-scrim" data-close="upgrade-modal"></div>
    <div class="modal-card card pad" role="dialog" aria-modal="true" aria-labelledby="upgrade-title">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
        <h2 id="upgrade-title" class="h2" style="margin:0">Paket Langganan</h2>
        <button class="btn" type="button" data-close="upgrade-modal">Tutup</button>
      </div>

      @php
        $tiers = [
          ['name'=>'Bronze','quota'=>3,'price'=>0,'desc'=>'Cocok mulai dulu'],
          ['name'=>'Silver','quota'=>6,'price'=>99000,'desc'=>'Lebih banyak kecamatan'],
          ['name'=>'Gold','quota'=>12,'price'=>149000,'desc'=>'Skala kota besar'],
        ];
      @endphp

      <div class="grid grid-3" style="margin-top:12px">
        @foreach($tiers as $t)
          <article class="card pad" style="display:flex;flex-direction:column;gap:8px">
            <div class="title" style="margin:0">{{ $t['name'] }}</div>
            <div class="muted">{{ $t['desc'] }}</div>
            <div class="h1" style="margin:2px 0">{{ $t['quota'] }}</div>
            <div class="muted">
              @if($t['price'] === 0) Gratis (30 hari)
              @else Rp{{ number_format($t['price'],0,',','.') }}/30 hari @endif
            </div>
            <a class="btn primary block"
               href="{{ url('/teacher') }}?select_plan={{ strtolower($t['name']) }}">
              Pilih {{ $t['name'] }}
            </a>
          </article>
        @endforeach
      </div>
    </div>
  </div>

  {{-- ===== JS for both modals & form fetch ===== --}}
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const qs = s => document.querySelector(s);

    // helpers
    const openModal = id => { const m=qs('#'+id); if(m){ m.removeAttribute('hidden'); document.body.style.overflow='hidden'; } };
    const closeModal = id => { const m=qs('#'+id); if(m){ m.setAttribute('hidden',''); document.body.style.overflow=''; } };

    // Close handlers (button + backdrop)
    document.querySelectorAll('[data-close]').forEach(btn=>{
      btn.addEventListener('click',()=>closeModal(btn.getAttribute('data-close')));
    });
    document.querySelectorAll('.modal-backdrop').forEach(m=>{
      m.addEventListener('click',e=>{ if(e.target.classList.contains('modal-scrim')) closeModal(m.id); });
    });

    // Open Upgrade modal when buttons have data-open="upgrade-modal"
    document.querySelectorAll('[data-open="upgrade-modal"]').forEach(b=>{
      b.addEventListener('click',()=>openModal('upgrade-modal'));
    });
    if (location.hash === '#upgrade') openModal('upgrade-modal');

    // Open Create Listing modal and lazy-load /listings/create
    const openBtn  = qs('#openCreateListing');
    const modalBody = qs('#create-listing-body');

    if (openBtn && modalBody) {
      openBtn.addEventListener('click', async () => {
        openModal('create-listing-modal');

        // Fetch once per page load
        if (!modalBody.dataset.loaded) {
          try {
            const res = await fetch("{{ route('listings.create') }}", {
              headers: { 'X-Requested-With': 'XMLHttpRequest' }
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
            modalBody.innerHTML = '<div class="muted" style="color:#b91c1c">Gagal memuat formulir.</div>';
          }
        }
      });
    }
  });
  </script>
</body>
</html>
