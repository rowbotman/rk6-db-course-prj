export const parseDate = (timestamp: number, filled = false): string => {
	const obj = new Date(timestamp);
	const timeOnly = `${obj.getHours()}:${obj.getMinutes()}:${obj.getSeconds()}`;
	const date = `${obj.getDate()}/${obj.getMonth()}/${obj.getFullYear()}`;
	if (filled) {
		return `${timeOnly} ${date}`;
	}
	return timeOnly;
};
