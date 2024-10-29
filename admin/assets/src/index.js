import "./scss/affreviews-admin.scss";
import { render } from "@wordpress/element";
import SettingsWrapper from "./js/SettingsWrapper.js";

if (document.getElementById("affreviews-visual-settings")) {
	render(
		<SettingsWrapper />,
		document.getElementById("affreviews-visual-settings")
	);
}
