import * as React from 'react';
import * as s from 'Components/AddForm/AddForm.scss';
import * as cn from 'classnames';
import TextField from '@material-ui/core/TextField';
import Button from '@material-ui/core/Button';
import Container from '@material-ui/core/Container';
import { IRow } from 'Components/AddForm/types';

import * as f from 'Styles/_font.scss';
import { BookingList } from 'Components/ManageFlight/components/BookingList/BookingList';
import { IBooking, IFlightChangeInfo } from 'Interfaces';
import { parseFromData } from 'Utils';
import { Api } from 'Network';
import { INetInteraction } from 'Interfaces/INetInteraction';

interface IManageFlightProps {
	flightId: string;
	pCount: number;
	onBack: () => void;
}

interface IManageFlightState extends INetInteraction {
	pCountAvailable: number;
	bookings: IBooking[];
}

export class ManageFlight extends React.Component<IManageFlightProps, IManageFlightState> {

	#myRef = React.createRef<HTMLFormElement>();
	#fields: IRow[] = [
		{
			desc: 'Фамилия',
			type: 'text',
			name: 'lastName',
		},
	];

	state: IManageFlightState = {
		pCountAvailable: this.props.pCount,
		bookings: [],
		error: false,
		loading: false,
	};

	#onBook = async () => {
		try {
			const parsed = parseFromData(this.#myRef.current);
			const info = parsed as unknown as IFlightChangeInfo;
			const res = await Api.flight.createBooking(info);
			console.log(res);
			if (res.hasOwnProperty('error')) {
				this.setState({ error: true, loading: false });
			} else {
				this.setState({
					bookings: [
						...this.state.bookings,
						res,
					],
					error: false,
					loading: false,
				});
				const input = this.#myRef.current.querySelector('input');
				input.value = '';
			}
		} catch (e) {
			console.error(e);
			this.setState({ error: true });
		}
	};

	render(): JSX.Element {
		const { pCountAvailable, bookings } = this.state;
		console.log(bookings);
		return (
			<Container className={s.addForm}>
				<div className={s.addForm__title}>
					<span className={cn(f.font, f.font_size_large, f.font_bold)}>Форма бронирования</span>
				</div>
				<form noValidate autoComplete="off" ref={this.#myRef}>
					{this.#fields.map(({ desc, type, name }, idx) => (
						<div className={s.addForm__grid} key={idx}>
							<div className={s.addForm__desc}>{desc}</div>
							<TextField
								name={name}
								type={type}
								className={s.addForm__input}
								size="small"
								variant="outlined"
							/>
						</div>
					))}
				</form>
				<div className={s.addForm__manage}>
					<Button
						className={s.addForm__btn}
						variant="contained"
						color="primary"
						onClick={this.#onBook}
						disabled={pCountAvailable === 0}
					>
						Забронировать билет
					</Button>
					<Button
						className={s.addForm__btn}
						variant="contained"
						color="secondary"
						onClick={this.props.onBack}
					>
						Завершить
					</Button>
				</div>
				<BookingList
					bookings={bookings}
					onDelete={(idx) => {
						bookings.splice(idx, 1)
						this.setState({
							bookings,
						});
					}}
					onChange={(idx, booking) => {
						bookings[idx] = booking;
						this.setState({ bookings });
					}}
				/>
			</Container>
		);
	}
}
