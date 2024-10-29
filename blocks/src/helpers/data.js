const { useSelect } = wp.data;
const { decodeEntities } = wp.htmlEntities;

export const getAllPosts = () => {
	let allPosts = [];

	// querying posts
	const { posts } = useSelect((select) => {
		const { getEntityRecords } = select("core");

		// Query args
		const query = {
			status: "publish",
			per_page: -1
		};

		return {
			posts: getEntityRecords("postType", "affreviews_reviews", query)
		};
	});

	// populate options for <MultiSelectControl>
	if (posts) {
		posts.forEach((page) => {
			allPosts.push({
				value: page.id.toString(),
				label: decodeEntities(page.title.rendered)
			});
		});
	} else {
		allPosts.push({ value: "0", label: "Loading..." });
	}

	return allPosts;
};

export const getAllTerms = () => {
	let allTerms = [];

	// querying posts
	const { terms } = useSelect((select) => {
		const { getEntityRecords } = select("core");

		return {
			terms: getEntityRecords("taxonomy", "affreviews_tax")
		};
	});

	// populate options for <MultiSelectControl>
	if (terms) {
		terms.forEach((term) => {
			allTerms.push({
				value: term.id.toString(),
				label: decodeEntities(term.name)
			});
		});
	} else {
		allTerms.push({ value: "0", label: "Loading..." });
	}

	return allTerms;
};
