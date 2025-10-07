@props(['used'=>0,'limit'=>3,'plan'=>'Basic'])
<div class="card pad" style="display:flex;justify-content:space-between;align-items:center">
  <div>
    <div class="muted" style="font-size:12px">Current Plan</div>
    <div class="h2" style="margin:0">{{ $plan }} — {{ $used }}/{{ $limit }} listings used</div>
  </div>

  {{-- was href="#upgrade" --}}
  <button class="btn primary" type="button" data-open="upgrade-modal">Upgrade</button>
</div>
