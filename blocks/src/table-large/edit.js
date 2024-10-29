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
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

const {
	PanelBody,
	__experimentalNumberControl,
	ToggleControl,
	SelectControl,
	TextControl,
	Placeholder
} = wp.components;

const NumberControl = __experimentalNumberControl;

import ServerSideRender from "@wordpress/server-side-render";
import { MultiSelectControl } from "@codeamp/block-components";
import { getAllPosts, getAllTerms } from "../helpers/data";
import { info } from "@wordpress/icons";

export default function Edit(props) {
	const { attributes, setAttributes } = props;
	const {
		num,
		maxProsCons,
		orderby,
		order,
		counter,
		categories,
		selectedPosts,
		buttonText,
		reviewLinkText
	} = attributes;
	const allPosts = getAllPosts();
	const allTerms = getAllTerms();

	return [
		<InspectorControls>
			<PanelBody title="Settings">
				<div class="components-base-control">
					<NumberControl
						label="Number of items"
						min="-1"
						onChange={(val) => setAttributes({ num: val })}
						value={num}
					/>
				</div>
				<MultiSelectControl
					value={selectedPosts}
					options={allPosts}
					onChange={(val) => setAttributes({ selectedPosts: val })}
					label="Specify reviews"
				/>
				<MultiSelectControl
					value={categories}
					options={allTerms}
					onChange={(val) => setAttributes({ categories: val })}
					label="Categories"
					help="By selecting a category you will show reviews only from this specific category."
				/>
				<SelectControl
					label="Order by"
					value={orderby}
					options={[
						{ value: "rating", label: "Rating" },
						{ value: "date", label: "Date" },
						{ value: "title", label: "Title" },
						{ value: "rand", label: "Random" }
					]}
					onChange={(val) => setAttributes({ orderby: val })}
				/>
				<SelectControl
					label="Order"
					value={order}
					options={[
						{ value: "desc", label: "Desc" },
						{ value: "asc", label: "Asc" }
					]}
					onChange={(val) => setAttributes({ order: val })}
				/>
				<ToggleControl
					label="Counter"
					help={
						counter
							? "In each affiliate item a counter is visible."
							: "In each affiliate item a counter is hidden."
					}
					checked={counter}
					onChange={(val) => {
						setAttributes({ counter: val });
					}}
				/>
				<div class="components-base-control">
					<NumberControl
						label="Max number of Pros/Cons"
						min="1"
						onChange={(val) => setAttributes({ maxProsCons: val })}
						value={maxProsCons}
					/>
				</div>
				<TextControl
					label="Button text"
					value={buttonText}
					onChange={(val) => setAttributes({ buttonText: val })}
				/>
				<TextControl
					label="Review link text"
					help="The review link is visible only for the reviews with a valid link."
					value={reviewLinkText}
					onChange={(val) => setAttributes({ reviewLinkText: val })}
				/>
			</PanelBody>
		</InspectorControls>,
		<div {...useBlockProps()}>
			<ServerSideRender
				block="affreviews/table-large"
				attributes={attributes}
				EmptyResponsePlaceholder={() => (
					<Placeholder
						icon={info}
						label={__("Reviews Table Large Info", "affreviews")}
					>
						<div
							dangerouslySetInnerHTML={{
								__html: __(
									`Please add a few reviews in order for the preview to work, go to: <a href='/wp-admin/post-new.php?post_type=affreviews_reviews'>Add new review</a>`,
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
