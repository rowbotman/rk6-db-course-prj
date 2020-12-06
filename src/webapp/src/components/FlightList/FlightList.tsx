import * as React from 'react';

import Table from '@material-ui/core/Table';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TableCell from '@material-ui/core/TableCell';
import TableBody from '@material-ui/core/TableBody';
import TableRow from '@material-ui/core/TableRow';

import { IFlightListProps, RowActions } from './types';
import { IFlight } from 'Interfaces';
import { ReservationRow } from 'Components/ReservationRow';
import { FlightNetwork } from 'Network';
import { Popup } from 'Components/Popup';

interface IFlightListState {
	openChange: boolean;
	changingFlight: number;
}

export class FlightList extends React.Component<IFlightListProps, IFlightListState> {

	#api = new FlightNetwork();
	state: IFlightListState = {
		changingFlight: -1,
		openChange: false,
	};
	#rows: IFlight[] = [
		{
			date: (new Date()).getTime(),
			departure: 'Moscow',
			arrival: 'Tokyo',
			id: '123',
		},
		{
			date: (new Date()).getTime(),
			departure: 'Moscow',
			arrival: 'Tokyo',
			id: '123',
		},
		{
			date: (new Date()).getTime(),
			departure: 'Moscow',
			arrival: 'Tokyo',
			id: '123',
		},
	];

	rowHandler = (type: RowActions, internalId: number) => {
		console.log('click');
		switch (type) {
			case RowActions.kCancel:
				void this.#api.cancelFlight(internalId.toString());
				return;
			case RowActions.kChange:
				this.setState({ openChange: true, changingFlight: internalId.toString() });
		}
	};

	drawPopup() {
		const {changingFlight} = this.state;
		if (changingFlight)
		return (
			<Popup>
				<ChangeBook {...this.#rows[changingFlight]}/>
			</Popup>
		);
	}

	render() {
		const { openChange } = this.state;
		if (openChange) {
			this.drawPopup();
		}
		const rows = this.#rows;
		return (
			<TableContainer>
				<Table>
					<TableHead>
						<TableRow>
							<TableCell align="center">Номер рейса</TableCell>
							<TableCell align="left">Город отправления</TableCell>
							<TableCell align="left">Город прибытия</TableCell>
							<TableCell align="center">Дата</TableCell>
							<TableCell align="center">Действия</TableCell>
						</TableRow>
					</TableHead>
					<TableBody>
						{rows.sort((a, b) => a.date - b.date)
							.map((flight, idx) => (
								<ReservationRow key={idx} action={this.rowHandler} internalId={idx} {...flight}/>
							))}
					</TableBody>
				</Table>
			</TableContainer>
		);
	}
}
