import * as React from 'react';

import { IBooking, IFlightChangeInfo } from 'Interfaces';

import { FlightNetwork } from 'Network';

import { parseFromData } from 'Utils';

import { FlightForm } from 'Components/FlightForm';

import { CHANGE_BOOK_FIELDS } from './types';
import * as s from './ChangeBook.scss';

export interface IChangeBookProps extends IBooking {
	onCancel?: () => void;
	onSubmit?: (booking: IBooking) => void;
}

export interface IChangeBookState {
	booking: IBooking;
	error: boolean,
	loading: boolean,
}

export class ChangeBook extends React.Component<IChangeBookProps, IChangeBookState> {

	state: IChangeBookState = {
		booking: {
			orderId: this.props.orderId,
			lastName: this.props.lastName,
		},
		loading: false,
		error: false,
	};

	#formRef = React.createRef<HTMLFormElement>();
	#api = new FlightNetwork();

	async onSubmit() {
		try {
			const parsed = parseFromData(this.#formRef.current);
			const info = parsed as unknown as IFlightChangeInfo;
			const res = await this.#api.changeBooking(this.props.orderId, info);
			if (res.hasOwnProperty('error')) {
				this.setState({ error: true, loading: false });
			} else {
				this.setState({
					booking: res,
					error: false,
					loading: false,
				});
				if (this.props?.onSubmit) {
					this.props.onSubmit(res);
				}
			}
		} catch (e) {
			console.error(e);
			this.setState({ error: true });
		}
	}

	onCancel() {
		console.log('click');
		if (this.props?.onCancel) {
			this.props.onCancel();
		}
	}

	render(): JSX.Element {
		return (
			<div className={s.changeBook}>
				<FlightForm
					myRef={this.#formRef}
					fields={CHANGE_BOOK_FIELDS}
					onSubmit={this.onSubmit.bind(this)}
					onCancel={this.onCancel.bind(this)}
				/>
			</div>
		);
	}

}
