import * as cn from 'classnames';
import * as React from 'react';

import Button from '@material-ui/core/Button';
import Container from '@material-ui/core/Container';
import TextField from '@material-ui/core/TextField';

import * as s from './AddForm.scss';
import * as f from 'Styles/_font.scss';

interface IAddFormProps {
	onSubmit?: (arg: any) => void;
	onCancel?: () => void;
}

interface IRow {
	desc: string;
	type: 'number' | 'text';
}

export class AddForm extends React.Component<IAddFormProps> {

	#pullFormData = () => {
		const data = new FormData();
		if (this.props?.onSubmit) {
			this.props?.onSubmit(data);
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
			},
			{
				desc: 'Город прибытия',
				type: 'text',
			},
			{
				desc: 'Номер рейса',
				type: 'text',
			},
			{
				desc: 'Количество пассажиров',
				type: 'number',
			},
		];
	}

	render(): JSX.Element {
		return (
			<Container className={s.addForm}>
				<div className={s.addForm__title}>
					<span className={cn(f.font, f.font_size_large, f.font_bold)}>Создать новый рейс</span>
				</div>
				<form noValidate autoComplete="off">
					{this.fields.map(({ desc, type }, idx) => (
						<div className={s.addForm__grid}>
							<div className={s.addForm__desc}>{desc}</div>
							<TextField type={type} className={s.addForm__input} size="small" variant="outlined"/>
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
