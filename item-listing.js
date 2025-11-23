<script>
document.addEventListener('DOMContentLoaded', function() {
    const items = document.querySelectorAll('.placeholder-item');
    const pageLinks = document.querySelectorAll('.placeholder-page-link');
    const itemsPerPage = <?php echo $items_per_page; ?>;
    const section = document.getElementById('placeholder-group');

    /* Show a selected page of items */
    function showPage(page) {
        items.forEach(item => item.classList.add('d-none'));

        items.forEach((item, index) => {
            if (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) {
                item.classList.remove('d-none');
            }
        });

        pageLinks.forEach(link => link.classList.remove('active'));
        const active = document.querySelector(`.placeholder-page-link[data-page="${page}"]`);
        if (active) active.classList.add('active');
    }

    /* Reveal section when query param indicates it */
    function revealSectionFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('view') === 'placeholder') {
            section.classList.remove('d-none');
        }
    }

    /* Restore correct page when URL contains hash */
    function handlePageFromHash() {
        const hash = window.location.hash;
        const match = hash.match(/#pg-(\d+)/);
        if (match) showPage(parseInt(match[1]));
    }

    revealSectionFromURL();
    handlePageFromHash();

    /* Update pagination and URL without reloading */
    pageLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const page = parseInt(this.dataset.page);
            showPage(page);

            const url = new URL(window.location);
            url.hash = '#pg-' + page;
            history.pushState({}, '', url);
        });
    });
});
</script>
