import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                primary: {
                    DEFAULT: '#f97316', 
                    hover: '#ea580c',
                    active: '#c2410c',
                },

                secondary: {
                    DEFAULT: '#1e293b',
                    hover: '#334155',
                    active: '#475569',
                },

                surface: {
                    DEFAULT: '#ffffff',
                    dark: '#1f2937',
                },
                
                background: {
                    DEFAULT: '#f3f4f6',
                    dark: '#111827',
                },

                error: {
                    DEFAULT: '#ef4444',
                    hover: '#dc2626',
                },
                
                muted: {
                    DEFAULT: '#9ca3af',
                    hover: '#6b7280',
                    dark: {
                        DEFAULT: '#6b7280',
                        hover: '#4b5563'
                    }
                },

                on: {
                    primary: {
                        DEFAULT:'#f3f4f6',
                        hover: '#000000',
                        active: '#000000',
                    },
                    
                    secondary: {
                        DEFAULT:'#f3f4f6',
                        hover: '#000000',
                        active: '#000000',
                    },

                    surface: {
                        DEFAULT:'#374151',
                        hover: '#1f2937',
                        active: '#111827',
                        dark: {
                            DEFAULT:'#f9fafb',
                            hover: '#f3f4f6',
                            active: '#e5e7eb',
                        }
                    },
                    background: {
                        DEFAULT:'#374151',
                        hover: '#1f2937',
                        active: '#111827',
                        dark: {
                            DEFAULT:'#f9fafb',
                            hover: '#f3f4f6',
                            active: '#e5e7eb',
                        }
                    },                    
                },
            }
        },
    },

    darkMode: 'class',

    plugins: [
        forms, 
        typography
    ],
};
