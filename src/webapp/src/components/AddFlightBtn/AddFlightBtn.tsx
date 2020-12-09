import * as React from 'react';

import AddIcon from '@material-ui/icons/Add';
import Tooltip from '@material-ui/core/Tooltip';
import IconButton from '@material-ui/core/IconButton';

import * as s from './AddFlightBtn.scss';

interface IAddFlightBtnProps {
	onClick?: () => void;
}

export class AddFlightBtn extends React.Component<IAddFlightBtnProps> {
	render() {
		return (
			<div className={s.addFlightBtn}>
				<Tooltip title="Добавить рейс">
					<IconButton
						onClick={this.props?.onClick}
						color="primary" aria-label="upload picture" component="span"
					>
						<AddIcon fontSize="large"/>
					</IconButton>
				</Tooltip>
			</div>
		);
	}
}
