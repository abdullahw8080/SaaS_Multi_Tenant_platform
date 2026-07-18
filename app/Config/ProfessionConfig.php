<?php
/**
 * ProfessionConfig.php
 *
 * عقل نظام التكيف المهني — كل الفروقات بين المهن هنا فقط.
 * القالب نفسه لا يحتوي أي منطق if/else خاص بمهنة معينة.
 *
 * CSS Variables المُصدَّرة تتطابق مع أسماء المتغيرات الموجودة في style.css:
 *   --bg-primary, --bg-secondary, --text-primary, --text-secondary
 *   --accent-glow, --accent-glow-secondary, --border-color
 */
class ProfessionConfig
{
    private static array $config = [

        // ─────────────────────────────────────────────────────
        // المطور — القالب الأصلي، الإعدادات تطابق style.css
        // ─────────────────────────────────────────────────────
        'developer' => [
            'colors' => [
                'bg_primary'           => '#0f172a',
                'bg_secondary'         => '#1e293b',
                'text_primary'         => '#f8fafc',
                'text_secondary'       => '#94a3b8',
                'accent_glow'          => '#8b5cf6',
                'accent_glow_secondary'=> '#3b82f6',
                'border_color'         => 'rgba(255, 255, 255, 0.08)',
            ],
            'labels' => [
                'ar' => [
                    'hero_badge'   => 'مرحبا',
                    'about'        => 'من أنا',
                    'skills'       => 'التقنيات والأدوات',
                    'projects'     => 'المشاريع البرمجية',
                    'experiences'  => 'الخبرة المهنية',
                    'education'    => 'المؤهلات العلمية',
                    'certificates' => 'الشهادات التقنية',
                    'languages'    => 'اللغات',
                    'contact'      => 'تواصل معي',
                    'cta_primary'  => 'تواصل معي',
                    'cta_cv'       => 'تحميل السيرة الذاتية',
                    'present'      => 'حتى الآن',
                ],
                'en' => [
                    'hero_badge'   => 'Hello',
                    'about'        => 'About Me',
                    'skills'       => 'Tech Stack & Tools',
                    'projects'     => 'Projects',
                    'experiences'  => 'Work Experience',
                    'education'    => 'Education',
                    'certificates' => 'Tech Certifications',
                    'languages'    => 'Languages',
                    'contact'      => 'Contact',
                    'cta_primary'  => 'Get In Touch',
                    'cta_cv'       => 'Download CV',
                    'present'      => 'Present',
                ],
            ],
            'hero_icon'      => 'fa-code',
            'show_level_bar' => true,
        ],

        // ─────────────────────────────────────────────────────
        // المهندس
        // ─────────────────────────────────────────────────────
        'engineer' => [
            'colors' => [
                'bg_primary'           => '#071510',
                'bg_secondary'         => '#112B1F',
                'text_primary'         => '#E2F0EA',
                'text_secondary'       => '#86A899',
                'accent_glow'          => '#10B981',
                'accent_glow_secondary'=> '#F59E0B',
                'border_color'         => 'rgba(255, 255, 255, 0.12)',
            ],
            'labels' => [
                'ar' => [
                    'hero_badge'   => 'مرحبا',
                    'about'        => 'نبذة عن المهندس',
                    'skills'       => 'المهارات الهندسية',
                    'projects'     => 'المشاريع الهندسية',
                    'experiences'  => 'الخبرة المهنية',
                    'education'    => 'المؤهلات الهندسية',
                    'certificates' => 'الشهادات المهنية',
                    'languages'    => 'اللغات',
                    'contact'      => 'تواصل معي',
                    'cta_primary'  => 'تواصل للتعاون',
                    'cta_cv'       => 'تحميل السيرة',
                    'present'      => 'حتى الآن',
                ],
                'en' => [
                    'hero_badge'   => 'Hello',
                    'about'        => 'About the Engineer',
                    'skills'       => 'Engineering Skills',
                    'projects'     => 'Engineering Projects',
                    'experiences'  => 'Professional Experience',
                    'education'    => 'Engineering Qualifications',
                    'certificates' => 'Professional Certifications',
                    'languages'    => 'Languages',
                    'contact'      => 'Contact',
                    'cta_primary'  => 'Contact for Collaboration',
                    'cta_cv'       => 'Download CV',
                    'present'      => 'Present',
                ],
            ],
            'hero_icon'      => 'fa-gear',
            'show_level_bar' => true,
        ],

        // ─────────────────────────────────────────────────────
        // الطبيب — ثيم أبيض/أزرق فاتح
        // ─────────────────────────────────────────────────────
        'doctor' => [
            'colors' => [
                'bg_primary'           => '#F4F9FF',
                'bg_secondary'         => '#ffffffff',
                'text_primary'         => '#0D1F3C',
                'text_secondary'       => '#4A6FA5',
                'accent_glow'          => '#0066CC',
                'accent_glow_secondary'=> '#00A8E8',
                'border_color'         => 'rgba(252, 254, 255, 0.15)',
            ],
            'extra_css' => "
                /* --- أنميشن ألوان متدرجة متحركة (Gradient Animation) --- */
                @keyframes doctorGradientMove {
                    0% { background-position: 0% 50%; }
                    50% { background-position: 100% 50%; }
                    100% { background-position: 0% 50%; }
                }

                .highlight-text, .btn-primary {
                    background-size: 200% 200% !important;
                    animation: doctorGradientMove 6s ease infinite !important;
                }

                /* --- الأشكال الخلفية المتحركة --- */
                body:not(.light-theme) .shape-1 {
                    background: radial-gradient(circle, rgba(0, 212, 255, 0.15) 0%, transparent 70%) !important;
                }
                body:not(.light-theme) .shape-2 {
                    background: radial-gradient(circle, rgba(167, 139, 250, 0.15) 0%, transparent 70%) !important;
                }
                body.light-theme .shape-1 {
                    background: radial-gradient(circle, rgba(0, 102, 204, 0.08) 0%, transparent 70%) !important;
                }
                body.light-theme .shape-2 {
                    background: radial-gradient(circle, rgba(0, 168, 232, 0.08) 0%, transparent 70%) !important;
                }

                /* --- الوضع الافتراضي (الداكن الطبي المخصص) --- */
                body:not(.light-theme) {
                    background-color: #0A1128 !important;
                    color: #E2E8F0 !important;
                }
                body:not(.light-theme) .navbar {
                    background: rgba(10, 17, 40, 0.95) !important;
                    border-bottom: 1px solid rgba(0, 212, 255, 0.12) !important;
                    box-shadow: 0 4px 30px rgba(0, 212, 255, 0.03) !important;
                }
                body:not(.light-theme) .logo {
                    color: #00D4FF !important;
                }
                body:not(.light-theme) .nav-links a {
                    color: #94A3B8 !important;
                }
                body:not(.light-theme) .nav-links a:hover {
                    color: #00D4FF !important;
                }
                body:not(.light-theme) .theme-btn, 
                body:not(.light-theme) .lang-btn, 
                body:not(.light-theme) .menu-btn {
                    border-color: rgba(0, 212, 255, 0.25) !important;
                    color: #00D4FF !important;
                    background: rgba(0, 212, 255, 0.05) !important;
                }
                body:not(.light-theme) .header-card {
                    background: rgba(16, 31, 66, 0.7) !important;
                    border-color: rgba(0, 212, 255, 0.15) !important;
                    backdrop-filter: blur(15px) !important;
                    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4) !important;
                }
                body:not(.light-theme) .glass-card,
                body:not(.light-theme) .edu-card,
                body:not(.light-theme) .cert-modern-card,
                body:not(.light-theme) .project-modern-card,
                body:not(.light-theme) .exp-modern-card,
                body:not(.light-theme) .reference-card {
                    background: rgba(16, 31, 66, 0.5) !important;
                    border-color: rgba(0, 212, 255, 0.15) !important;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
                }
                body:not(.light-theme) .glass-card:hover,
                body:not(.light-theme) .edu-card:hover,
                body:not(.light-theme) .cert-modern-card:hover,
                body:not(.light-theme) .project-modern-card:hover,
                body:not(.light-theme) .exp-modern-card:hover {
                    background: rgba(16, 31, 66, 0.85) !important;
                    border-color: #00D4FF !important;
                    box-shadow: 0 15px 35px rgba(0, 212, 255, 0.15) !important;
                }
                body:not(.light-theme) .edu-degree,
                body:not(.light-theme) .cert-title,
                body:not(.light-theme) .skill-title,
                body:not(.light-theme) .proj-title,
                body:not(.light-theme) .exp-position,
                body:not(.light-theme) .section-title h2,
                body:not(.light-theme) .footer-name {
                    color: #FFFFFF !important;
                }
                body:not(.light-theme) .text-secondary,
                body:not(.light-theme) .bio-text,
                body:not(.light-theme) .edu-inst,
                body:not(.light-theme) .cert-issuer,
                body:not(.light-theme) .proj-summary,
                body:not(.light-theme) .exp-desc,
                body:not(.light-theme) .copyright {
                    color: #94A3B8 !important;
                }
                body:not(.light-theme) .hero-socials a {
                    background: rgba(0, 212, 255, 0.05) !important;
                    border-color: rgba(0, 212, 255, 0.2) !important;
                    color: #E2E8F0 !important;
                }
                body:not(.light-theme) .hero-socials a:hover {
                    background: #00D4FF !important;
                    border-color: #00D4FF !important;
                    color: #0A1128 !important;
                    box-shadow: 0 10px 20px rgba(0, 212, 255, 0.3) !important;
                }
                body:not(.light-theme) .hero-welcome-badge {
                    background: rgba(0, 212, 255, 0.1) !important;
                    border-color: rgba(0, 212, 255, 0.3) !important;
                    color: #00D4FF !important;
                }
                body:not(.light-theme) .edu-year {
                    background: rgba(0, 212, 255, 0.1) !important;
                    color: #00D4FF !important;
                }
                body:not(.light-theme) .footer .social-links a {
                    background: rgba(0, 212, 255, 0.05) !important;
                    border: 1px solid rgba(0, 212, 255, 0.2) !important;
                    color: #E2E8F0 !important;
                    border-radius: 12px !important;
                    text-decoration: none !important;
                }
                body:not(.light-theme) .footer .social-links a:hover {
                    background: #00D4FF !important;
                    border-color: #00D4FF !important;
                    color: #0A1128 !important;
                    transform: translateY(-5px) !important;
                    box-shadow: 0 10px 20px rgba(0, 212, 255, 0.3) !important;
                }
                body:not(.light-theme) .lang-bar-wrapper {
                    background: rgba(255, 255, 255, 0.05) !important;
                }

                /* --- وضع اللايت مود المخصص (أبيض خالص) --- */
                body.light-theme {
                    background-color: #FFFFFF !important;
                    color: #0D1F3C !important;
                }
                body.light-theme .navbar {
                    background: rgba(255, 255, 255, 0.96) !important;
                    border-bottom: 1px solid rgba(0, 102, 204, 0.1) !important;
                    box-shadow: 0 2px 20px rgba(0,102,204,0.05) !important;
                }
                body.light-theme .logo {
                    color: #0066CC !important;
                }
                body.light-theme .nav-links a {
                    color: #0D1F3C !important;
                }
                body.light-theme .nav-links a:hover {
                    color: #0066CC !important;
                }
                body.light-theme .theme-btn, 
                body.light-theme .lang-btn, 
                body.light-theme .menu-btn {
                    border-color: rgba(0,102,204,0.2) !important;
                    color: #0066CC !important;
                    background: rgba(0,102,204,0.03) !important;
                }
                body.light-theme .header-card {
                    background: #FFFFFF !important;
                    border-color: rgba(0,102,204,0.1) !important;
                    box-shadow: 0 15px 45px rgba(0,102,204,0.06) !important;
                }
                body.light-theme .glass-card,
                body.light-theme .edu-card,
                body.light-theme .cert-modern-card,
                body.light-theme .project-modern-card,
                body.light-theme .exp-modern-card,
                body.light-theme .reference-card {
                    background: #FFFFFF !important;
                    border-color: rgba(0, 102, 204, 0.1) !important;
                    box-shadow: 0 8px 24px rgba(0, 102, 204, 0.04) !important;
                    color: #0D1F3C !important;
                }
                body.light-theme .glass-card:hover,
                body.light-theme .edu-card:hover,
                body.light-theme .cert-modern-card:hover,
                body.light-theme .project-modern-card:hover,
                body.light-theme .exp-modern-card:hover {
                    background: #FFFFFF !important;
                    border-color: #0066CC !important;
                    box-shadow: 0 12px 30px rgba(0, 102, 204, 0.1) !important;
                }
                body.light-theme .edu-degree,
                body.light-theme .cert-title,
                body.light-theme .skill-title,
                body.light-theme .proj-title,
                body.light-theme .exp-position,
                body.light-theme .section-title h2,
                body.light-theme .footer-name {
                    color: #0D1F3C !important;
                }
                body.light-theme .text-secondary,
                body.light-theme .bio-text,
                body.light-theme .edu-inst,
                body.light-theme .cert-issuer,
                body.light-theme .proj-summary,
                body.light-theme .exp-desc,
                body.light-theme .copyright {
                    color: #4A6FA5 !important;
                }
                body.light-theme .hero-socials a {
                    background: rgba(0, 102, 204, 0.04) !important;
                    border-color: rgba(0, 102, 204, 0.15) !important;
                    color: #0D1F3C !important;
                }
                body.light-theme .hero-socials a:hover {
                    background: #0066CC !important;
                    border-color: #0066CC !important;
                    color: #ffffff !important;
                    box-shadow: 0 10px 20px rgba(0, 102, 204, 0.2) !important;
                }
                body.light-theme .hero-welcome-badge {
                    background: rgba(0, 102, 204, 0.08) !important;
                    border-color: rgba(0, 102, 204, 0.25) !important;
                    color: #0066CC !important;
                }
                body.light-theme .edu-year {
                    background: rgba(0, 102, 204, 0.08) !important;
                    color: #0066CC !important;
                }
                body.light-theme .footer .social-links a {
                    background: rgba(0, 102, 204, 0.05) !important;
                    border: 1px solid rgba(0, 102, 204, 0.2) !important;
                    color: #0066CC !important;
                    border-radius: 12px !important;
                    text-decoration: none !important;
                }
                body.light-theme .footer .social-links a:hover {
                    background: #0066CC !important;
                    border-color: #0066CC !important;
                    color: #ffffff !important;
                    transform: translateY(-5px) !important;
                    box-shadow: 0 10px 20px rgba(0, 102, 204, 0.2) !important;
                }
                body.light-theme .lang-bar-wrapper {
                    background: rgba(0, 102, 204, 0.08) !important;
                }
                body.light-theme .rotating-arc.arc-1 {
                    border-color: rgba(0, 102, 204, 0.3) !important;
                }
                body.light-theme .rotating-arc.arc-2 {
                    border-color: rgba(0, 168, 232, 0.2) !important;
                }
            ",
            'labels' => [
                'ar' => [
                    'hero_badge'   => 'مرحبا',
                    'about'        => 'نبذة عن الطبيب',
                    'skills'       => 'التخصصات الطبية',
                    'projects'     => 'الأبحاث والمنشورات',
                    'experiences'  => 'المسيرة الطبية',
                    'education'    => 'المؤهلات الطبية',
                    'certificates' => 'الاعتمادات والتراخيص',
                    'languages'    => 'اللغات',
                    'contact'      => 'تواصل مع الطبيب',
                    'cta_primary'  => 'تواصل مع الطبيب',
                    'cta_cv'       => 'تحميل السيرة',
                    'present'      => 'حتى الآن',
                ],
                'en' => [
                    'hero_badge'   => 'Hello',
                    'about'        => 'About the Doctor',
                    'skills'       => 'Medical Specializations',
                    'projects'     => 'Research & Publications',
                    'experiences'  => 'Medical Career',
                    'education'    => 'Medical Qualifications',
                    'certificates' => 'Licenses & Credentials',
                    'languages'    => 'Languages',
                    'contact'      => 'Contact Doctor',
                    'cta_primary'  => 'Contact Doctor',
                    'cta_cv'       => 'Download CV',
                    'present'      => 'Present',
                ],
            ],
            'hero_icon'      => 'fa-stethoscope',
            'show_level_bar' => false,
            'section_icons'  => [
                'education'    => 'fa-graduation-cap',
                'certificates' => 'fa-id-card',
                'skills'       => 'fa-heartbeat',
                'projects'     => 'fa-book-medical',
                'experiences'  => 'fa-hospital',
                'languages'    => 'fa-language',
            ],
        ],

        // ─────────────────────────────────────────────────────
        // الصيدلي
        // ─────────────────────────────────────────────────────
        'pharmacist' => [
            'colors' => [
                'bg_primary'           => '#050D0F',
                'bg_secondary'         => '#0A2429',
                'text_primary'         => '#E0F7FA',
                'text_secondary'       => '#7DBEC8',
                'accent_glow'          => '#06B6D4',
                'accent_glow_secondary'=> '#34D399',
                'border_color'         => 'rgba(6, 182, 212, 0.12)',
            ],
            'labels' => [
                'ar' => [
                    'hero_badge'   => 'مرحبا',
                    'about'        => 'نبذة عن الصيدلي',
                    'skills'       => 'مجالات التخصص الصيدلي',
                    'projects'     => 'الأبحاث والدراسات',
                    'experiences'  => 'الخبرة الصيدلية',
                    'education'    => 'المؤهلات الصيدلية',
                    'certificates' => 'التراخيص والاعتمادات',
                    'languages'    => 'اللغات',
                    'contact'      => 'تواصل معي',
                    'cta_primary'  => 'تواصل معي',
                    'cta_cv'       => 'تحميل السيرة',
                    'present'      => 'حتى الآن',
                ],
                'en' => [
                    'hero_badge'   => 'Hello',
                    'about'        => 'About the Pharmacist',
                    'skills'       => 'Pharmacy Specializations',
                    'projects'     => 'Research & Studies',
                    'experiences'  => 'Pharmacy Experience',
                    'education'    => 'Pharmacy Qualifications',
                    'certificates' => 'Licenses & Credentials',
                    'languages'    => 'Languages',
                    'contact'      => 'Contact',
                    'cta_primary'  => 'Get in Touch',
                    'cta_cv'       => 'Download CV',
                    'present'      => 'Present',
                ],
            ],
            'hero_icon'      => 'fa-pills',
            'show_level_bar' => false,
        ],

        // ─────────────────────────────────────────────────────
        // المحامي
        // ─────────────────────────────────────────────────────
        'lawyer' => [
            'colors' => [
                'bg_primary'           => '#0A0800',
                'bg_secondary'         => '#1C1708',
                'text_primary'         => '#F5F0E0',
                'text_secondary'       => '#9C8E6E',
                'accent_glow'          => '#D4AF37',
                'accent_glow_secondary'=> '#8B7355',
                'border_color'         => 'rgba(212, 175, 55, 0.15)',
            ],
            'labels' => [
                'ar' => [
                    'hero_badge'   => 'مرحبا',
                    'about'        => 'نبذة عن المحامي',
                    'skills'       => 'مجالات الممارسة القانونية',
                    'projects'     => 'القضايا والإنجازات البارزة',
                    'experiences'  => 'المسيرة القانونية',
                    'education'    => 'المؤهلات القانونية',
                    'certificates' => 'التراخيص والعضويات',
                    'languages'    => 'اللغات',
                    'contact'      => 'طلب استشارة',
                    'cta_primary'  => 'طلب استشارة قانونية',
                    'cta_cv'       => 'تحميل السيرة',
                    'present'      => 'حتى الآن',
                ],
                'en' => [
                    'hero_badge'   => 'Hello',
                    'about'        => 'About the Attorney',
                    'skills'       => 'Practice Areas',
                    'projects'     => 'Notable Cases & Achievements',
                    'experiences'  => 'Legal Career',
                    'education'    => 'Legal Qualifications',
                    'certificates' => 'Bar Admissions & Memberships',
                    'languages'    => 'Languages',
                    'contact'      => 'Request Consultation',
                    'cta_primary'  => 'Request Legal Consultation',
                    'cta_cv'       => 'Download CV',
                    'present'      => 'Present',
                ],
            ],
            'hero_icon'      => 'fa-scale-balanced',
            'show_level_bar' => false,
        ],

        // ─────────────────────────────────────────────────────
        // المدرس / الأستاذ
        // ─────────────────────────────────────────────────────
        'teacher' => [
            'colors' => [
                'bg_primary'           => '#0D0A1A',
                'bg_secondary'         => '#1A1530',
                'text_primary'         => '#EDE9FE',
                'text_secondary'       => '#9382C0',
                'accent_glow'          => '#8B5CF6',
                'accent_glow_secondary'=> '#EC4899',
                'border_color'         => 'rgba(139, 92, 246, 0.12)',
            ],
            'labels' => [
                'ar' => [
                    'hero_badge'   => 'مرحبا',
                    'about'        => 'فلسفتي التعليمية',
                    'skills'       => 'المواد التي أدرّسها',
                    'projects'     => 'الأبحاث والمنشورات',
                    'experiences'  => 'المسيرة التعليمية',
                    'education'    => 'المؤهلات الأكاديمية',
                    'certificates' => 'الشهادات والاعتمادات',
                    'languages'    => 'اللغات',
                    'contact'      => 'تواصل معي',
                    'cta_primary'  => 'تواصل معي',
                    'cta_cv'       => 'تحميل السيرة',
                    'present'      => 'حتى الآن',
                ],
                'en' => [
                    'hero_badge'   => 'Hello',
                    'about'        => 'My Teaching Philosophy',
                    'skills'       => 'Subjects I Teach',
                    'projects'     => 'Research & Publications',
                    'experiences'  => 'Teaching Career',
                    'education'    => 'Academic Background',
                    'certificates' => 'Certifications',
                    'languages'    => 'Languages',
                    'contact'      => 'Contact',
                    'cta_primary'  => 'Get in Touch',
                    'cta_cv'       => 'Download CV',
                    'present'      => 'Present',
                ],
            ],
            'hero_icon'      => 'fa-chalkboard-teacher',
            'show_level_bar' => false,
        ],

        // ─────────────────────────────────────────────────────
        // مدير الأعمال / التنفيذي
        // ─────────────────────────────────────────────────────
        'executive' => [
            'colors' => [
                'bg_primary'           => '#080B12',
                'bg_secondary'         => '#131B2E',
                'text_primary'         => '#F5F0E8',
                'text_secondary'       => '#9CA3AF',
                'accent_glow'          => '#C9A94E',
                'accent_glow_secondary'=> '#2A4A7F',
                'border_color'         => 'rgba(201, 169, 78, 0.15)',
            ],
            'labels' => [
                'ar' => [
                    'hero_badge'   => 'مرحبا',
                    'about'        => 'القصة القيادية',
                    'skills'       => 'مجالات الخبرة',
                    'projects'     => 'الإنجازات الكبرى',
                    'experiences'  => 'المسيرة القيادية',
                    'education'    => 'التعليم والبرامج التنفيذية',
                    'certificates' => 'الاعتمادات المهنية',
                    'languages'    => 'اللغات',
                    'contact'      => 'طلب تواصل مهني',
                    'cta_primary'  => 'طلب تواصل مهني',
                    'cta_cv'       => 'تحميل السيرة',
                    'present'      => 'حتى الآن',
                ],
                'en' => [
                    'hero_badge'   => 'Hello',
                    'about'        => 'Leadership Story',
                    'skills'       => 'Areas of Expertise',
                    'projects'     => 'Key Achievements',
                    'experiences'  => 'Leadership Journey',
                    'education'    => 'Education & Executive Programs',
                    'certificates' => 'Professional Credentials',
                    'languages'    => 'Languages',
                    'contact'      => 'Request Contact',
                    'cta_primary'  => 'Request Professional Contact',
                    'cta_cv'       => 'Download CV',
                    'present'      => 'Present',
                ],
            ],
            'hero_icon'      => 'fa-briefcase',
            'show_level_bar' => false,
        ],

        // ─────────────────────────────────────────────────────
        // المحاسب
        // ─────────────────────────────────────────────────────
        'accountant' => [
            'colors' => [
                'bg_primary'           => '#060C12',
                'bg_secondary'         => '#0F1E2E',
                'text_primary'         => '#E8F0F8',
                'text_secondary'       => '#7A9BB8',
                'accent_glow'          => '#3B82F6',
                'accent_glow_secondary'=> '#10B981',
                'border_color'         => 'rgba(59, 130, 246, 0.12)',
            ],
            'labels' => [
                'ar' => [
                    'hero_badge'   => 'مرحبا',
                    'about'        => 'نبذة تعريفية',
                    'skills'       => 'مجالات المحاسبة والمالية',
                    'projects'     => 'المشاريع والإنجازات',
                    'experiences'  => 'الخبرة المهنية',
                    'education'    => 'المؤهلات الأكاديمية',
                    'certificates' => 'الشهادات المهنية',
                    'languages'    => 'اللغات',
                    'contact'      => 'تواصل معي',
                    'cta_primary'  => 'تواصل معي',
                    'cta_cv'       => 'تحميل السيرة',
                    'present'      => 'حتى الآن',
                ],
                'en' => [
                    'hero_badge'   => 'Hello',
                    'about'        => 'About Me',
                    'skills'       => 'Accounting & Finance Areas',
                    'projects'     => 'Projects & Achievements',
                    'experiences'  => 'Professional Experience',
                    'education'    => 'Academic Qualifications',
                    'certificates' => 'Professional Certifications',
                    'languages'    => 'Languages',
                    'contact'      => 'Contact',
                    'cta_primary'  => 'Get in Touch',
                    'cta_cv'       => 'Download CV',
                    'present'      => 'Present',
                ],
            ],
            'hero_icon'      => 'fa-calculator',
            'show_level_bar' => true,
        ],

        // ─────────────────────────────────────────────────────
        // الطالب
        // ─────────────────────────────────────────────────────
        'student' => [
            'colors' => [
                'bg_primary'           => '#080D1A',
                'bg_secondary'         => '#101828',
                'text_primary'         => '#E8EEFF',
                'text_secondary'       => '#7A88BB',
                'accent_glow'          => '#6366F1',
                'accent_glow_secondary'=> '#A78BFA',
                'border_color'         => 'rgba(99, 102, 241, 0.12)',
            ],
            'labels' => [
                'ar' => [
                    'hero_badge'   => 'مرحبا',
                    'about'        => 'نبذة تعريفية',
                    'skills'       => 'المهارات والاهتمامات',
                    'projects'     => 'المشاريع الأكاديمية',
                    'experiences'  => 'الخبرات والتدريب',
                    'education'    => 'المسيرة الأكاديمية',
                    'certificates' => 'الشهادات والدورات',
                    'languages'    => 'اللغات',
                    'contact'      => 'تواصل معي',
                    'cta_primary'  => 'تواصل معي',
                    'cta_cv'       => 'تحميل السيرة',
                    'present'      => 'حتى الآن',
                ],
                'en' => [
                    'hero_badge'   => 'Hello',
                    'about'        => 'About Me',
                    'skills'       => 'Skills & Interests',
                    'projects'     => 'Academic Projects',
                    'experiences'  => 'Internships & Training',
                    'education'    => 'Academic Journey',
                    'certificates' => 'Certifications & Courses',
                    'languages'    => 'Languages',
                    'contact'      => 'Contact',
                    'cta_primary'  => 'Get in Touch',
                    'cta_cv'       => 'Download CV',
                    'present'      => 'Present',
                ],
            ],
            'hero_icon'      => 'fa-graduation-cap',
            'show_level_bar' => true,
        ],

        // ─────────────────────────────────────────────────────
        // عام (مهنة أخرى)
        // ─────────────────────────────────────────────────────
        'other' => [
            'colors' => [
                'bg_primary'           => '#09090F',
                'bg_secondary'         => '#16162A',
                'text_primary'         => '#E2E8F0',
                'text_secondary'       => '#94A3B8',
                'accent_glow'          => '#6366F1',
                'accent_glow_secondary'=> '#F59E0B',
                'border_color'         => 'rgba(99, 102, 241, 0.12)',
            ],
            'labels' => [
                'ar' => [
                    'hero_badge'   => 'مرحبا',
                    'about'        => 'نبذة تعريفية',
                    'skills'       => 'المهارات والخبرات',
                    'projects'     => 'المشاريع والأعمال',
                    'experiences'  => 'الخبرة المهنية',
                    'education'    => 'المؤهلات العلمية',
                    'certificates' => 'الشهادات والاعتمادات',
                    'languages'    => 'اللغات',
                    'contact'      => 'تواصل معي',
                    'cta_primary'  => 'تواصل معي',
                    'cta_cv'       => 'تحميل السيرة',
                    'present'      => 'حتى الآن',
                ],
                'en' => [
                    'hero_badge'   => 'Hello',
                    'about'        => 'About Me',
                    'skills'       => 'Skills & Expertise',
                    'projects'     => 'Projects & Work',
                    'experiences'  => 'Professional Experience',
                    'education'    => 'Education',
                    'certificates' => 'Certifications',
                    'languages'    => 'Languages',
                    'contact'      => 'Contact',
                    'cta_primary'  => 'Get in Touch',
                    'cta_cv'       => 'Download CV',
                    'present'      => 'Present',
                ],
            ],
            'hero_icon'      => 'fa-star',
            'show_level_bar' => true,
        ],

    ]; // end $config

    // ═══════════════════════════════════════════════════════════
    // الدوال العامة
    // ═══════════════════════════════════════════════════════════

    /**
     * جلب الإعدادات الكاملة لمهنة معينة.
     * مع fallback تلقائي إلى 'developer' إن لم تُوجد المهنة.
     */
    public static function get(string $profession): array
    {
        return self::$config[$profession] ?? self::$config['developer'];
    }

    /**
     * جلب CSS Variables جاهزة للحقن في <style>:root{}
     * الأسماء تطابق متغيرات style.css الحالية:
     *   --bg-primary, --bg-secondary, --text-primary, --text-secondary
     *   --accent-glow, --accent-glow-secondary, --border-color
     */
    public static function getCssVariables(string $profession): string
    {
        $c = self::get($profession)['colors'];
        return "
            --bg-primary: {$c['bg_primary']};
            --bg-secondary: {$c['bg_secondary']};
            --text-primary: {$c['text_primary']};
            --text-secondary: {$c['text_secondary']};
            --accent-glow: {$c['accent_glow']};
            --accent-glow-secondary: {$c['accent_glow_secondary']};
            --border-color: {$c['border_color']};
        ";
    }

    /** جلب التسميات باللغة المطلوبة */
    public static function getLabels(string $profession, string $lang = 'ar'): array
    {
        $labels = self::get($profession)['labels'];
        return $labels[$lang] ?? $labels['ar'];
    }

    /** هل تظهر شريط مستوى المهارة؟ */
    public static function showLevelBar(string $profession): bool
    {
        return (bool)(self::get($profession)['show_level_bar'] ?? true);
    }

    /** جلب أيقونة Hero (Font Awesome class) */
    public static function getHeroIcon(string $profession): string
    {
        return '';
    }

    /**
     * قائمة كل المهن المتاحة للـ dropdown في النماذج.
     */
    public static function getAvailableProfessions(string $lang = 'ar'): array
    {
        $names = [
            'ar' => [
                'developer'  => 'بنفسجي داكن وأزرق',
                'engineer'   => 'أخضر عشبي وذهبي',
                'doctor'     => 'أزرق ناصع وأبيض',
                'pharmacist' => 'سماوي وزمردي',
                'lawyer'     => 'ذهبي وقور وبني',
                'teacher'    => 'أرجواني إبداعي ووردي',
                'executive'  => 'كحلي داكن وذهبي فاخر',
                'accountant' => 'كحلي عملي وأخضر زمردي',
                'student'    => 'أزرق نيلي وبنفسجي شبابي',
                'other'      => 'بنفسجي وأصفر دافئ كلاسيكي',
            ],
            'en' => [
                'developer'  => 'Dark Purple & Blue',
                'engineer'   => 'Grass Green & Gold',
                'doctor'     => 'Bright Blue & White',
                'pharmacist' => 'Cyan & Emerald',
                'lawyer'     => 'Royal Gold & Brown',
                'teacher'    => 'Creative Purple & Pink',
                'executive'  => 'Navy & Luxury Gold',
                'accountant' => 'Practical Navy & Emerald',
                'student'    => 'Indigo & Youthful Violet',
                'other'      => 'Classic Violet & Warm Yellow',
            ],
        ];
        return $names[$lang] ?? $names['ar'];
    }

    /**
     * مسميات المهن الفعلية بدلاً من مسميات الثيمات والألوان.
     */
    public static function getProfessionNames(string $lang = 'ar'): array
    {
        $names = [
            'ar' => [
                'developer'  => 'مطور برمجيات / تقني',
                'engineer'   => 'مهندس',
                'doctor'     => 'طبيب',
                'pharmacist' => 'صيدلي',
                'lawyer'     => 'محامي',
                'teacher'    => 'مدرس / أستاذ',
                'executive'  => 'مدير أعمال / تنفيذي',
                'accountant' => 'محاسب',
                'student'    => 'طالب',
                'other'      => 'مهنة أخرى',
            ],
            'en' => [
                'developer'  => 'Software Developer / Tech',
                'engineer'   => 'Engineer',
                'doctor'     => 'Doctor',
                'pharmacist' => 'Pharmacist',
                'lawyer'     => 'Lawyer',
                'teacher'    => 'Teacher / Professor',
                'executive'  => 'Business Manager / Executive',
                'accountant' => 'Accountant',
                'student'    => 'Student',
                'other'      => 'Other Profession',
            ],
        ];
        return $names[$lang] ?? $names['ar'];
    }

    /** جلب CSS إضافي لتخصيص مهني (توليد ديناميكي لجميع المهن لدعم اللايت والدارك والأنميشن) */
    public static function getExtraCss(string $profession): string
    {
        $profData = self::get($profession);
        
        // إذا كان هناك CSS مخصص بالكامل (مثل الطبيب)، نرجعه مباشرة
        if (isset($profData['extra_css']) && !empty($profData['extra_css'])) {
            return $profData['extra_css'];
        }

        $c = $profData['colors'];
        $accent = $c['accent_glow'];
        $accentSec = $c['accent_glow_secondary'];
        $rgbAccent = self::hexToRgb($accent);
        $rgbBgSec = self::hexToRgb($c['bg_secondary']);
        $rgbBgPrim = self::hexToRgb($c['bg_primary']);
        
        // توليد CSS ديناميكي ذكي لكل المهن ليدعم زر تبديل الثيم بشكل متكامل
        return "
            /* --- أنميشن ألوان متدرجة متحركة للمهنة --- */
            @keyframes {$profession}GradientMove {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            .highlight-text, .btn-primary {
                background-size: 200% 200% !important;
                animation: {$profession}GradientMove 6s ease infinite !important;
            }

            /* --- الوضع الافتراضي (الداكن المخصص للمهنة) --- */
            body:not(.light-theme) {
                background-color: {$c['bg_primary']} !important;
                color: {$c['text_primary']} !important;
            }
            body:not(.light-theme) .navbar {
                background: rgba({$rgbBgPrim}, 0.95) !important;
                border-bottom: 1px solid rgba({$rgbAccent}, 0.12) !important;
            }
            body:not(.light-theme) .logo {
                color: {$accent} !important;
            }
            body:not(.light-theme) .nav-links a {
                color: {$c['text_secondary']} !important;
            }
            body:not(.light-theme) .nav-links a:hover {
                color: {$accent} !important;
            }
            body:not(.light-theme) .theme-btn, 
            body:not(.light-theme) .lang-btn, 
            body:not(.light-theme) .menu-btn {
                border-color: rgba({$rgbAccent}, 0.25) !important;
                color: {$accent} !important;
                background: rgba({$rgbAccent}, 0.05) !important;
            }
            body:not(.light-theme) .header-card {
                background: rgba({$rgbBgSec}, 0.7) !important;
                border-color: rgba({$rgbAccent}, 0.15) !important;
                backdrop-filter: blur(15px) !important;
            }
            body:not(.light-theme) .glass-card,
            body:not(.light-theme) .edu-card,
            body:not(.light-theme) .cert-modern-card,
            body:not(.light-theme) .project-modern-card,
            body:not(.light-theme) .exp-modern-card,
            body:not(.light-theme) .reference-card {
                background: rgba({$rgbBgSec}, 0.5) !important;
                border-color: rgba({$rgbAccent}, 0.15) !important;
                color: {$c['text_primary']} !important;
            }
            body:not(.light-theme) .glass-card:hover,
            body:not(.light-theme) .edu-card:hover,
            body:not(.light-theme) .cert-modern-card:hover,
            body:not(.light-theme) .project-modern-card:hover,
            body:not(.light-theme) .exp-modern-card:hover {
                background: rgba({$rgbBgSec}, 0.85) !important;
                border-color: {$accent} !important;
                box-shadow: 0 15px 35px rgba({$rgbAccent}, 0.15) !important;
            }
            body:not(.light-theme) .edu-degree,
            body:not(.light-theme) .cert-title,
            body:not(.light-theme) .skill-title,
            body:not(.light-theme) .proj-title,
            body:not(.light-theme) .exp-position,
            body:not(.light-theme) .section-title h2,
            body:not(.light-theme) .footer-name {
                color: #FFFFFF !important;
            }
            body:not(.light-theme) .hero-socials a {
                background: rgba({$rgbAccent}, 0.05) !important;
                border-color: rgba({$rgbAccent}, 0.2) !important;
                color: {$c['text_primary']} !important;
            }
            body:not(.light-theme) .hero-socials a:hover {
                background: {$accent} !important;
                border-color: {$accent} !important;
                color: {$c['bg_primary']} !important;
                box-shadow: 0 10px 20px rgba({$rgbAccent}, 0.3) !important;
            }
            body:not(.light-theme) .hero-welcome-badge {
                background: rgba({$rgbAccent}, 0.1) !important;
                border-color: rgba({$rgbAccent}, 0.3) !important;
                color: {$accent} !important;
            }
            body:not(.light-theme) .edu-year {
                background: rgba({$rgbAccent}, 0.1) !important;
                color: {$accent} !important;
            }
            body:not(.light-theme) .footer .social-links a {
                background: rgba({$rgbAccent}, 0.05) !important;
                border: 1px solid rgba({$rgbAccent}, 0.2) !important;
                color: #E2E8F0 !important;
                border-radius: 12px !important;
                text-decoration: none !important;
            }
            body:not(.light-theme) .footer .social-links a:hover {
                background: {$accent} !important;
                border-color: {$accent} !important;
                color: {$c['bg_primary']} !important;
                transform: translateY(-5px) !important;
                box-shadow: 0 10px 20px rgba({$rgbAccent}, 0.3) !important;
            }

            /* --- وضع اللايت مود المخصص (أبيض خالص لكل المهن) --- */
            body.light-theme {
                background-color: #FFFFFF !important;
                color: #1E293B !important;
            }
            body.light-theme .navbar {
                background: rgba(255, 255, 255, 0.96) !important;
                border-bottom: 1px solid rgba({$rgbAccent}, 0.12) !important;
                box-shadow: 0 2px 20px rgba(0, 0, 0, 0.04) !important;
            }
            body.light-theme .logo {
                color: {$accent} !important;
            }
            body.light-theme .nav-links a {
                color: #334155 !important;
            }
            body.light-theme .nav-links a:hover {
                color: {$accent} !important;
            }
            body.light-theme .theme-btn, 
            body.light-theme .lang-btn, 
            body.light-theme .menu-btn {
                border-color: rgba({$rgbAccent}, 0.2) !important;
                color: {$accent} !important;
                background: rgba({$rgbAccent}, 0.03) !important;
            }
            body.light-theme .header-card {
                background: #FFFFFF !important;
                border-color: rgba({$rgbAccent}, 0.1) !important;
                box-shadow: 0 15px 45px rgba(0, 0, 0, 0.05) !important;
            }
            body.light-theme .glass-card,
            body.light-theme .edu-card,
            body.light-theme .cert-modern-card,
            body.light-theme .project-modern-card,
            body.light-theme .exp-modern-card,
            body.light-theme .reference-card {
                background: #F8FAFC !important;
                border-color: rgba({$rgbAccent}, 0.1) !important;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.02) !important;
                color: #1E293B !important;
            }
            body.light-theme .glass-card:hover,
            body.light-theme .edu-card:hover,
            body.light-theme .cert-modern-card:hover,
            body.light-theme .project-modern-card:hover,
            body.light-theme .exp-modern-card:hover {
                background: #FFFFFF !important;
                border-color: {$accent} !important;
                box-shadow: 0 12px 30px rgba({$rgbAccent}, 0.1) !important;
            }
            body.light-theme .edu-degree,
            body.light-theme .cert-title,
            body.light-theme .skill-title,
            body.light-theme .proj-title,
            body.light-theme .exp-position,
            body.light-theme .section-title h2,
            body.light-theme .footer-name {
                color: #0F172A !important;
            }
            body.light-theme .text-secondary,
            body.light-theme .bio-text,
            body.light-theme .edu-inst,
            body.light-theme .cert-issuer,
            body.light-theme .proj-summary,
            body.light-theme .exp-desc,
            body.light-theme .copyright {
                color: #475569 !important;
            }
            body.light-theme .hero-socials a {
                background: rgba({$rgbAccent}, 0.04) !important;
                border-color: rgba({$rgbAccent}, 0.15) !important;
                color: #1E293B !important;
            }
            body.light-theme .hero-socials a:hover {
                background: {$accent} !important;
                border-color: {$accent} !important;
                color: #ffffff !important;
                box-shadow: 0 10px 20px rgba({$rgbAccent}, 0.2) !important;
            }
            body.light-theme .hero-welcome-badge {
                background: rgba({$rgbAccent}, 0.08) !important;
                border-color: rgba({$rgbAccent}, 0.25) !important;
                color: {$accent} !important;
            }
            body.light-theme .edu-year {
                background: rgba({$rgbAccent}, 0.08) !important;
                color: {$accent} !important;
            }
            body.light-theme .footer .social-links a {
                background: rgba({$rgbAccent}, 0.05) !important;
                border: 1px solid rgba({$rgbAccent}, 0.2) !important;
                color: {$accent} !important;
                border-radius: 12px !important;
                text-decoration: none !important;
            }
            body.light-theme .footer .social-links a:hover {
                background: {$accent} !important;
                border-color: {$accent} !important;
                color: #ffffff !important;
                transform: translateY(-5px) !important;
                box-shadow: 0 10px 20px rgba({$rgbAccent}, 0.2) !important;
            }
            body.light-theme .lang-bar-wrapper {
                background: rgba({$rgbAccent}, 0.08) !important;
            }
        ";
    }

    /** تحويل لون hex إلى rgb لسهولة استخدامه في شفافية الألوان */
    private static function hexToRgb(string $hex): string
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return "$r, $g, $b";
    }

    /**
     * جلب أيقونات الأقسام الخاصة بالمهنة.
     * القيم الافتراضية هي أيقونات المطور.
     */
    public static function getSectionIcons(string $profession): array
    {
        $defaults = [
            'education'    => 'fa-graduation-cap',
            'certificates' => 'fa-certificate',
            'skills'       => 'fa-laptop-code',
            'projects'     => 'fa-folder-open',
            'experiences'  => 'fa-briefcase',
            'languages'    => 'fa-language',
        ];
        $custom = self::get($profession)['section_icons'] ?? [];
        return array_merge($defaults, $custom);
    }
}
