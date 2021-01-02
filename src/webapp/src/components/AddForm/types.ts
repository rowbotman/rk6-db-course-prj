export interface IAddFormProps {
	onSubmit?: (flight: string, pCount: number) => void;
	onCancel?: () => void;
}

export const enum Status {
	kOK,
	kWarn,
	kErr,
}

export interface IAddFormSate {
	status: Status;
}

export interface IRow {
	desc: string;
	type: 'number' | 'text';
	name: string;
}

export const REQUIRED_FIELDS: IRow[] = [
	{
		desc: 'Город отправления',
		type: 'text',
		name: 'departure',
	},
	{
		desc: 'Город прибытия',
		type: 'text',
		name: 'arrival',
	},
	{
		desc: 'Номер рейса',
		type: 'text',
		name: 'flight',
	},
	{
		desc: 'Количество пассажиров',
		type: 'number',
		name: 'passengers',
	},
];
