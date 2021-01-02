import * as React from 'react';

import TableRow from '@material-ui/core/TableRow';
import TableCell from '@material-ui/core/TableCell';

import { IFlight } from 'Interfaces';
import { parseDate } from 'Utils';

import * as s from './ReservationRow.scss';

interface IReservationRowProps extends IFlight {
	internalId: number;
}

export const ReservationRow = (props: IReservationRowProps) => {
	return (
		<TableRow className={s.reservationRow}>
			<TableCell align="center">{parseDate(props.date, true)}</TableCell>
			<TableCell align="center">{props.departure}</TableCell>
			<TableCell align="center">{props.arrival}</TableCell>
			<TableCell align="center">{props.id}</TableCell>
		</TableRow>
	);
};
