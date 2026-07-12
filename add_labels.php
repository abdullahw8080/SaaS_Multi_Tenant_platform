<?php
$file = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\app\\Views\\client\\dashboard.php';
$content = file_get_contents($file);

$cssRule = '
        /* Required / Optional Badges using Modern CSS :has() */
        .form-group:has(input[required], select[required], textarea[required]) .form-label::after {
            content: " (إجباري)";
            color: var(--danger);
            font-size: 0.75rem;
            margin-right: 6px;
            font-weight: 600;
        }
        .form-group:not(:has(input[required], select[required], textarea[required])) .form-label:not(.no-badge)::after {
            content: " (اختياري)";
            color: var(--text-muted);
            font-size: 0.75rem;
            margin-right: 6px;
            font-weight: normal;
        }
        
        /* English Labels */
        .form-group:has(input[required], select[required], textarea[required]) .form-label.ltr::after {
            content: " (Required)";
            margin-right: 0;
            margin-left: 6px;
        }
        .form-group:not(:has(input[required], select[required], textarea[required])) .form-label.ltr:not(.no-badge)::after {
            content: " (Optional)";
            margin-right: 0;
            margin-left: 6px;
        }
    </style>';

// Replace closing style tag with our rules appended
$content = str_replace('</style>', $cssRule, $content);

// Hide badge for "Language Settings" and "Section Configuration Checkboxes"
$content = str_replace('<label class="form-label">إعدادات اللغة للموقع</label>', '<label class="form-label no-badge">إعدادات اللغة للموقع</label>', $content);
$content = str_replace('<label class="form-label">المراجع (References)</label>', '<label class="form-label no-badge">المراجع (References)</label>', $content);
$content = str_replace('<label class="form-label" style="font-weight:700;">', '<label class="form-label no-badge" style="font-weight:700;">', $content); // Project media gallery label

file_put_contents($file, $content);
echo "Successfully added required/optional badges via CSS.";
?>
