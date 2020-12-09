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
import { LinearProgress } from '@material-ui/core';

interface IFlightListState {
	openChange: boolean;
	changingFlight: number;
	rows: IFlight[];
	error: boolean;
	loading: boolean;
}

export class FlightList extends React.Component<IFlightListProps, IFlightListState> {

	#api = new FlightNetwork();
	state: IFlightListState = {
		changingFlight: -1,
		openChange: false,
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

	#rowHandler = async (type: RowActions, internalId: number) => {
		switch (type) {
			case RowActions.kCancel:
				try {
					await this.#api.cancelFlight(internalId.toString());
				} catch (e) {
					console.error(e);
				}
				return;
			case RowActions.kChange:
				this.setState({ openChange: true, changingFlight: internalId });
				return;
		}
	};

	drawPopup() {
		const { changingFlight } = this.state;
		if (changingFlight >= 0) {
			const { rows } = this.state;
			return (
				<Popup
					title={`Изменение бронирования ${rows[changingFlight].id}`}
					onClose={() => this.setState({ openChange: false, changingFlight: -1 })}
				>
					<ChangeBook
						onCancel={async () => {
							this.setState({ openChange: false, changingFlight: -1 });
							await this.#loadFlights();
						}}
						{...rows[changingFlight]}
					/>
				</Popup>
			);
		}
		return <></>;
	}

	render() {
		const { openChange } = this.state;
		const { rows, loading } = this.state;
		if (loading) {
			return <LinearProgress/>;
		}
		return (
			<TableContainer>
				{openChange && this.drawPopup()}
				<Table>
					<TableHead>
						<TableRow>
							<TableCell align="center">Дата</TableCell>
							<TableCell align="left">Город отправления</TableCell>
							<TableCell align="left">Город прибытия</TableCell>
							<TableCell align="center">Номер рейса</TableCell>
							{/*<TableCell align="center">Действия</TableCell>*/}
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
