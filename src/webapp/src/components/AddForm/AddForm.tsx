import * as React from 'react';
import { Button } from '@material-ui/core';

interface IAddFormProps {
}

export class AddForm extends React.Component<IAddFormProps> {

	render() {
		return (
			<div>
				<div>Создать новый рейс</div>
				<form>
					<input type="number"/>
					<input type="number"/>
					<input type="number"/>
				</form>
				<div className="btn-block">
					<Button color="primary">Создать</Button>
					<Button color="secondary">Отмена</Button>
				</div>
			</div>
		);
	}
}
