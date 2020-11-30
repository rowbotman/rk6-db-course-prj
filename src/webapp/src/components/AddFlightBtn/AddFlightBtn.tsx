import * as React from 'react';

import Button from '@material-ui/core/Button';

interface IAddFlightBtnProps {
	onClick?: () => void;
}

export class AddFlightBtn extends React.Component<IAddFlightBtnProps> {
	render() {
		return (
			<Button
				variant="contained"
				color="primary"
				onClick={this.props?.onClick}
			>
				Добавить рейс
			</Button>
		);
	}
}
