import * as cn from 'classnames';
import * as React from 'react';

import * as s from './Popup.scss';

import * as i from 'Styles/icon.scss';

export interface IPopupProps {
	title: string;
	text?: string;
	onClose?: () => void;
}

export class Popup extends React.Component<IPopupProps> {

	#onClick = () => {
		console.log('it might close popup');
		if (this.props?.onClose) {
			this.props.onClose();
		}
	};

	render() {
		return (
			<div className={s.popup}>
				<div className={s.popup__container}>
					<div className={s.popup__header}>
						<div className={s.popup__title}>{this.props.title}</div>
						<span className={s.popup__close}>
						<i
							className={cn(i.icon, i.icon_btn, i.icon_type_cross, i.icon_color_black, i.icon_size_small)}
							onClick={this.#onClick}
						/>
					</span>
					</div>
					<div className={s.popup__content}>
						<div className={s.popup__text}>{this.props?.text || ''}</div>
						{this.props?.children}
					</div>
				</div>
			</div>
		);
	}

}
