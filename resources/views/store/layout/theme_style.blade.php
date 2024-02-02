<style>
    .theme-bg {
        background-color: {{ theme()->color() }};
        color: {{ theme()->textColor() }};
    }

    .theme-bg a {
        color: {{ theme()->textColor() }};
    }

    .theme-bg a:hover {
        opacity: 0.7;
    }
    
    :root {
        --theme-color: {{ theme()->color() }};
        --theme-font-color: {{ theme()->textColor() }};
    }
</style>