import * as React from 'react';
import { IFlight } from 'Interfaces';
import { FlightForm } from 'Components/FlightForm';

import { CHANGE_BOOK_FIELDS } from './types';
import * as s from './ChangeBook.scss';
import { FlightNetwork } from 'Network';
import { parseFromData } from 'Utils';
import { IFlightChangeInfo } from 'Interfaces/IFlightChangeInfo';

export interface IChangeBookProps extends IFlight {
	onCancel?: () => void;
	onSubmit?: () => void;
}

export interface IChangeBookState {
}

export class ChangeBook extends React.Component<IChangeBookProps, IChangeBookState> {

	#formRef = React.createRef<HTMLFormElement>();
	#api = new FlightNetwork();

	async onSubmit() {
		try {
			const parsed = parseFromData(this.#formRef.current);
			const info = parsed as unknown as IFlightChangeInfo;
			const res = await this.#api.changeBook(this.props.id, info);
			if (res.hasOwnProperty('error')) {
				this.setState({ error: true, loading: false });
			} else {
				this.setState({ error: false, loading: false });
			}
		} catch (e) {
			console.error(e);
			this.setState({error: true});
		}
	}

	onCancel() {
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
