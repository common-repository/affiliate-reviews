import {
	Button,
	Panel,
	PanelBody,
	PanelRow,
	ColorPalette,
	SelectControl,
	TabPanel,
	TextControl,
	__experimentalUnitControl as UnitControl,
	__experimentalBoxControl as BoxControl
} from "@wordpress/components";
import { useEntityProp } from "@wordpress/core-data";
import { useDispatch, useSelect, dispatch } from "@wordpress/data";
import { Icon, check } from "@wordpress/icons";
import { ContrastChecker } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";

const SettingsSidebar = () => {
	// Get settings data with useEntityProp
	const [vsettings, setVsettings] = useEntityProp(
		"root",
		"site",
		"affreviews_visual_settings"
	);

	const { saveEditedEntityRecord } = useDispatch("core");

	return (
		<div className="affr-admin-visual-sidebar">
			<TabPanel
				className="settings-panel"
				activeClass="is-active"
				tabs={[
					{
						name: "visual-settings-tab",
						title: "Visual Settings",
						className: "visual-settings-tab",
						content: <VisualSettingsTab />
					},
					{
						name: "general-settings-tab",
						title: "General Settings",
						className: "",
						content: <GeneralSettingsTab />
					}
				]}
			>
				{({ title, content, className }) => (
					<div className={className}>{content}</div>
				)}
			</TabPanel>
			<div className="affr-admin-save-wrapper">
				<Button
					variant="primary"
					onClick={() => {
						// Update the state
						setVsettings({ ...vsettings });

						// Save on DB
						saveEditedEntityRecord("root", "site");

						// Notification
						dispatch("core/notices").createNotice(
							"success",
							__("Settings Saved", "affreviews"),
							{
								type: "snackbar",
								isDismissible: true
							}
						);
					}}
				>
					Save settings
				</Button>
			</div>
		</div>
	);
};

const VisualSettingsTab = () => {
	const colors = [
		{ name: "Red", color: "#e02928" },
		{ name: "Green", color: "#4dbc24" },
		{ name: "White", color: "#fff" },
		{ name: "Black", color: "#444" }
	];

	// Get settings data with useEntityProp
	const [vsettings, setVsettings] = useEntityProp(
		"root",
		"site",
		"affreviews_visual_settings"
	);

	const button_color =
		vsettings && vsettings.button_color ? vsettings.button_color : "";
	const button_text_color =
		vsettings && vsettings.button_text_color ? vsettings.button_text_color : "";
	const button_radius =
		vsettings && vsettings.button_radius ? vsettings.button_radius : "";
	const button_padding =
		vsettings && vsettings.button_padding ? vsettings.button_padding : "";
	const button_font_weight =
		vsettings && vsettings.button_font_weight
			? vsettings.button_font_weight
			: "";
	const button_font_size =
		vsettings && vsettings.button_font_size ? vsettings.button_font_size : "";
	const thumbnail_style =
		vsettings && vsettings.thumbnail_style ? vsettings.thumbnail_style : "";
	const secondary_color =
		vsettings && vsettings.secondary_color ? vsettings.secondary_color : "";
	const rating_color =
		vsettings && vsettings.rating_color ? vsettings.rating_color : "";
	const link_color =
		vsettings && vsettings.link_color ? vsettings.link_color : "";
	const box_bg_color =
		vsettings && vsettings.box_bg_color ? vsettings.box_bg_color : "";
	const text_color =
		vsettings && vsettings.text_color ? vsettings.text_color : "";

	return (
		<Panel header="">
			<PanelBody title="Colors" initialOpen={false}>
				<PanelRow className="affr-panel-row">
					<label className="affr-admin-label">Secondary Color (icons)</label>
					<ColorPalette
						colors={colors}
						clearable={false}
						value={secondary_color}
						onChange={(color) => {
							setVsettings({ ...vsettings, secondary_color: color });
							updateRootVars({ ...vsettings, secondary_color: color });
						}}
					/>
				</PanelRow>
				<br />
				<PanelRow className="affr-panel-row">
					<label className="affr-admin-label">Rating Color</label>
					<ColorPalette
						colors={colors}
						clearable={false}
						value={rating_color}
						onChange={(color) => {
							setVsettings({ ...vsettings, rating_color: color });
							updateRootVars({ ...vsettings, rating_color: color });
						}}
					/>
				</PanelRow>
				<br />
				<PanelRow className="affr-panel-row">
					<label className="affr-admin-label">Text Link Color</label>
					<ColorPalette
						colors={colors}
						clearable={false}
						value={link_color}
						onChange={(color) => {
							setVsettings({ ...vsettings, link_color: color });
							updateRootVars({ ...vsettings, link_color: color });
						}}
					/>
				</PanelRow>
				<br />
				<PanelRow className="affr-panel-row">
					<label className="affr-admin-label">Box Background Color</label>
					<ColorPalette
						colors={colors}
						clearable={false}
						value={box_bg_color}
						onChange={(color) => {
							setVsettings({ ...vsettings, box_bg_color: color });
							updateRootVars({ ...vsettings, box_bg_color: color });
						}}
					/>
				</PanelRow>
				<br />
				<PanelRow className="affr-panel-row">
					<label className="affr-admin-label">Text Color</label>
					<ColorPalette
						colors={colors}
						clearable={false}
						value={text_color}
						onChange={(color) => {
							setVsettings({ ...vsettings, text_color: color });
							updateRootVars({ ...vsettings, text_color: color });
						}}
					/>
				</PanelRow>
			</PanelBody>
			<PanelBody title="Buttons" initialOpen={false}>
				<PanelRow className="affr-panel-row">
					<label className="affr-admin-label">Button Color</label>
					<ColorPalette
						colors={colors}
						clearable={false}
						value={button_color}
						onChange={(color) => {
							setVsettings({ ...vsettings, button_color: color });
							updateRootVars({ ...vsettings, button_color: color });
						}}
					/>
				</PanelRow>
				<br />
				<PanelRow className="affr-panel-row">
					<label className="affr-admin-label">Button Text Color</label>
					<ColorPalette
						colors={colors}
						clearable={false}
						value={button_text_color}
						onChange={(color) => {
							setVsettings({ ...vsettings, button_text_color: color });
							updateRootVars({ ...vsettings, button_text_color: color });
						}}
					/>
				</PanelRow>
				<ContrastChecker
					backgroundColor={button_color}
					textColor={button_text_color}
				/>
				<br />
				<PanelRow className="affr-panel-row">
					<label className="affr-admin-label">Button Border Radius</label>
					<UnitControl
						onChange={(radius) => {
							setVsettings({ ...vsettings, button_radius: radius });
							updateRootVars({ ...vsettings, button_radius: radius });
						}}
						value={button_radius}
						min="0"
					/>
				</PanelRow>
				<br />
				<PanelRow className="affr-panel-row">
					<BoxControl
						label="Button Padding"
						values={button_padding}
						splitOnAxis={true}
						resetValues={button_padding}
						onChange={(padding) => {
							setVsettings({ ...vsettings, button_padding: padding });
							updateRootVars({ ...vsettings, button_padding: padding });
						}}
					/>
				</PanelRow>
				<br />
				<PanelRow className="affr-panel-row">
					<SelectControl
						label="Button Font Weight"
						value={button_font_weight}
						options={[
							{ label: "100", value: "100" },
							{ label: "200", value: "200" },
							{ label: "300", value: "300" },
							{ label: "400", value: "400" },
							{ label: "500", value: "500" },
							{ label: "600", value: "600" },
							{ label: "700", value: "700" },
							{ label: "800", value: "800" },
							{ label: "900", value: "900" }
						]}
						onChange={(font_weight) => {
							setVsettings({
								...vsettings,
								button_font_weight: font_weight
							});
							updateRootVars({ ...vsettings, button_font_weight: font_weight });
						}}
					/>
				</PanelRow>
				<br />
				<PanelRow className="affr-panel-row">
					<label className="affr-admin-label">Button Font Size</label>
					<UnitControl
						onChange={(font_size) => {
							setVsettings({ ...vsettings, button_font_size: font_size });
							updateRootVars({ ...vsettings, button_font_size: font_size });
						}}
						value={button_font_size}
						min="0"
					/>
				</PanelRow>
			</PanelBody>

			<PanelBody title="Thumbnails" initialOpen={false}>
				<PanelRow className="affr-panel-row">
					<SelectControl
						label="Thumbnail Style"
						value={thumbnail_style}
						options={[
							{ label: "Box", value: "logo-box" },
							{ label: "Circle", value: "logo-circle" },
							{ label: "Plain", value: "logo-plain" }
						]}
						onChange={(newThumbnailStyle) =>
							setVsettings({
								...vsettings,
								thumbnail_style: newThumbnailStyle
							})
						}
						__nextHasNoMarginBottom
					/>
				</PanelRow>
			</PanelBody>
		</Panel>
	);
};

const GeneralSettingsTab = () => {
	// Get settings data with useEntityProp
	const [gsettings, setGsettings] = useEntityProp(
		"root",
		"site",
		"affreviews_general_settings"
	);

	const reviews_visibility = gsettings ? gsettings.reviews_visibility : "";
	const reviews_slug = gsettings ? gsettings.reviews_slug : "";

	return (
		<Panel header="">
			<PanelBody title="Reviews Post Type" initialOpen={true}>
				<PanelRow className="affr-panel-row">
					<SelectControl
						label="Reviews Post Type Visibility"
						help="By default Reviews are used only as a data store and can be used with the available custom blocks. If you make it public then each Review will have it's own unique URL."
						value={reviews_visibility}
						options={[
							{ label: "Reviews private", value: "hidden" },
							{ label: "Reviews public", value: "visible" }
						]}
						onChange={(val) =>
							setGsettings({
								...gsettings,
								reviews_visibility: val
							})
						}
					/>
				</PanelRow>
				{reviews_visibility === "visible" && (
					<PanelRow className="affr-panel-row">
						<TextControl
							label="Reviews Slug"
							help="When Reviews are public this is the slug that is going to be used for the permalinks. (After a change please make sure to update your permalinks)"
							value={reviews_slug}
							onChange={(val) =>
								setGsettings({ ...gsettings, reviews_slug: val })
							}
						/>
					</PanelRow>
				)}
			</PanelBody>
		</Panel>
	);
};

// Update root CSS vars
const updateRootVars = (vsettings) => {
	if (vsettings.button_color) {
		document.documentElement.style.setProperty(
			"--affr-button-color",
			vsettings.button_color
		);
	}
	if (vsettings.button_text_color) {
		document.documentElement.style.setProperty(
			"--affr-button-text-color",
			vsettings.button_text_color
		);
	}
	if (vsettings.button_radius) {
		document.documentElement.style.setProperty(
			"--affr-button-radius",
			vsettings.button_radius
		);
	}
	if (vsettings.button_padding) {
		document.documentElement.style.setProperty(
			"--affr-button-padding",
			`${vsettings.button_padding.bottom} ${vsettings.button_padding.right} ${vsettings.button_padding.bottom} ${vsettings.button_padding.left}`
		);
	}
	if (vsettings.button_font_weight) {
		document.documentElement.style.setProperty(
			"--affr-button-font-weight",
			vsettings.button_font_weight
		);
	}
	if (vsettings.button_font_size) {
		document.documentElement.style.setProperty(
			"--affr-button-font-size",
			vsettings.button_font_size
		);
	}
	if (vsettings.secondary_color) {
		document.documentElement.style.setProperty(
			"--affr-secondary-color",
			vsettings.secondary_color
		);
	}
	if (vsettings.rating_color) {
		document.documentElement.style.setProperty(
			"--affr-rating-color",
			vsettings.rating_color
		);
	}
	if (vsettings.link_color) {
		document.documentElement.style.setProperty(
			"--affr-link-color",
			vsettings.link_color
		);
	}
	if (vsettings.box_bg_color) {
		document.documentElement.style.setProperty(
			"--affr-box-bg-color",
			vsettings.box_bg_color
		);
	}
	if (vsettings.text_color) {
		document.documentElement.style.setProperty(
			"--affr-text-color",
			vsettings.text_color
		);
	}
};

export default SettingsSidebar;
