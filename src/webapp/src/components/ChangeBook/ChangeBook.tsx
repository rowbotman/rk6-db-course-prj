import * as React from 'react';
import { IFlight } from 'Interfaces';
import { FlightForm } from 'Components/FlightForm';
import { REQUIRED_FIELDS } from 'Components/AddForm/types';

import * as s from './ChangeBook.scss';

export interface IChangeBookProps extends IFlight {
}

export interface IChangeBookState {
}

export class ChangeBook extends React.Component<IChangeBookProps, IChangeBookState> {

	#formRef = React.createRef<HTMLFormElement>();

	onSubmit() {
	}

	onCancel() {
	}

	render(): JSX.Element {
		return (
			<div className={s.changeBook}>
				<FlightForm
					myRef={this.#formRef}
					fields={REQUIRED_FIELDS}
					onSubmit={this.onSubmit}
					onCancel={this.onCancel}
				/>
			</div>
		);
	}

}
