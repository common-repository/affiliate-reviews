/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * Imports
 */
const { PanelBody, ComboboxControl, TextControl, Placeholder } = wp.components;

const { useSelect } = wp.data;

const { decodeEntities } = wp.htmlEntities;

import { info } from "@wordpress/icons";

import ServerSideRender from "@wordpress/server-side-render";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {
	const { attributes, setAttributes } = props;
	const { infoTitle, selectedPost } = attributes;

	// This is our select for Reviews
	const ReviewsSelect = () => {
		// Get posts data
		const query = {
			per_page: -1,
			status: "publish"
		};

		const { postsRaw } = useSelect((select) => {
			return {
				postsRaw: select("core").getEntityRecords(
					"postType",
					"affreviews_reviews",
					query
				)
			};
		});

		const { postType } = useSelect((select) => {
			return {
				postType: select("core/editor").getCurrentPostType()
			};
		});

		// If data not available do nothing
		if (!postsRaw) return null;

		// Make data in the format we want for the component
		const postsArray = postsRaw.map((item) => {
			return {
				value: item.id,
				label: decodeEntities(item.title.rendered)
			};
		});

		if (postType === "affreviews_reviews") {
			postsArray.unshift({
				value: 0,
				label: "Current Review"
			});
		}

		// Return our component
		return (
			<ComboboxControl
				label="Select Review"
				value={selectedPost}
				onChange={(val) => {
					setAttributes({ selectedPost: val });
				}}
				options={postsArray}
				onFilterValueChange={(inputValue) =>
					postsArray.filter((option) =>
						option.label.toLowerCase().startsWith(inputValue.toLowerCase())
					)
				}
			/>
		);
	};

	return [
		<InspectorControls>
			<PanelBody title="Settings">
				<ReviewsSelect />
				<TextControl
					label="Info Title"
					value={infoTitle}
					onChange={(val) => setAttributes({ infoTitle: val })}
				/>
			</PanelBody>
		</InspectorControls>,
		<div {...useBlockProps()}>
			<ServerSideRender
				block="affreviews/info-list"
				attributes={attributes}
				EmptyResponsePlaceholder={() => (
					<Placeholder
						icon={info}
						label={__("Review Info List Info", "affreviews")}
					>
						<div
							dangerouslySetInnerHTML={{
								__html: __(
									`Please select a review in order for the preview to work, if you haven't created one yet please go to: <a href='/wp-admin/post-new.php?post_type=affreviews_reviews'>Add new review</a>`,
									"affreviews"
								)
							}}
						/>
					</Placeholder>
				)}
			/>
		</div>
	];
}
