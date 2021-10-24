import * as React from 'react';

import { IBooking, } from 'Interfaces';

import { UserListItem } from 'Components/ManageFlight/components/UserListItem';
import { RowActions } from 'Components/FlightList';
import { Api } from 'Network';
import Table from '@material-ui/core/Table';
import TableContainer from '@material-ui/core/TableContainer';
import TableBody from '@material-ui/core/TableBody';
import { Popup } from 'Components/Popup';
import { ChangeBook } from 'Components/ChangeBook';

export interface IBookingListProps {
	bookings: IBooking[];
	onDelete: (idx: number) => void;
	onChange: (idx: number, booking: IBooking) => void;
}

export interface IBookingListState {
	changing: number;
	openPopup: boolean;
	bookings: IBooking[];
}


export class BookingList extends React.Component<IBookingListProps, IBookingListState> {

	state: IBookingListState = {
		changing: -1,
		openPopup: false,
		bookings: this.props.bookings,
	};

	#rowHandler = async (type: RowActions, internalId: number) => {
		switch (type) {
			case RowActions.kCancel:
				let bookings = this.props.bookings;
				try {
					await Api.flight.cancelBooking(bookings[internalId].orderId);
					this.props.onDelete(internalId);
				} catch (e) {
					console.error(e);
				}
				return;
			case RowActions.kChange:
				this.setState({ openPopup: true, changing: internalId });
				return;
		}
	};

	private drawPopup() {
		const { changing } = this.state;
		if (changing >= 0) {
			const { bookings } = this.props;
			return (
				<Popup
					title={`Изменение бронирования ${bookings[changing].orderId}`}
					onClose={() => this.setState({ openPopup: false, changing: -1 })}
				>
					<ChangeBook
						onCancel={() => {
							this.setState({ openPopup: false, changing: -1 });
						}}
						onSubmit={(booking) => this.props?.onChange(changing, booking)}
						{...bookings[changing]}
					/>
				</Popup>
			);
		}
		return <></>;
	}

	render(): JSX.Element {
		const { openPopup } = this.state;
		return (
			<div className="booking-list">
				<TableContainer>
					{openPopup && this.drawPopup()}
					<Table>
						<TableBody>
							{this.props.bookings.map((booking, idx) => (
								<UserListItem key={idx} idx={idx} action={this.#rowHandler} {...booking}/>
							))}
						</TableBody>
					</Table>
				</TableContainer>
			</div>
		);
	}

}
