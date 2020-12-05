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

	private onAddBtnClick() {
		this.setState({ openPage: Pages.kAddForm });
	}

	private detectPage() {
		const { openPage } = this.state;
		switch (openPage) {
			case Pages.kFlightList:
				return (
					<div>
						<FlightList/>
						<AddFlightBtn onClick={this.onAddBtnClick.bind(this)}/>
					</div>
				);
			case Pages.kAddForm:
				return (
					<AddForm
						onCancel={() => this.setState({ openPage: Pages.kFlightList })}
						onSubmit={(flight, pCount) => {
							console.log('state changed');
							this.setState({ openPage: Pages.kManageFlight });
						}}
					/>
				);
			case Pages.kManageFlight:
				return <ManageFlight/>;
			default:
				return <p>404 Page not found</p>;

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
