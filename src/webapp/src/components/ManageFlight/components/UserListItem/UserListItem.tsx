import * as React from 'react';

import TableCell from '@material-ui/core/TableCell';
import TableRow from '@material-ui/core/TableRow';
import Button from '@material-ui/core/Button';
import DeleteIcon from '@material-ui/icons/Delete';

import * as s from 'Components/ReservationRow/ReservationRow.scss';

import { RowActions } from 'Components/FlightList';

export const UserListItem = (
	props: {
		lastName: string;
		orderId: string;
		idx: number;
		action: (type: RowActions, internalId: number) => void;
	},
) => {
	return (
		<TableRow className={s.reservationRow}>
			<TableCell>{props.lastName}</TableCell>
			<TableCell>
				<Button
					className={s.reservationRow__btn}
					variant="outlined"
					color="secondary"
					onClick={() => props.action(RowActions.kChange, props.idx)}
				>
					Изменить
				</Button>
				<Button
					className={s.reservationRow__btn}
					variant="outlined"
					startIcon={<DeleteIcon/>}
					onClick={() => props.action(RowActions.kCancel, props.idx)}
				>
					Отменить
				</Button>
			</TableCell>
		</TableRow>
	);
};
