<script>
jQuery(document).ready(function($) {
    
    jQuery('#btnGaleria').on('click', function(e) {
        e.preventDefault();
        abrir();
    });
    jQuery('#imagen1').on('click', function(e) {
        e.preventDefault();
        abrir();
    });
    
    function abrir(){
        jQuery('#carouselP .elementor-gallery-item').first().trigger('click');
    }
});

window.addEventListener('load', () => {
	setTimeout(function () {

		const tabsAccordionToggleTitles = document.querySelectorAll('.e-n-accordion-item-title, .e-n-tab-title, .elementor-tab-title');

		const clickTitleWithAnchor = (anchor) => {
		tabsAccordionToggleTitles.forEach(title => {
		if (title.querySelector(`#${anchor}`) != null || title.id === anchor || (title.closest('details') && title.closest('details').id === anchor)) {
		if (title.getAttribute('aria-expanded') !== 'true' && !title.classList.contains('elementor-active')) {
		title.click();
		// Evita que el foco quede atrapado en el tab tras el click simulado
		setTimeout(() => {
		const activo = document.activeElement;
		if (activo && (activo === title || title.contains(activo))) activo.blur();
		}, 0);
		}
		}
		});
		};

		document.addEventListener('click', (event) => {
		if (event.target.closest('a') && event.target.closest('a').href.includes('#')) {
		const anchor = extractAnchor(event.target.closest('a').href);
		if (anchor && isAnchorInTitles(anchor, tabsAccordionToggleTitles)) {
		event.preventDefault();
		clickTitleWithAnchor(anchor);
		}
		}
		}, true);

		const currentAnchor = extractAnchor(window.location.href);
		if (currentAnchor) {
		clickTitleWithAnchor(currentAnchor);
		}

		function extractAnchor(url) {
		const match = url.match(/#([^?]+)/);
		return match ? match[1] : null;
		};

		function isAnchorInTitles(anchor, titles) {
		return Array.from(titles).some(title => {
		return title.querySelector(`#${anchor}`) !== null || title.id === anchor || (title.closest('details') && title.closest('details').id === anchor);
		});
		};

	}, 100);
});
</script>
