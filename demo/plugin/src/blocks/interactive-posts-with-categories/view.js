/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from '@wordpress/interactivity';

store( 'wpinteractivitydemo-plugin/posts-with-categories', {
	state: {
		get isCategoryActive() {
			console.log(getContext().selected, getElement().ref.dataset.category);

			return getContext().selected === getElement().ref.dataset.category;
		}
	},
	actions: {
		selectCategory() {
			const ctx = getContext();
			const { ref } = getElement();

			ctx.selected = ref.dataset.category;

			if (ctx.selected === '') {
				ctx.posts.map(post => post.visible = true);
			} else {
				ctx.posts.map(post => {
					post.visible = ctx.selected === post.category__slug
				});
			}
		}
	},
} );
