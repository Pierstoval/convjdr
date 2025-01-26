(async function() {
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('[data-confirm]');

        if (!elements.length) {
            return;
        }

        elements.forEach((link) => {
            link.addEventListener('click', function (event) {
                const message = link.getAttribute('data-confirm');
                if (confirm(message)) {
                    if (link.tagName.toLowerCase() === 'button') {
                        // TODO: submit as a POST form.
                    }
                    return;
                }

                event.stopPropagation();
                event.preventDefault();
                return false;
            });
        })
    });
})();
