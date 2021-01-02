import { IMap } from 'Interfaces';

export const parseFromData = (form: HTMLFormElement): IMap => {
	const formData = new FormData(form);
	const input: IMap = {};
	formData.forEach((item, key) => {
		input[key] = item as string;
	});
	return input;
};
