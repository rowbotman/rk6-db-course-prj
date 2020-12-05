import * as React from 'react';
import * as s from 'Components/AddForm/AddForm.scss';
import * as cn from 'classnames';
import TextField from '@material-ui/core/TextField';
import Button from '@material-ui/core/Button';
import Container from '@material-ui/core/Container';
import { IRow } from 'Components/AddForm/types';

import * as f from 'Styles/_font.scss';

export class ManageFlight extends React.Component<{}> {

	#myRef = React.createRef<HTMLFormElement>();
	#fields: IRow[] = [
		{
			desc: 'Фамилия',
			type: 'text',
			name: 'lastName',
		},
	];

	render(): JSX.Element {
		const pCountAvailable = 0;
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
						onClick={() => console.log('click submit')}
						disabled={pCountAvailable === 0}
					>
						Забронировать билет
					</Button>
					<Button
						className={s.addForm__btn}
						variant="contained"
						color="secondary"
						onClick={() => console.log('click cancel')}
					>
						Отмена
					</Button>
				</div>
			</Container>
		);
	}
}
