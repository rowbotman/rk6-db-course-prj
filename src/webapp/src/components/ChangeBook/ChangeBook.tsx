import * as React from 'react';
import { IFlight } from 'Interfaces';
import { FlightForm } from 'Components/FlightForm';
import { REQUIRED_FIELDS } from 'Components/AddForm/types';

import * as s from './ChangeBook.scss';

export interface IChangeBookProps extends IFlight {
	onCancel?: () => void;
}

export interface IChangeBookState {
}

export class ChangeBook extends React.Component<IChangeBookProps, IChangeBookState> {

	#formRef = React.createRef<HTMLFormElement>();

	onSubmit() {
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
					fields={REQUIRED_FIELDS}
					onSubmit={this.onSubmit.bind(this)}
					onCancel={this.onCancel.bind(this)}
				/>
			</div>
		);
	}

}
