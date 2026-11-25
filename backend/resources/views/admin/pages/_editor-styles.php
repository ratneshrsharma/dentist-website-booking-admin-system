<style>
/* Clean Segmented Tab Bar */
.cms-editor-tabs {
    display: inline-flex;
    flex-wrap: wrap;
    gap: 6px;
    background: #eef2f6;
    padding: 6px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}
.cms-editor-tabs .nav-link {
    border: none !important;
    border-radius: 8px !important;
    padding: 10px 20px !important;
    font-size: 0.9rem;
    font-weight: 600;
    color: #475569 !important;
    background: transparent !important;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.cms-editor-tabs .nav-link:hover:not(.active) {
    background: rgba(255, 255, 255, 0.7) !important;
    color: #0f172a !important;
}
.cms-editor-tabs .nav-link.active {
    background: #0d631b !important;
    color: #ffffff !important;
    box-shadow: 0 3px 10px rgba(13, 99, 27, 0.28);
}

/* Accordion Section Cards */
.section-item-card {
    border: 1px solid #e2e8f0 !important;
    border-radius: 14px !important;
    overflow: hidden;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.section-item-card.is-open {
    border-color: #0d631b !important;
    box-shadow: 0 6px 20px rgba(13, 99, 27, 0.1) !important;
}
.section-acc-header {
    background-color: #ffffff !important;
    padding: 14px 18px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 12px;
    flex-wrap: wrap;
    transition: background-color 0.2s ease, color 0.2s ease;
    cursor: pointer;
}
.section-acc-left {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    min-width: 0;
}
.section-acc-right {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-left: auto;
}
.section-toggle-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background: #f8fafc;
    color: #0f172a;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    transition: all 0.2s ease;
}
.section-toggle-btn:hover {
    background: #e2e8f0;
}

/* Active (Open) Accordion Header: Solid Primary Color */
.section-item-card.is-open > .section-acc-header {
    background-color: #0d631b !important;
    color: #ffffff !important;
    border-bottom-color: rgba(255, 255, 255, 0.15) !important;
}
.section-item-card.is-open > .section-acc-header .section-name-display {
    color: #ffffff !important;
}
.section-item-card.is-open > .section-acc-header .section-order-badge {
    background: rgba(255, 255, 255, 0.2) !important;
    color: #ffffff !important;
}
.section-item-card.is-open > .section-acc-header .section-cat-badge {
    background: rgba(255, 255, 255, 0.18) !important;
    color: #ffffff !important;
}
.section-item-card.is-open > .section-acc-header .btn-outline-secondary {
    color: #ffffff !important;
    border-color: rgba(255, 255, 255, 0.4) !important;
}
.section-item-card.is-open > .section-acc-header .btn-outline-secondary:hover {
    background: rgba(255, 255, 255, 0.2) !important;
}
.section-item-card.is-open > .section-acc-header .btn-outline-danger {
    color: #fecaca !important;
    border-color: rgba(254, 202, 202, 0.5) !important;
}
.section-item-card.is-open > .section-acc-header .btn-outline-danger:hover {
    background: #dc2626 !important;
    color: #ffffff !important;
}
.section-item-card.is-open > .section-acc-header .form-check-label {
    color: #ffffff !important;
}
.section-item-card.is-open > .section-acc-header .section-toggle-btn {
    background: rgba(255, 255, 255, 0.2) !important;
    border-color: rgba(255, 255, 255, 0.4) !important;
    color: #ffffff !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    bindAccordionStateListeners(document);
});

function bindAccordionStateListeners(root) {
    root.querySelectorAll('.section-item-card .collapse').forEach(function (collapseEl) {
        if (collapseEl.dataset.accBound === '1') return;
        collapseEl.dataset.accBound = '1';

        const card = collapseEl.closest('.section-item-card');
        const toggleIcon = card ? card.querySelector('.section-toggle-btn i') : null;

        collapseEl.addEventListener('show.bs.collapse', function () {
            if (card) card.classList.add('is-open');
            if (toggleIcon) {
                toggleIcon.classList.remove('bi-plus-lg');
                toggleIcon.classList.add('bi-dash-lg');
            }
        });

        collapseEl.addEventListener('hide.bs.collapse', function () {
            if (card) card.classList.remove('is-open');
            if (toggleIcon) {
                toggleIcon.classList.remove('bi-dash-lg');
                toggleIcon.classList.add('bi-plus-lg');
            }
        });
    });
}

function moveLoopCard(btn, selector, dir) {
    const item = btn.closest(selector);
    if (!item) return;
    if (dir < 0 && item.previousElementSibling && item.previousElementSibling.matches(selector)) {
        item.parentNode.insertBefore(item, item.previousElementSibling);
    } else if (dir > 0 && item.nextElementSibling && item.nextElementSibling.matches(selector)) {
        item.parentNode.insertBefore(item.nextElementSibling, item);
    }
}

function removeLoopCard(btn, selector) {
    const item = btn.closest(selector);
    if (item && item.parentNode.querySelectorAll(selector).length > 1) {
        item.remove();
    } else {
        alert('At least 1 item must remain.');
    }
}
</script>
<?php
if (!function_exists('renderIconPickerInput')) {
    function renderIconPickerInput(string $name, string $value, string $placeholder = 'verified'): void {
        $safeName = htmlspecialchars($name);
        $safeVal = htmlspecialchars($value ?: $placeholder);
        echo '<div class="input-group input-group-sm icon-picker-group">';
        echo '<span class="input-group-text bg-white"><span class="material-symbols-outlined icon-picker-preview" style="font-size:18px; color:#0d631b;">' . $safeVal . '</span></span>';
        echo '<input type="text" name="' . $safeName . '" class="form-control font-monospace icon-picker-input" value="' . $safeVal . '" placeholder="' . htmlspecialchars($placeholder) . '" oninput="this.previousElementSibling.querySelector(\'.icon-picker-preview\').textContent = this.value || \'help\'">';
        echo '<button type="button" class="btn btn-outline-secondary" onclick="openIconPicker(this)" title="Choose Material Icon"><i class="bi bi-grid-3x3-gap"></i></button>';
        echo '</div>';
    }
}
if (!function_exists('renderColsSelector')) {
    function renderColsSelector(string $name, int $selected = 4): void {
        echo '<div class="d-inline-flex align-items-center gap-2">';
        echo '<label class="small fw-semibold text-muted mb-0">Columns:</label>';
        echo '<select name="' . htmlspecialchars($name) . '" class="form-select form-select-sm" style="width: auto;">';
        for ($c = 1; $c <= 6; $c++) {
            $sel = $selected === $c ? ' selected' : '';
            echo '<option value="' . $c . '"' . $sel . '>' . $c . ' ' . ($c === 1 ? 'Col' : 'Cols') . '</option>';
        }
        echo '</select></div>';
    }
}
?>
