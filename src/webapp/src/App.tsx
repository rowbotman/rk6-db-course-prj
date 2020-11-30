import * as React from 'react';

import { AddForm } from 'Components/AddForm/AddForm.tsx';
import { AddFlightBtn } from 'Components/AddFlightBtn/AddFlightBtn.tsx';
import { FlightList } from 'Components/FlightList/FlightList.tsx';


interface IAppState {
	openPage: number;
}

interface IAppProps {
}

export class App extends React.Component<IAppProps, IAppState> {

	state: IAppState = {
		openPage: 0,
	};

	private onAddBtnClick() {
		this.setState({ openPage: 1 });
	}

	private detectPage() {
		const { openPage } = this.state;
		if (openPage === 0) {
			return (
				<div>
					<FlightList/>
					<AddFlightBtn onClick={this.onAddBtnClick}/>
				</div>
			);
		} else if (openPage === 1) {
			return (
				<AddForm/>
			);
		}
	}

	render(): JSX.Element {
		return (
			<div>
				{this.detectPage()}
			</div>
		);
	}
}
