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
      }
    }
  },
};


