<?php
$file = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\app\\Views\\client\\dashboard.php';
$content = file_get_contents($file);

// 1. Make active tab more distinct
$cssOld = '.tab-btn.active {
            color: #fff;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.4);
        }';
$cssNew = '.tab-btn.active {
            color: #fff;
            background: var(--primary);
            border: 1px solid var(--primary);
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
            font-weight: 700;
        }';
$content = str_replace($cssOld, $cssNew, $content);

// 2. Add Auto-scroll and tab switching for invalid hidden fields
$jsValidation = '
        // Smart Form Validation for Hidden Tabs
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form[action*=\'/dashboard/save\']");
            if (form) {
                form.addEventListener("submit", function(e) {
                    if (!this.checkValidity()) {
                        e.preventDefault(); // Stop submission
                        
                        // Find first invalid element
                        const firstInvalid = this.querySelector(":invalid");
                        if (firstInvalid) {
                            // Find which tab content it belongs to
                            const parentTab = firstInvalid.closest(".tab-content");
                            if (parentTab) {
                                const tabId = parentTab.id;
                                // Find the button that controls this tab
                                const tabBtn = document.querySelector(`.mobile-tabs-container .tab-btn[onclick*="${tabId}"]`);
                                showTab(tabId, tabBtn);
                                
                                // Give it a slight delay to allow the tab to become visible before scrolling
                                setTimeout(() => {
                                    // Scroll to the input
                                    firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
                                    firstInvalid.focus();
                                    
                                    // Briefly highlight the input in red
                                    const originalShadow = firstInvalid.style.boxShadow;
                                    firstInvalid.style.boxShadow = "0 0 0 3px rgba(239, 68, 68, 0.6)";
                                    firstInvalid.style.borderColor = "var(--danger)";
                                    setTimeout(() => { 
                                        firstInvalid.style.boxShadow = originalShadow; 
                                        firstInvalid.style.borderColor = "";
                                    }, 2500);
                                }, 100);
                            }
                        }
                    }
                });
            }
        });
    </script>';

$content = str_replace('</script>', $jsValidation, $content);

file_put_contents($file, $content);
echo "Successfully enhanced active tab and added smart validation scrolling.";
?>
