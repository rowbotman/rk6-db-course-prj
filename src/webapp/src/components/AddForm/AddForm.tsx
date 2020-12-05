import * as cn from 'classnames';
import * as React from 'react';

import Button from '@material-ui/core/Button';
import Container from '@material-ui/core/Container';
import TextField from '@material-ui/core/TextField';

import { parseFromData } from 'Utils';
import { FlightNetwork } from 'Network';

import { IAddFormProps, IAddFormSate, REQUIRED_FIELDS, Status } from './types';

import * as s from './AddForm.scss';
import * as f from 'Styles/_font.scss';

export class AddForm extends React.Component<IAddFormProps, IAddFormSate> {

	#myRef = React.createRef<HTMLFormElement>();
	#api = new FlightNetwork();
	#fields = REQUIRED_FIELDS;

	#pullFormData = async () => {
		const parsed = parseFromData(this.#myRef.current);
		try {
			const res = await this.#api.createFlight(parsed);
			let status = Status.kOK;
			if (res !== {}) {
				status = Status.kErr;
				this.setState({ status });
				return;
			}
			if (this.props?.onSubmit) {
				this.props.onSubmit(parsed['flight'] as string, parsed['passengers'] as number);
			}
			this.setState({ status });
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
		return (
			<Container className={s.addForm}>
				<div className={s.addForm__title}>
					<span className={cn(f.font, f.font_size_large, f.font_bold)}>Создать новый рейс</span>
				</div>
				<form noValidate autoComplete="off" ref={this.#myRef}>
					{this.#fields.map(({ desc, type, name }, idx) => (
						<div className={s.addForm__grid} key={idx}>
							<div className={s.addForm__desc}>{desc}</div>
							<TextField
								name={name}
								type={type}
								className={s.addForm__input}
								size="small"
								variant="outlined"
							/>
						</div>
					))}
				</form>
				<div className={s.addForm__manage}>
					<Button
						className={s.addForm__btn}
						variant="contained"
						color="primary"
						onClick={this.#pullFormData}
					>
						Создать
					</Button>
					<Button
						className={s.addForm__btn}
						variant="contained"
						color="secondary"
						onClick={this.#onCancel}
					>
						Отмена
					</Button>
				</div>
			</Container>
		);
	}
}
