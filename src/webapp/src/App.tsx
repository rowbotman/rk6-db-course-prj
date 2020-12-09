import * as React from 'react';

import { Container } from '@material-ui/core';

import { AddForm } from 'Components/AddForm';
import { AddFlightBtn } from 'Components/AddFlightBtn';
import { Header } from 'Components/Header';
import { ManageFlight } from 'Components/ManageFlight';
import { FlightList } from 'Components/FlightList';

import { Pages } from 'Const';

interface IAppState {
	openPage: Pages;
	error: boolean;
}

interface IAppProps {
}

export class App extends React.Component<IAppProps, IAppState> {

	state: IAppState = {
		openPage: Pages.kFlightList,
		error: false,
	};
	pCount = 0;
	flightId = '';

	private onAddBtnClick() {
		this.setState({ openPage: Pages.kAddForm });
	}

	private detectPage() {
		const { openPage } = this.state;
		switch (openPage) {
			case Pages.kFlightList:
				return (
					<div>
						<AddFlightBtn onClick={this.onAddBtnClick.bind(this)}/>
						<FlightList userId={'100'}/>
					</div>
				);
			case Pages.kAddForm:
				return (
					<AddForm
						onCancel={() => this.setState({ openPage: Pages.kFlightList })}
						onSubmit={(flight, pCount) => {
							console.log('state changed');
							this.pCount = pCount;
							this.flightId = flight;
							this.setState({ openPage: Pages.kManageFlight });
						}}
					/>
				);
			case Pages.kManageFlight:
				return (
					<ManageFlight
						pCount={this.pCount}
						flightId={this.flightId}
						onBack={() => this.setState({ openPage: Pages.kFlightList })}
					/>
				);
			default:
				return <p>404 Page not found</p>;

		}
	}

	render(): JSX.Element {
		return (
			<div className="main">
				<Header/>
				<Container maxWidth="md">
					{this.detectPage()}
				</Container>
			</div>
		);
	}
}
