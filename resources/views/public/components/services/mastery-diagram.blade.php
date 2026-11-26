<div class="mastery-stage" aria-hidden="true">
    <svg class="mastery-svg" focusable="false">
        <g class="mastery-rings">
            <circle cx="50%" cy="50%" r="22%"></circle>
            <circle cx="50%" cy="50%" r="38%"></circle>
        </g>
        <g class="hidden sm:block">
            <line class="mastery-axis" x1="8%" x2="92%" y1="50%" y2="50%"></line>
            <circle class="mastery-blob" cx="8%" cy="50%" r="5"></circle>
            <circle class="mastery-blob" cx="92%" cy="50%" r="5"></circle>
        </g>
        <g class="sm:hidden">
            <line class="mastery-axis" x1="50%" x2="50%" y1="10%" y2="90%"></line>
            <circle class="mastery-blob" cx="50%" cy="10%" r="4"></circle>
            <circle class="mastery-blob" cx="50%" cy="90%" r="4"></circle>
        </g>
    </svg>
    <div class="mastery-axis-layout">
        <span class="mastery-label mastery-label--left">{{ $leftLabel }}</span>
        <span class="mastery-axis-slot"></span>
        <span class="mastery-label mastery-label--right">{{ $rightLabel }}</span>
    </div>
    <span class="mastery-label mastery-label--core">{{ $coreLabel }}</span>
</div>
