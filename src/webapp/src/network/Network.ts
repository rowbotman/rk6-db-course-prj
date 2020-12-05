export class Network {
	static fetchGet = async <T = {}>(path = '/', api = HOST) => {
		if (path.includes('undefined')) {
			throw new Error('Invalid path, boy');
		}
		const res = await fetch(`${api}/${path}`, {
			method: 'GET',
			credentials: 'include',
			headers: {},
		});
		return await res.json();
	};

	static fetchPost = async <T = {}>(path: string, body: T, api = HOST) => {
		if (path.includes('undefined')) {
			throw new Error('Invalid path, boy');
		}
		const res = await fetch(`${api}/${path}`, {
			method: 'POST',
			mode: 'cors',
			credentials: 'include',
			headers: {
				'Content-Type': 'application/json; charset=utf-8',
			},
			body: JSON.stringify(body),
		});
		return await res.json();
	};
}
