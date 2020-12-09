import * as React from 'react';

import TableRow from '@material-ui/core/TableRow';
import TableCell from '@material-ui/core/TableCell';
import Button from '@material-ui/core/Button';
import DeleteIcon from '@material-ui/icons/Delete';

import { RowActions } from 'Components/FlightList';

import { IFlight } from 'Interfaces';
import { parseDate } from 'Utils';

import * as s from './ReservationRow.scss';

interface IReservationRowProps extends IFlight {
	action: (type: RowActions, internalId: number) => void;
	internalId: number;
}

export const ReservationRow = (props: IReservationRowProps) => {
	return (
		<TableRow className={s.reservationRow}>
			<TableCell>{parseDate(props.date, true)}</TableCell>
			<TableCell>{props.departure}</TableCell>
			<TableCell>{props.arrival}</TableCell>
			<TableCell>{props.id}</TableCell>
			<TableCell>
				<Button
					className={s.reservationRow__btn}
					variant="outlined"
					color="secondary"
					onClick={() => props.action(RowActions.kChange, props.internalId)}
				>
					Изменить
				</Button>
				<Button
					className={s.reservationRow__btn}
					variant="outlined"
					startIcon={<DeleteIcon/>}
					onClick={() => props.action(RowActions.kCancel, props.internalId)}
				>
					Отменить
				</Button>
			</TableCell>
		</TableRow>
	);
};
