<!-- Global Searchable Material Symbols Icon Picker Modal -->
<div class="modal fade" id="globalIconPickerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header bg-light border-bottom py-3">
                <h5 class="modal-title fw-bold">
                    <span class="material-symbols-outlined align-middle text-success me-1">apps</span>
                    Select Material Symbol Icon
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="input-group mb-3">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" id="iconPickerSearch" class="form-control" placeholder="Search icons (e.g. dentistry, verified, hospital, star, calendar, lock)..." oninput="filterIconPickerGrid(this.value)">
                </div>
                <div id="iconPickerGrid" class="row g-2" style="max-height: 360px; overflow-y: auto;"></div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-picker-tile {
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 6px;
    text-align: center;
    cursor: pointer;
    background: #ffffff;
    transition: all 0.15s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
}
.icon-picker-tile:hover,
.icon-picker-tile.active {
    border-color: #0d631b;
    background: #f0fdf4;
    color: #0d631b;
}
.icon-picker-tile .material-symbols-outlined {
    font-size: 24px;
}
.icon-picker-tile small {
    font-size: 10px;
    color: #64748b;
    word-break: break-all;
    line-height: 1.1;
}
</style>

<script>
const CMS_MATERIAL_ICONS = [
    'dentistry', 'medical_services', 'local_hospital', 'healing', 'clean_hands',
    'sanitizer', 'biotech', 'radiology', 'vital_signs', 'e911_emergency',
    'emergency', 'health_and_safety', 'verified_user', 'verified', 'shield',
    'workspace_premium', 'military_tech', 'award_star', 'star', 'favorite',
    'spa', 'self_improvement', 'sentiment_satisfied', 'mood', 'groups',
    'person', 'school', 'psychology', 'accessible', 'chair',
    'directions_bus', 'local_parking', 'location_on', 'map', 'schedule',
    'calendar_month', 'event_available', 'call', 'support_agent', 'chat',
    'mail', 'article', 'description', 'receipt_long', 'payments',
    'credit_card', 'lock', 'security', 'check_circle', 'task_alt',
    'auto_fix_high', 'flare', 'lightbulb', 'build', 'settings',
    'visibility', 'thumb_up', 'volunteer_activism', 'family_restroom', 'child_care'
];

let activeIconTargetInput = null;
let activeIconPreviewEl = null;

function openIconPicker(triggerBtn) {
    const group = triggerBtn.closest('.icon-picker-group');
    if (!group) return;
    activeIconTargetInput = group.querySelector('.icon-picker-input');
    activeIconPreviewEl = group.querySelector('.icon-picker-preview');
    document.getElementById('iconPickerSearch').value = '';
    renderIconPickerGrid('');
    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('globalIconPickerModal'));
    modal.show();
}

function filterIconPickerGrid(query) {
    renderIconPickerGrid((query || '').toLowerCase().trim());
}

function renderIconPickerGrid(filter) {
    const grid = document.getElementById('iconPickerGrid');
    const currentVal = activeIconTargetInput ? activeIconTargetInput.value.trim() : '';
    const items = CMS_MATERIAL_ICONS.filter(ic => !filter || ic.includes(filter));
    grid.innerHTML = items.map(ic => `
        <div class="col-4 col-sm-3 col-md-2">
            <div class="icon-picker-tile ${ic === currentVal ? 'active' : ''}" onclick="selectCmsIcon('${ic}')" title="${ic}">
                <span class="material-symbols-outlined">${ic}</span>
                <small>${ic}</small>
            </div>
        </div>
    `).join('');
}

function selectCmsIcon(iconName) {
    if (activeIconTargetInput) {
        activeIconTargetInput.value = iconName;
        activeIconTargetInput.dispatchEvent(new Event('change', { bubbles: true }));
    }
    if (activeIconPreviewEl) {
        activeIconPreviewEl.textContent = iconName;
    }
    const modal = bootstrap.Modal.getInstance(document.getElementById('globalIconPickerModal'));
    if (modal) modal.hide();
}
</script>
