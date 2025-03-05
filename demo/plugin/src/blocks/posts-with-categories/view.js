/**
 * Use this file for JavaScript code that you want to run in the front-end
 * on posts/pages that contain this block.
 *
 * When this file is defined as the value of the `viewScript` property
 * in `block.json` it will be enqueued on the front end of the site.
 *
 * Example:
 *
 * ```js
 * {
 *   "viewScript": "file:./view.js"
 * }
 * ```
 *
 * If you're not making any changes to this file because your project doesn't need any
 * JavaScript running in the front-end, then you should delete this file and remove
 * the `viewScript` property from `block.json`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
 */

class PostsWithCategories {
	/** @type {NodeListOf<HTMLButtonElement>} #categoriesButtons */
	#categoriesButtons;

	/** @type {NodeListOf<HTMLElement>} #postsArticles */
	#postsArticles;

	/**
	 * @param {HTMLDivElement} container
	 */
	constructor (container) {
		this.#categoriesButtons = container.querySelectorAll('.categories button');
		this.#postsArticles = container.querySelectorAll('.posts article');

		this.#categoriesButtons.forEach(button => button.addEventListener('click', () => {
			this.handleCategoriesButtonClick(button);
		}));
	}

	/**
	 * @param {HTMLButtonElement} button
	 */
	handleCategoriesButtonClick(button) {
		// Update buttons classes
		this.#categoriesButtons.forEach(categoryButton => categoryButton.classList.remove('active'));
		button.classList.add('active');

		// Filter (and fetch) posts
		const category = button.dataset.category;

		if (category.length === 0) {
			this.#postsArticles.forEach(article => article.closest('li').removeAttribute('hidden'));

			return;
		}

		this.#postsArticles.forEach(article => {
			/** @type {HTMLLIElement} parentListElement */
			const parentListElement = article.closest('li');

			const articleCategory = parentListElement.dataset.category;

			if (articleCategory === category) {
				parentListElement.removeAttribute('hidden');
			} else {
				parentListElement.setAttribute('hidden', 'hidden');
			}
		});
	}
}

document.addEventListener('DOMContentLoaded', () => {
	const postsWithCategoriesBlocks = document.querySelectorAll('.wp-block-wpinteractivitydemo-plugin-posts-with-categories');

	postsWithCategoriesBlocks.forEach(block => new PostsWithCategories(block));
});
