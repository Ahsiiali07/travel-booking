@props([
    'name' => 'origin',
    'id' => null,
    'value' => '',
    'placeholder' => 'Select or search Pakistan airport...',
    'label' => null,
    'icon' => 'fa-plane',
    'iconColor' => '#0084c7',
    'badgeBg' => '#e0f2fe',
    'badgeColor' => '#0084c7',
    'clean' => false,
    'required' => false
])

@php
    $elementId = $id ?? 'airport_' . $name . '_' . uniqid();
    $airports = config('airports.pakistan', []);
@endphp

<div class="airport-search-wrapper position-relative" id="wrapper-{{ $elementId }}">
    @if($label)
        <label for="{{ $elementId }}" class="form-label fw-bold mb-2 d-flex align-items-center gap-2" style="color: #334155; font-size: 0.95rem;">
            <i class="fa-solid {{ $icon }}" style="color: {{ $iconColor }}; font-size: 1rem;"></i>
            <span>{{ $label }}</span>
            @if($required)<span class="text-danger">*</span>@endif
        </label>
    @endif

    <div class="position-relative">
        <input 
            type="text" 
            name="{{ $name }}" 
            id="{{ $elementId }}" 
            class="form-control airport-search-input figma-style-input text-dark" 
            value="{{ $value }}" 
            placeholder="{{ $placeholder }}" 
            autocomplete="off"
            list="list-{{ $elementId }}"
            style="border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 0.75rem 2.5rem 0.75rem 1rem; font-size: 0.95rem; font-weight: 500; height: 48px; background: #ffffff; transition: border-color 0.2s, box-shadow 0.2s;"
            @if($required) required @endif
        >
        <span class="position-absolute end-0 top-50 translate-middle-y pe-3 text-muted airport-toggle-icon" style="pointer-events: none;">
            <i class="fa-solid fa-chevron-down small opacity-50"></i>
        </span>
    </div>

    <!-- Datalist for universal fallback -->
    <datalist id="list-{{ $elementId }}">
        @foreach($airports as $ap)
            <option value="{{ $ap['city'] }} ({{ $ap['code'] }})">{{ $ap['name'] }}</option>
        @endforeach
    </datalist>

    <!-- Interactive Searchable Dropdown Popup -->
    <div class="airport-dropdown-menu shadow-lg border rounded-4 p-2 bg-white" style="display: none; position: absolute; top: 100%; left: 0; right: 0; z-index: 1060; max-height: 290px; overflow-y: auto; margin-top: 6px; box-shadow: 0 15px 35px rgba(0,0,0,0.18) !important;">
        <div class="px-2 py-1 pb-2 border-bottom mb-1 small text-muted d-flex justify-content-between align-items-center">
            <span class="fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.04em; color: #64748b;">Airports of Pakistan & Hubs</span>
            <span class="badge border count-badge" style="background: #f8fafc; color: #0f172a;">{{ count($airports) }}</span>
        </div>
        <div class="airport-options-list">
            @foreach($airports as $ap)
                <div class="airport-option p-2 rounded-3 d-flex justify-content-between align-items-center cursor-pointer" 
                     data-value="{{ $ap['city'] }} ({{ $ap['code'] }})"
                     data-city="{{ strtolower($ap['city']) }}"
                     data-code="{{ strtolower($ap['code']) }}"
                     data-name="{{ strtolower($ap['name']) }}"
                     style="cursor: pointer; transition: background-color 0.15s ease;">
                     <div>
                         <div class="fw-bold text-dark small leading-tight">{{ $ap['city'] }}</div>
                         <div class="text-muted" style="font-size: 0.76rem;">{{ $ap['name'] }}</div>
                     </div>
                     <span class="badge font-monospace fw-bold ms-2" style="background: {{ $badgeBg }}; color: {{ $badgeColor }}; font-size: 0.78rem;">{{ $ap['code'] }}</span>
                </div>
            @endforeach
        </div>
        <div class="no-airport-found text-center py-3 text-muted small" style="display: none;">
            <i class="fa-solid fa-plane-slash me-1"></i> No airport matching search.
        </div>
    </div>
</div>

@pushOnce('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initAirportDropdowns();
});

function initAirportDropdowns() {
    document.querySelectorAll('.airport-search-wrapper').forEach(wrapper => {
        const input = wrapper.querySelector('.airport-search-input');
        const menu = wrapper.querySelector('.airport-dropdown-menu');
        const toggleBtn = wrapper.querySelector('.airport-toggle-btn');
        const caret = toggleBtn ? toggleBtn.querySelector('i') : null;
        const options = wrapper.querySelectorAll('.airport-option');
        const noFound = wrapper.querySelector('.no-airport-found');

        function openMenu() {
            // Close any other open airport dropdowns first
            document.querySelectorAll('.airport-dropdown-menu').forEach(m => {
                if (m !== menu) m.style.display = 'none';
            });
            menu.style.display = 'block';
            if (caret) caret.style.transform = 'rotate(180deg)';
            filterOptions(input.value);
        }

        function closeMenu() {
            menu.style.display = 'none';
            if (caret) caret.style.transform = 'rotate(0deg)';
        }

        function filterOptions(term) {
            const cleanTerm = (term || '').toLowerCase().trim();
            let visibleCount = 0;
            options.forEach(opt => {
                const city = opt.getAttribute('data-city') || '';
                const code = opt.getAttribute('data-code') || '';
                const name = opt.getAttribute('data-name') || '';

                if (!cleanTerm || city.includes(cleanTerm) || code.includes(cleanTerm) || name.includes(cleanTerm)) {
                    opt.style.display = 'flex';
                    visibleCount++;
                } else {
                    opt.style.display = 'none';
                }
            });
            if (noFound) {
                noFound.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        input.addEventListener('focus', openMenu);
        input.addEventListener('click', openMenu);
        input.addEventListener('input', function() {
            openMenu();
            filterOptions(this.value);
        });

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (menu.style.display === 'block') {
                    closeMenu();
                } else {
                    input.focus();
                    openMenu();
                }
            });
        }

        options.forEach(opt => {
            opt.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f1f5f9';
            });
            opt.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
            opt.addEventListener('click', function(e) {
                e.stopPropagation();
                const selectedVal = this.getAttribute('data-value');
                input.value = selectedVal;
                closeMenu();
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target)) {
                closeMenu();
            }
        });
    });
}
</script>
@endPushOnce
