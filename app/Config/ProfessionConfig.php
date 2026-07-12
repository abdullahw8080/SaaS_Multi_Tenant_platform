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
                    'hero_badge'   => 'مطور برمجيات',
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
                    'hero_badge'   => 'Software Developer',
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
                'border_color'         => 'rgba(16, 185, 129, 0.12)',
            ],
            'labels' => [
                'ar' => [
                    'hero_badge'   => 'مهندس محترف',
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
                    'hero_badge'   => 'Professional Engineer',
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
                'bg_secondary'         => '#FFFFFF',
                'text_primary'         => '#0D1F3C',
                'text_secondary'       => '#4A6FA5',
                'accent_glow'          => '#0066CC',
                'accent_glow_secondary'=> '#00A8E8',
                'border_color'         => 'rgba(0, 102, 204, 0.15)',
            ],
            'extra_css' => "
                body { background-color: #F4F9FF !important; }
                .navbar { background: rgba(255, 255, 255, 0.95) !important; border-bottom: 1px solid rgba(0, 102, 204, 0.12) !important; box-shadow: 0 2px 20px rgba(0,102,204,0.08) !important; }
                .logo { color: #0066CC !important; }
                .nav-links a { color: #0D1F3C !important; }
                .nav-links a:hover { color: #0066CC !important; }
                .theme-btn, .lang-btn, .menu-btn { border-color: rgba(0,102,204,0.25) !important; color: #0066CC !important; background: rgba(0,102,204,0.05) !important; }
                .header-card { background: rgba(255,255,255,0.9) !important; border-color: rgba(0,102,204,0.12) !important; box-shadow: 0 20px 60px rgba(0,102,204,0.10) !important; }
                .glass-card { background: rgba(255,255,255,0.85) !important; border-color: rgba(0,102,204,0.15) !important; box-shadow: 0 8px 24px rgba(0,102,204,0.08) !important; }
                .glass-card:hover { background: rgba(240,248,255,0.95) !important; border-color: rgba(0,102,204,0.35) !important; box-shadow: 0 12px 32px rgba(0,102,204,0.15) !important; }
                .edu-card { background: #FFFFFF !important; border-color: rgba(0,102,204,0.12) !important; }
                .edu-card:hover { box-shadow: 0 15px 30px rgba(0,102,204,0.12) !important; border-color: rgba(0,102,204,0.3) !important; }
                .edu-degree { color: #0D1F3C !important; }
                .edu-year { background: rgba(0,102,204,0.08) !important; color: #0066CC !important; }
                .cert-modern-card { background: #FFFFFF !important; border-color: rgba(0,102,204,0.12) !important; }
                .cert-title { color: #0D1F3C !important; }
                .cert-issuer { color: #4A6FA5 !important; }
                .cert-year { color: #0066CC !important; }
                .btn-cert.secondary:hover { border-color: #0066CC !important; color: #0066CC !important; }
                .skill-modern-card { background: rgba(0,102,204,0.03) !important; border-color: rgba(0,102,204,0.12) !important; }
                .skill-modern-card:hover { background: rgba(0,102,204,0.06) !important; border-color: #0066CC !important; }
                .skill-title { color: #0D1F3C !important; }
                .project-modern-card { background: #FFFFFF !important; border-color: rgba(0,102,204,0.12) !important; }
                .project-modern-card:hover { box-shadow: 0 20px 40px rgba(0,102,204,0.15) !important; }
                .proj-title { color: #0D1F3C !important; }
                .proj-summary { color: #4A6FA5 !important; }
                .proj-overlay { background: rgba(0,30,80,0.75) !important; }
                .exp-modern-card { background: #FFFFFF !important; border-color: rgba(0,102,204,0.2) !important; }
                .exp-modern-card:hover { background: rgba(0,102,204,0.03) !important; }
                .exp-position { color: #0D1F3C !important; }
                .exp-date { background: rgba(0,102,204,0.07) !important; color: #4A6FA5 !important; }
                .section-title h2 { color: #0D1F3C !important; }
                .footer { border-top-color: rgba(0,102,204,0.12) !important; }
                .footer-name { color: #0D1F3C !important; }
                .footer .social-links a { background: rgba(0,102,204,0.08) !important; color: #0066CC !important; }
                .footer .social-links a:hover { background: #0066CC !important; color: #fff !important; }
                .footer .copyright { color: #4A6FA5 !important; }
                .hero-socials a { background: rgba(0,102,204,0.06) !important; border-color: rgba(0,102,204,0.2) !important; color: #0D1F3C !important; }
                .hero-socials a:hover { background: #0066CC !important; border-color: #0066CC !important; color: #fff !important; }
                .shape { opacity: 0.06 !important; }
                .lang-bar-wrapper { background: rgba(0,102,204,0.08) !important; }
                .lang-modern-card.glass-card { background: #FFFFFF !important; }
                .reference-card { background: #FFFFFF !important; }
                .hero-welcome-badge { background: rgba(0,102,204,0.10) !important; border-color: rgba(0,102,204,0.35) !important; color: #0055BB !important; }
            ",
            'labels' => [
                'ar' => [
                    'hero_badge'   => 'طبيب متخصص',
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
                    'hero_badge'   => 'Medical Specialist',
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
                    'hero_badge'   => 'صيدلي متخصص',
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
                    'hero_badge'   => 'Clinical Pharmacist',
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
                    'hero_badge'   => 'محامٍ ومستشار قانوني',
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
                    'hero_badge'   => 'Attorney & Legal Advisor',
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
                    'hero_badge'   => 'معلم ومربّي',
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
                    'hero_badge'   => 'Educator & Teacher',
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
                    'hero_badge'   => 'قائد تنفيذي',
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
                    'hero_badge'   => 'Executive Leader',
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
                    'hero_badge'   => 'محاسب قانوني معتمد',
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
                    'hero_badge'   => 'Certified Accountant',
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
                    'hero_badge'   => 'طالب متميز',
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
                    'hero_badge'   => 'Academic Student',
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
                    'hero_badge'   => 'محترف متميز',
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
                    'hero_badge'   => 'Professional',
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
        return self::get($profession)['hero_icon'] ?? 'fa-star';
    }

    /**
     * قائمة كل المهن المتاحة للـ dropdown في النماذج.
     */
    public static function getAvailableProfessions(string $lang = 'ar'): array
    {
        $names = [
            'ar' => [
                'developer'  => 'مطور برمجيات',
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
                'developer'  => 'Software Developer',
                'engineer'   => 'Engineer',
                'doctor'     => 'Doctor',
                'pharmacist' => 'Pharmacist',
                'lawyer'     => 'Lawyer / Attorney',
                'teacher'    => 'Teacher / Educator',
                'executive'  => 'Business Executive',
                'accountant' => 'Accountant',
                'student'    => 'Student',
                'other'      => 'Other Profession',
            ],
        ];
        return $names[$lang] ?? $names['ar'];
    }

    /** جلب CSS إضافي لتخصيص مهني (مثل light theme للطبيب) */
    public static function getExtraCss(string $profession): string
    {
        return self::get($profession)['extra_css'] ?? '';
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
