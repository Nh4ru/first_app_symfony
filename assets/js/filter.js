import { debounce } from "lodash";

/**
 * Class filter for search post in ajax
 * 
 * @property {HTMLElement} pagination - the pagination element
 * @property {HTMLElement} content - the pagination element
 * @property {HTMLElement} sortable - the sortable element
 * @property {HTMLFormElement} form - the count element
 * @property {HTMLElement} count - The count element
 * @property {HTMLElement} page - The page number
 * @property {bool} moreNav - If the navigation is with button show more
 */
export default class Filter
{
    /**
     * @param {HTMLElement} element - the parent element of the page of research 
     */
    constructor(element) {
        if (element == null) {
            return;
        }

        this.pagination = element.querySelector('.js-filter-pagination');
        this.content = element.querySelector('.js-filter-content');
        this.sortable = element.querySelector('.js-filter-sortable');
        this.form = element.querySelector('.js-filter-form');
        this.count = element.querySelector('.js-filter-count');
        this.page = parseInt(new URLSearchParams(window.location.search).get('page') || 1);
        this.moreNav = this.page == 1;
        this.bindEvents();
    }

    /**
     * Add actions to the elements
     */
    bindEvents() {
        /* Action sur les liens sortable */
        const linkClickListener = (e) => {
            // Si l'element est une balise <a></a> OU <i></i>
            if (e.target.tagName === 'A' || e.target.tagName === 'I') {
                e.preventDefault();

                let url = '';

                if (e.target.tagName === 'I') {
                    url = e.target.parentNode.parentNode.getAttribute('href');
                } else {
                    url = e.target.getAttribute('href');
                }
                
                this.loadUrl(url);
            }
        }

        if (this.moreNav) {
            this.pagination.innerHTML = `<button class="btn btn-primary mt-2 btn-show-more">Voir Plus</button>`;
            this.pagination.querySelector('button').addEventListener('click', this.loadMore.bind(this));
        } else {
            this.pagination.addEventListener('click', linkClickListener);
        }

        this.sortable.addEventListener('click', (e) => {
            linkClickListener(e);
        });

        /* Action sur le formulaire */
        this.form.querySelectorAll('input[type="text"]').forEach((input) => {
            input.addEventListener('keyup', debounce(this.loadForm.bind(this), 400));
        });

        this.form.querySelectorAll('input[type="checkbox"]').forEach((input) => {
            input.addEventListener('change', debounce(this.loadForm.bind(this), 600));
        });
    }

    /**
     * Load more elements on the page
     */
    async loadMore() {
        const button = this.pagination.querySelector('button');
        button.setAttribute('disabled', 'disabled');

        this.page++;

        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);
        params.set('page', this.page);

        await this.loadUrl(url.pathname + '?' + params.toString(), true);

        button.removeAttribute('disabled');
    }

    async loadForm() {
        this.page = 1;
        
        const data = new FormData(this.form);
        const url = new URL(this.form.getAttribute('action') || window.location.href);
        const params = new URLSearchParams();

        data.forEach((value, key) => {
            params.append(key, value);
        });

        return this.loadUrl(url.pathname + '?' + params.toString()); 
    }

    async loadUrl(url, append = false) {
        this.showLoader();
        
        const params = new URLSearchParams(url.split('?')[1] || '');
        params.set('ajax', 1);

        const response = await fetch(url.split('?')[0] + '?' + params.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })

        // const response = await fetch(`${url.split('?')[0]}?${params.toString()}`, {
        //     headers: {
        //         'X-Requested-With': 'XMLHttpRequest',
        //     }
        // })

        if (response.status >= 200 && response.status < 300) {

            const data = await response.json();
            console.error(data);

            if (append) {
                this.content.innerHTML += data.content;
            } else {
                this.content.innerHTML = data.content;
            }

            if (!this.moreNav) {
                this.pagination.innerHTML = data.pagination;
            } else if (this.page == data.pages) {
                this.pagination.style.display = 'none';
            } else {
                this.pagination.style.display = null;
            }

            this.sortable.innerHTML = data.sortable;
            this.count.innerHTML = data.count;

            params.delete('ajax'),
            history.replaceState({}, '', url.split('?')[0] + '?' + params.toString());
            
        } else {
            console.error(response);
        }

        this.hideLoader();
    }

    /**
     * Function to show the loader's animation
     */
    showLoader() {
        this.form.classList.add('is-loading');

        const loader = this.form.querySelector('.js-loading');

        if (loader == null) {
            return;
        }

        loader.setAttribute('aria-hidden', false);
        loader.style.display = null;
    }

    /**
     * Function to hide the loader
     */
    hideLoader() {
        this.form.classList.remove('is-loading');

        const loader = this.form.querySelector('.js-loading');

        if (loader == null) {
            return;
        }

        loader.setAttribute('aria-hidden', true);
        loader.style.display = 'none';
    }
}
