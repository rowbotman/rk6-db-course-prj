import * as cn from 'classnames';
import * as React from 'react';

import Container from '@material-ui/core/Container';

import { parseFromData } from 'Utils';
import { FlightNetwork } from 'Network';

import { IAddFormProps, IAddFormSate, REQUIRED_FIELDS, Status } from './types';

import * as s from './AddForm.scss';
import * as f from 'Styles/_font.scss';
import { FlightForm } from 'Components/FlightForm';

export class AddForm extends React.Component<IAddFormProps, IAddFormSate> {

	#myRef = React.createRef<HTMLFormElement>();
	#api = new FlightNetwork();
	state: IAddFormSate = {
		status: Status.kOK,
	};

	#pullFormData = async () => {
		const parsed = parseFromData(this.#myRef.current);
		try {
			const res = await this.#api.createFlight(parsed);
			let status = Status.kOK;
			if (res.hasOwnProperty('error')) {
				status = Status.kErr;
				this.setState({ status });
				return;
			}
			if (this.props?.onSubmit) {
				this.props.onSubmit(parsed['flight'] as string, parsed['passengers'] as number);
			}
		} catch (e) {
			this.setState({ status: Status.kErr });
			console.error(e);
		}

	};

	#onCancel = () => {
		if (this.props?.onCancel) {
			this.props.onCancel();
		}
	};

	render(): JSX.Element {
		const { status } = this.state;
		return (
			<Container className={s.addForm}>
				<div className={s.addForm__title}>
					<span className={cn(f.font, f.font_size_large, f.font_bold)}>Создать новый рейс</span>
				</div>
				<FlightForm
					fields={REQUIRED_FIELDS}
					myRef={this.#myRef}
					status={status}
					onSubmit={this.#pullFormData}
					onCancel={this.#onCancel}
				/>
			</Container>
		);
	}
}
