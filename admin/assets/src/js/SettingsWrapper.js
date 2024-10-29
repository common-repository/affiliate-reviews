import ServerSideRender from "@wordpress/server-side-render";
import { SnackbarList, Placeholder } from "@wordpress/components";
import { useDispatch, useSelect, dispatch } from "@wordpress/data";
import { store as noticesStore } from "@wordpress/notices";
import { __ } from "@wordpress/i18n";
import SettingsSidebar from "./SettingsSidebar";
import { info } from "@wordpress/icons";

const SettingsWrapper = () => {
	const Notices = () => {
		const notices = useSelect(
			(select) =>
				select(noticesStore)
					.getNotices()
					.filter((notice) => notice.type === "snackbar"),
			[]
		);
		const { removeNotice } = useDispatch(noticesStore);
		return (
			<SnackbarList
				className="edit-site-notices"
				notices={notices}
				onRemove={removeNotice}
			/>
		);
	};

	return (
		<div className="affr-admin-visual-wrapper">
			<div className="affr-admin-visual-editor">
				<div className="affr-admin-visual-container">
					<ServerSideRender
						block="affreviews/table"
						EmptyResponsePlaceholder={() => (
							<Placeholder
								icon={info}
								label={__("Reviews Table Preview", "affreviews")}
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
			</div>
			<SettingsSidebar />
			<Notices />
		</div>
	);
};

export default SettingsWrapper;
