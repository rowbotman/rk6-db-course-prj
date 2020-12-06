import * as React from 'react';

import TableRow from '@material-ui/core/TableRow';
import TableCell from '@material-ui/core/TableCell';
import { IFlight } from 'Interfaces';
import Button from '@material-ui/core/Button';
import DeleteIcon from '@material-ui/icons/Delete';
import { parseDate } from 'Utils';
import { RowActions } from 'Components/FlightList';

interface IReservationRowProps extends IFlight {
	action: (type: RowActions, internalId: number) => void;
	internalId: number;
}

export const ReservationRow = (props: IReservationRowProps) => {
	return (
		<TableRow>
			<TableCell>{parseDate(props.date, true)}</TableCell>
			<TableCell>{props.departure}</TableCell>
			<TableCell>{props.arrival}</TableCell>
			<TableCell>{props.id}</TableCell>
			<TableCell>
				<Button onClick={() => props.action(RowActions.kChange, props.internalId)}>Изменить</Button>
				<Button
					variant="contained"
					color="secondary"
					startIcon={<DeleteIcon/>}
					onClick={() => props.action(RowActions.kCancel, props.internalId)}
				>
					Отменить
				</Button>
			</TableCell>
		</TableRow>
	);
};
