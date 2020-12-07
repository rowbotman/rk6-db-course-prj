import * as React from 'react';

import Table from '@material-ui/core/Table';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TableCell from '@material-ui/core/TableCell';
import TableBody from '@material-ui/core/TableBody';
import TableRow from '@material-ui/core/TableRow';

import { ReservationRow } from 'Components/ReservationRow';
import { Popup } from 'Components/Popup';
import { ChangeBook } from 'Components/ChangeBook';

import { FlightNetwork } from 'Network';

import { IFlight } from 'Interfaces';

import { IFlightListProps, RowActions } from './types';

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

	#rowHandler = (type: RowActions, internalId: number) => {
		console.log('click');
		switch (type) {
			case RowActions.kCancel:
				void this.#api.cancelFlight(internalId.toString());
				return;
			case RowActions.kChange:
				this.setState({ openChange: true, changingFlight: internalId });
				return;
		}
	};

	drawPopup() {
		const { changingFlight } = this.state;
		console.log(changingFlight);
		if (changingFlight >= 0)
			return (
				<Popup title={`Изменение бронирования ${this.#rows[changingFlight].id}`}>
					<ChangeBook {...this.#rows[changingFlight]}/>
				</Popup>
			);
	}

	render() {
		const { openChange } = this.state;
		const rows = this.#rows;
		return (
			<TableContainer>
				{openChange && this.drawPopup()}
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
								<ReservationRow key={idx} action={this.#rowHandler} internalId={idx} {...flight}/>
							))}
					</TableBody>
				</Table>
			</TableContainer>
		);
	}
}
