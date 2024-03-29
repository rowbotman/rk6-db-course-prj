import { IBooking, IFlight, IMap } from 'Interfaces';
import { Network } from 'Network/Network';
import { IFlightChangeInfo } from 'Interfaces/IFlightChangeInfo';

export interface IFlightNetworkRequestData {
	passengers: number;
	flight: string;
	departure: string;
	arrival: string;
}


export interface IFlightNetworkFlightsRequestData {
	flights: IFlight[];
}

export class FlightNetwork {
	createFlight = async (data: IMap) => {
		const mediator: IFlightNetworkRequestData = {
			passengers: +data?.passengers,
			flight: (data?.flight || '') as string,
			arrival: (data?.arrival || '') as string,
			departure: (data?.departure || '') as string,
		};
		return await Network.fetchPost<IFlightNetworkRequestData>('api/flight', mediator);
	};

	cancelBooking = async (orderId: string) => {
		return await Network.fetchDelete(`api/flight?orderId=${orderId}`);
	};

	loadUserFlights = async (userId: string) => {
		return await Network.fetchGet<{}, IFlightNetworkFlightsRequestData>(`api/user/order/?userId=${userId}`);
	};

	changeBooking = async (orderId: string, info: IFlightChangeInfo) => {
		return await Network.fetchPut<IFlightChangeInfo, IBooking>(`api/order/${orderId}`, info);
	};

	createBooking = async (info: IFlightChangeInfo) => {
		return await Network.fetchPost<IFlightChangeInfo, IBooking>(`api/order`, info);
	};
}
