module.exports = {
  theme: {
    extend: {
      colors: {
        // Farben basieren auf CSS-Variablen aus <x-ui-styles />
        primary: 'rgb(var(--ui-primary-rgb) / <alpha-value>)',
        secondary: 'rgb(var(--ui-secondary-rgb) / <alpha-value>)',
        success: 'rgb(var(--ui-success-rgb) / <alpha-value>)',
        danger: 'rgb(var(--ui-danger-rgb) / <alpha-value>)',
        warning: 'rgb(var(--ui-warning-rgb) / <alpha-value>)',
        info: 'rgb(var(--ui-info-rgb) / <alpha-value>)',
        muted: 'rgb(var(--ui-muted-rgb) / <alpha-value>)',
        black: 'rgb(var(--ui-black-rgb) / <alpha-value>)',
        white: 'rgb(var(--ui-white-rgb) / <alpha-value>)',

        // Surface & Body
        body: 'var(--ui-body-color)',
        'body-bg': 'var(--ui-body-bg)',
        surface: 'var(--ui-surface)',
        'surface-color': 'var(--ui-surface-color)',
        border: 'var(--ui-border)'
      },
      fontFamily: {
        sans: 'var(--ui-font-sans)',
        mono: 'var(--ui-font-mono)'
      },
      borderRadius: {
        xs: 'var(--ui-radius-xs)',
        sm: 'var(--ui-radius-sm)',
        md: 'var(--ui-radius-md)',
        lg: 'var(--ui-radius-lg)',
        xl: 'var(--ui-radius-xl)',
        full: 'var(--ui-radius-full)'
      },
      boxShadow: {
        'xs': '0 1px 2px rgba(0,0,0,0.03)',
        'sm': '0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.03)',
        'md': '0 4px 12px rgba(0,0,0,0.06), 0 1px 3px rgba(0,0,0,0.04)',
        'lg': '0 12px 32px rgba(0,0,0,0.08), 0 2px 6px rgba(0,0,0,0.04)',
      },
      backdropBlur: {
        'glass': '12px',
      },
      transitionDuration: {
        DEFAULT: '150ms',
      },
      transitionTimingFunction: {
        DEFAULT: 'cubic-bezier(0.4, 0, 0.2, 1)',
      }
    }
  },
};


