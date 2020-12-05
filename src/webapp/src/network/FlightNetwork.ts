import { IMap } from 'Interfaces';
import { Network } from 'Network/Network';

export interface IFlight {
	passengers: number;
	flight: string;
	departure: string;
	arrival: string;
}

export class FlightNetwork {
	createFlight = async (data: IMap) => {
		const mediator: IFlight = {
			passengers: +data?.passengers,
			flight: (data?.flight || '') as string,
			arrival: (data?.arrival || '') as string,
			departure: (data?.departure || '') as string,
		};
		return await Network.fetchPost<IFlight>('api/flight', mediator);
	};
}
