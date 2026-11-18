@props([
    'name' => 'origin',
    'id' => null,
    'value' => '',
    'placeholder' => 'Select or search Pakistan airport...',
    'label' => null,
    'icon' => 'fa-plane-departure',
    'required' => false
])

@php
    $elementId = $id ?? 'airport_' . $name . '_' . uniqid();
    $airports = config('airports.pakistan', []);
@endphp

<div class="airport-search-wrapper position-relative" id="wrapper-{{ $elementId }}">
    @if($label)
        <label for="{{ $elementId }}" class="form-label small fw-bold text-muted mb-1 d-flex align-items-center gap-1">
            <i class="fa-solid {{ $icon }} text-primary"></i>
            <span>{{ $label }}</span>
            @if($required)<span class="text-danger">*</span>@endif
        </label>
    @endif

    <div class="input-group airport-input-group shadow-2xs">
        <span class="input-group-text bg-white border-end-0 text-primary ps-3">
            <i class="fa-solid {{ $icon }}"></i>
        </span>
        <input 
            type="text" 
            name="{{ $name }}" 
            id="{{ $elementId }}" 
            class="form-control border-start-0 border-end-0 ps-2 airport-search-input fw-semibold text-dark" 
            value="{{ $value }}" 
            placeholder="{{ $placeholder }}" 
            autocomplete="off"
            list="list-{{ $elementId }}"
            @if($required) required @endif
        >
        <button type="button" class="btn btn-white border border-start-0 text-muted airport-toggle-btn pe-3" tabindex="-1" title="Browse all airports">
            <i class="fa-solid fa-chevron-down small transition-transform"></i>
        </button>
    </div>

    <!-- Datalist for universal fallback -->
    <datalist id="list-{{ $elementId }}">
        @foreach($airports as $ap)
            <option value="{{ $ap['city'] }} ({{ $ap['code'] }})">{{ $ap['name'] }}</option>
        @endforeach
    </datalist>

    <!-- Interactive Searchable Dropdown Popup -->
    <div class="airport-dropdown-menu shadow-lg border rounded-3 p-2 bg-white" style="display: none; position: absolute; top: 100%; left: 0; right: 0; z-index: 1060; max-height: 290px; overflow-y: auto; margin-top: 4px;">
        <div class="px-2 py-1 pb-2 border-bottom mb-1 small text-muted d-flex justify-content-between align-items-center">
            <span class="fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.04em;">Airports of Pakistan & Major Hubs</span>
            <span class="badge bg-light text-secondary border count-badge">{{ count($airports) }}</span>
        </div>
        <div class="airport-options-list">
            @foreach($airports as $ap)
                <div class="airport-option p-2 rounded-2 d-flex justify-content-between align-items-center cursor-pointer" 
                     data-value="{{ $ap['city'] }} ({{ $ap['code'] }})"
                     data-city="{{ strtolower($ap['city']) }}"
                     data-code="{{ strtolower($ap['code']) }}"
                     data-name="{{ strtolower($ap['name']) }}"
                     style="cursor: pointer; transition: background-color 0.15s ease;">
                    <div>
                        <div class="fw-bold text-dark small leading-tight">{{ $ap['city'] }}</div>
                        <div class="text-muted" style="font-size: 0.76rem;">{{ $ap['name'] }}</div>
                    </div>
                    <span class="badge bg-primary-subtle text-primary font-monospace fw-bold ms-2">{{ $ap['code'] }}</span>
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
