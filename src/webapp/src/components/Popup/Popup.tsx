import * as React from 'react';

export class Popup extends React.Component<{}> {

	#onClick = () => {
		console.log('might to close popup');
		// if (this.props?.onClose) {
		// 	this.props.onClose();
		// }
	};

	render() {
		return (
			<div className="popup">
				<div className="popup__header">
					<div className="popup__title">{this.props.title}</div>
					<i
						className="icon icon_btn icon_color_black icon_type_cross icon_size_small"
						onClick={this.#onClick}
					/>
				</div>
				<hr/>
				<div className="popup__info">
					<div className="popup__text">{this.props?.text || ''}</div>
					{this.props?.children}
				</div>
			</div>
		);
	}

}
