import * as React from 'react';
import { Button } from '@material-ui/core';
import Container from '@material-ui/core/Container';
import TextField from '@material-ui/core/TextField';

interface IAddFormProps {
	onSubmit?: (arg: any) => void;
	onCancel?: () => void;
}

export class AddForm extends React.Component<IAddFormProps> {

	#pullFormData = () => {
		const data = new FormData();
		if (this.props?.onSubmit) {
			this.props?.onSubmit(data);
		}
	};

	render() {
		return (
			<Container>
				<div>Создать новый рейс</div>
				<form noValidate autoComplete="off">
					<div>
						<div>
							<div>Город отправления</div>
							<TextField variant="outlined"/>
						</div>
						<div>
							<div>Город прибытия</div>
							<TextField variant="outlined"/>
						</div>
						<div>
							<div>Номер рейса</div>
							<TextField variant="outlined"/>
						</div>
						<div>
							<div>Количество пассажиров</div>
							<TextField variant="outlined" type="number"/>
						</div>
					</div>
				</form>
				<div className="btn-block">
					<Button
						variant="contained"
						color="primary"
						onClick={this.#pullFormData}
					>
						Создать
					</Button>
					<Button variant="contained" color="secondary">Отмена</Button>
				</div>
			</Container>
		);
	}
}
