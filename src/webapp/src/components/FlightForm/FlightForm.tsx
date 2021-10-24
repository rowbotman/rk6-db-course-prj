import * as React from 'react';
import * as cn from 'classnames';
import * as s from 'Components/AddForm/AddForm.scss';
import { IRow, Status } from 'Components/AddForm/types';
import TextField from '@material-ui/core/TextField';
import Button from '@material-ui/core/Button';

export const FlightForm = (
	props: {
		myRef: React.Ref<HTMLFormElement>,
		status?: Status;
		fields: IRow[];
		onSubmit: () => void;
		onCancel: () => void;
	}) => {
	const { status, myRef } = props;
	return (
		<div className={cn(s.addForm__main, {
			[s.addForm__main_err]: status === Status.kErr,
			[s.addForm__main_warn]: status === Status.kWarn,
		})}>
			<form noValidate autoComplete="off" ref={myRef}>
				{props.fields.map(({ desc, type, name }, idx) => (
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
					onClick={props.onSubmit}
				>
					Подтвердить
				</Button>
				<Button
					className={s.addForm__btn}
					variant="contained"
					color="secondary"
					onClick={props.onCancel}
				>
					Отмена
				</Button>
			</div>
		</div>
	);
};
