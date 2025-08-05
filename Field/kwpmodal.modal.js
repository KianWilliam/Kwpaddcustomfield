(() => {
    document.addEventListener('DOMContentLoaded', () => {
        // Get the elements

        const gallery_links = document.querySelectorAll('.select-link');
        // Listen for click event
        gallery_links.forEach((element) => {
            element.addEventListener('click', event => {
					//	console.log("boro ..., haha, ou? elles savent");

                event.preventDefault();
                const {
                    target
                } = event;

                let data = {
                    'messageType' : 'joomla:content-select',
                    'id' : target.getAttribute('data-gallery-id'),
                    'title' : target.getAttribute('data-gallery-title')
                };
                window.parent.postMessage(data);
            });
        });
    });
})();