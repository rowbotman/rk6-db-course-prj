import * as React from 'react';

import Table from '@material-ui/core/Table';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TableCell from '@material-ui/core/TableCell';
import TableBody from '@material-ui/core/TableBody';
import TableRow from '@material-ui/core/TableRow';

import { IFlight, IFlightListProps } from './types';

export class FlightList extends React.Component<IFlightListProps> {

	render() {
		const rows: IFlight[] = [
			{
				date: (new Date()).getTime() / 1000,
				departure: 'Moscow',
				arrival: 'Tokyo',
				id: '123',
			},
			{
				date: (new Date()).getTime() / 1000,
				departure: 'Moscow',
				arrival: 'Tokyo',
				id: '123',
			},
			{
				date: (new Date()).getTime() / 1000,
				departure: 'Moscow',
				arrival: 'Tokyo',
				id: '123',
			},
		];
		return (
			<TableContainer>
				<Table>
					<TableHead>
						<TableRow>
							<TableCell align="center">Номер рейса</TableCell>
							<TableCell align="left">Город отправления</TableCell>
							<TableCell align="left">Город прибытия</TableCell>
							<TableCell align="left">Дата</TableCell>
						</TableRow>
					</TableHead>
					<TableBody>
						{rows.sort((a, b) => a.date - b.date)
							.map((flight, id) => (
								<TableRow key={id}>
									<TableCell align="center" component="th" scope="row">{flight.id}</TableCell>
									<TableCell align="left">{flight.departure}</TableCell>
									<TableCell align="left">{flight.arrival}</TableCell>
									<TableCell align="left">{flight.date}</TableCell>
								</TableRow>
							))}
					</TableBody>
				</Table>
			</TableContainer>
		);
	}
}
