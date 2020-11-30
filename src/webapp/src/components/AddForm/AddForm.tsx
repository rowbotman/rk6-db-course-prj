import * as cn from 'classnames';
import * as React from 'react';

import Button from '@material-ui/core/Button';
import Container from '@material-ui/core/Container';
import TextField from '@material-ui/core/TextField';

import * as s from './AddForm.scss';
import * as f from 'Styles/_font.scss';

import { parseFromData } from 'Utils';
import { IMap } from 'Interfaces';

interface IAddFormProps {
	onSubmit?: (arg: IMap) => void;
	onCancel?: () => void;
}

interface IRow {
	desc: string;
	type: 'number' | 'text';
	name: string;
}

export class AddForm extends React.Component<IAddFormProps> {

	#myRef = React.createRef<HTMLFormElement>();

	#pullFormData = () => {
		if (this.props?.onSubmit) {
			const parsed = parseFromData(this.#myRef.current);
			this.props?.onSubmit(parsed);
		}
	};

	#onCancel = () => {
		if (this.props?.onCancel) {
			this.props.onCancel();
		}
	};

	get fields(): IRow[] {
		return [
			{
				desc: 'Город отправления',
				type: 'text',
				name: 'departure',
			},
			{
				desc: 'Город прибытия',
				type: 'text',
				name: 'arrival',
			},
			{
				desc: 'Номер рейса',
				type: 'text',
				name: 'flight',
			},
			{
				desc: 'Количество пассажиров',
				type: 'number',
				name: 'passengers',
			},
		];
	}

	render(): JSX.Element {
		return (
			<Container className={s.addForm}>
				<div className={s.addForm__title}>
					<span className={cn(f.font, f.font_size_large, f.font_bold)}>Создать новый рейс</span>
				</div>
				<form noValidate autoComplete="off" ref={this.#myRef}>
					{this.fields.map(({ desc, type, name }, idx) => (
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
