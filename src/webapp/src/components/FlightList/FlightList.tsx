import * as React from 'react';

import Table from '@material-ui/core/Table';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TableCell from '@material-ui/core/TableCell';
import TableBody from '@material-ui/core/TableBody';
import TableRow from '@material-ui/core/TableRow';

import { ReservationRow } from 'Components/ReservationRow';

import { FlightNetwork } from 'Network';

import { IFlight } from 'Interfaces';

import { IFlightListProps } from './types';
import { LinearProgress } from '@material-ui/core';

interface IFlightListState {
	rows: IFlight[];
	error: boolean;
	loading: boolean;
}

export class FlightList extends React.Component<IFlightListProps, IFlightListState> {

	#api = new FlightNetwork();
	state: IFlightListState = {
		rows: [],
		error: false,
		loading: true,
	};

	componentDidMount(): void {
		void this.#loadFlights();
	}

	#loadFlights = async () => {
		try {
			const data = await this.#api.loadUserFlights(this.props.userId);
			if (data) {
				this.setState({ rows: data.flights, loading: false });
			}
		} catch (e) {
			console.error(e);
			this.setState({ error: true, loading: false });
		}
	};

	render() {
		const { rows, loading } = this.state;
		if (loading) {
			return <LinearProgress/>;
		}
		return (
			<TableContainer>
				<Table>
					<TableHead>
						<TableRow>
							<TableCell align="center">Дата</TableCell>
							<TableCell align="center">Город отправления</TableCell>
							<TableCell align="center">Город прибытия</TableCell>
							<TableCell align="center">Номер рейса</TableCell>
						</TableRow>
					</TableHead>
					<TableBody>
						{rows.sort((a, b) => a.date - b.date)
							.map((flight, idx) => (
								<ReservationRow key={idx} internalId={idx} {...flight}/>
							))}
					</TableBody>
				</Table>
			</TableContainer>
		);
	}
}
