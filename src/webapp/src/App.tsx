import * as React from 'react';

import { Container } from '@material-ui/core';

import { AddForm } from 'Components/AddForm';
import { AddFlightBtn } from 'Components/AddFlightBtn';
import { FlightList } from 'Components/FlightList';
import { Header } from 'Components/Header';


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
					<AddFlightBtn onClick={this.onAddBtnClick.bind(this)}/>
				</div>
			);
		} else if (openPage === 1) {
			return (
				<AddForm
					onCancel={() => this.setState({ openPage: 0 })}
					onSubmit={() => null}
				/>
			);
		}
	}

	render(): JSX.Element {
		return (
			<div className="main">
				<Header/>
				<Container maxWidth="sm">
					{this.detectPage()}
				</Container>
			</div>
		);
	}
}
